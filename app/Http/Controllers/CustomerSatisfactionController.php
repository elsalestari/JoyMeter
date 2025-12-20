<?php

namespace App\Http\Controllers;

use App\Models\CustomerExpression;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerSatisfactionController extends Controller
{
    /**
     * Apply middleware to restrict access
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:staff,admin']);
    }

    /**
     * Main page of the Customer Satisfaction menu
     */
    public function index(Request $request): View
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $stats = $this->getStatistics($startDate, $endDate);
        $satisfactionData = $this->getSatisfactionTrendData($startDate, $endDate);
        $categoryDistribution = $this->getCategoryDistribution($startDate, $endDate);
        $dailyHistory = $this->getDailySatisfactionHistory($startDate, $endDate);
        $customerList = $this->getCustomerList($startDate, $endDate);

        return view('customer-satisfaction.index', compact(
            'stats',
            'satisfactionData',
            'categoryDistribution',
            'dailyHistory',
            'customerList',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Export customer satisfaction statistics to PDF
     */
    public function exportPdf(Request $request)
    {
        try {
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');

            $stats = $this->getStatistics($startDate, $endDate);
            $satisfactionData = $this->getSatisfactionTrendData($startDate, $endDate);
            $categoryDistribution = $this->getCategoryDistribution($startDate, $endDate);
            $dailyHistory = $this->getDailySatisfactionHistory($startDate, $endDate);
            $customerList = $this->getCustomerList($startDate, $endDate);

            $pdf = Pdf::loadView('customer-satisfaction.pdf', compact(
                'stats',
                'satisfactionData',
                'categoryDistribution',
                'dailyHistory',
                'customerList',
                'startDate',
                'endDate'
            ));

            $pdf->setPaper('A4', 'portrait');
            
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'defaultFont' => 'DejaVu Sans',
                'enable_php' => false,
            ]);

            $fileName = 'Laporan-Kepuasan-Pelanggan-' . now()->format('Ymd-His') . '.pdf';

            return $pdf->download($fileName);
            
        } catch (\Exception $e) {
            \Log::error('PDF Export Error: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Gagal mengekspor PDF: ' . $e->getMessage());
        }
    }

    /**
     * Summary statistics on customer satisfaction
     * - Senang: ≥ 80 (very happy, big smile)
     * - Netral: 45-79 (slight smile)
     * - Tidak Puas: < 45 (flat face)
     */
    private function getStatistics(?string $startDate, ?string $endDate): array
    {
        $query = CustomerExpression::query();

        if ($startDate && $endDate) {
            $query->whereBetween('ended_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        }

        $total = $query->count();

        $senang = (clone $query)->where('satisfaction', '>=', 80)->count();
        $netral = (clone $query)->whereBetween('satisfaction', [45, 79])->count();
        $tidakPuas = (clone $query)->where('satisfaction', '<', 45)->count();

        $senangRate = $total > 0 ? ($senang / $total) * 100 : 0;
        $netralRate = $total > 0 ? ($netral / $total) * 100 : 0;
        $tidakPuasRate = $total > 0 ? ($tidakPuas / $total) * 100 : 0;

        return [
            'total_customers' => $total,
            'senang_count' => $senang,
            'netral_count' => $netral,
            'tidak_puas_count' => $tidakPuas,
            'senang_rate' => round($senangRate, 1),
            'netral_rate' => round($netralRate, 1),
            'tidak_puas_rate' => round($tidakPuasRate, 1),
        ];
    }

    /**
     * Satisfaction trend data (count of each category per period)
     */
    private function getSatisfactionTrendData(?string $startDate, ?string $endDate): array
    {
        $labels = [];
        $senangCounts = [];
        $netralCounts = [];
        $tidakPuasCounts = [];

        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $daysDiff = $start->diffInDays($end);

            if ($daysDiff > 30) {
                // Monthly data
                $current = $start->copy()->startOfMonth();
                while ($current <= $end) {
                    $labels[] = $current->format('M Y');

                    $monthQuery = CustomerExpression::whereYear('ended_at', $current->year)
                        ->whereMonth('ended_at', $current->month);
                    
                    $senang = (clone $monthQuery)->where('satisfaction', '>=', 80)->count();
                    $netral = (clone $monthQuery)->whereBetween('satisfaction', [45, 79])->count();
                    $tidakPuas = (clone $monthQuery)->where('satisfaction', '<', 45)->count();

                    $senangCounts[] = $senang;
                    $netralCounts[] = $netral;
                    $tidakPuasCounts[] = $tidakPuas;
                    
                    $current->addMonth();
                }
            } else {
                // Daily data
                $current = $start->copy();
                while ($current <= $end) {
                    $labels[] = $current->format('d M');

                    $dayQuery = CustomerExpression::whereDate('ended_at', $current->toDateString());
                    
                    $senang = (clone $dayQuery)->where('satisfaction', '>=', 80)->count();
                    $netral = (clone $dayQuery)->whereBetween('satisfaction', [45, 79])->count();
                    $tidakPuas = (clone $dayQuery)->where('satisfaction', '<', 45)->count();

                    $senangCounts[] = $senang;
                    $netralCounts[] = $netral;
                    $tidakPuasCounts[] = $tidakPuas;
                    
                    $current->addDay();
                }
            }
        } else {
            // All-time monthly data
            $firstRecord = CustomerExpression::orderBy('ended_at', 'asc')->first();

            if ($firstRecord) {
                $start = Carbon::parse($firstRecord->ended_at ?? $firstRecord->created_at)->startOfMonth();
                $end = Carbon::now()->endOfMonth();

                $current = $start->copy();
                while ($current <= $end) {
                    $labels[] = $current->format('M Y');

                    $monthQuery = CustomerExpression::whereYear('ended_at', $current->year)
                        ->whereMonth('ended_at', $current->month);
                    
                    $senang = (clone $monthQuery)->where('satisfaction', '>=', 80)->count();
                    $netral = (clone $monthQuery)->whereBetween('satisfaction', [45, 79])->count();
                    $tidakPuas = (clone $monthQuery)->where('satisfaction', '<', 45)->count();

                    $senangCounts[] = $senang;
                    $netralCounts[] = $netral;
                    $tidakPuasCounts[] = $tidakPuas;
                    
                    $current->addMonth();
                }
            }
        }

        $senangRates = [];
        foreach ($senangCounts as $index => $senangCount) {
            $total = $senangCounts[$index] + $netralCounts[$index] + $tidakPuasCounts[$index];
            $senangRates[] = $total > 0 ? round(($senangCount / $total) * 100, 1) : 0;
        }

        return [
            'labels' => $labels,
            'senang_rates' => $senangRates, 
            'senang_counts' => $senangCounts, 
            'netral_counts' => $netralCounts, 
        ];
    }

    /**
     * Distribution of satisfaction categories (Senang, Netral, Tidak Puas)
     */
    private function getCategoryDistribution(?string $startDate, ?string $endDate): array
    {
        $query = CustomerExpression::query();

        if ($startDate && $endDate) {
            $query->whereBetween('ended_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        }

        $total = $query->count();

        if ($total === 0) {
            return [
                'labels' => ['Senang', 'Netral', 'Tidak Puas'],
                'data' => [0, 0, 0],
            ];
        }

        $senang = (clone $query)->where('satisfaction', '>=', 80)->count();
        $netral = (clone $query)->whereBetween('satisfaction', [45, 79])->count();
        $tidakPuas = (clone $query)->where('satisfaction', '<', 45)->count();

        return [
            'labels' => ['Senang', 'Netral', 'Tidak Puas'],
            'data' => [
                round(($senang / $total) * 100, 1),
                round(($netral / $total) * 100, 1),
                round(($tidakPuas / $total) * 100, 1),
            ],
        ];
    }

    /**
     * Daily satisfaction history (maximum of the last 20 days)
     */
    private function getDailySatisfactionHistory(?string $startDate, ?string $endDate): array
    {
        $query = CustomerExpression::query();

        if ($startDate && $endDate) {
            $query->whereBetween('ended_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        }

        $rows = $query
            ->selectRaw('DATE(ended_at) as date')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN satisfaction >= 80 THEN 1 ELSE 0 END) as senang")
            ->selectRaw("SUM(CASE WHEN satisfaction BETWEEN 45 AND 79 THEN 1 ELSE 0 END) as netral")
            ->selectRaw("SUM(CASE WHEN satisfaction < 45 THEN 1 ELSE 0 END) as tidak_puas")
            ->groupBy(DB::raw('DATE(ended_at)'))
            ->orderByDesc('date')
            ->limit(20)
            ->get();

        return $rows->map(function ($row) {
            $senangRate = $row->total > 0 ? round(($row->senang / $row->total) * 100, 1) : 0;

            return [
                'date' => Carbon::parse($row->date)->format('d M Y'),
                'raw_date' => $row->date,
                'total' => (int) $row->total,
                'senang' => (int) $row->senang,
                'netral' => (int) $row->netral,
                'tidak_puas' => (int) $row->tidak_puas,
                'senang_rate' => $senangRate,
            ];
        })->toArray();
    }

    /**
     * Get individual customer list with details
     */
    private function getCustomerList(?string $startDate, ?string $endDate): array
    {
        $query = CustomerExpression::query();

        if ($startDate && $endDate) {
            $query->whereBetween('ended_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        }

        $customers = $query
            ->orderBy('ended_at', 'asc') 
            ->limit(50) 
            ->get();

        $customerList = $customers->map(function ($customer, $index) {
            if ($customer->satisfaction >= 80) {
                $category = 'Senang';
                $emoji = '😊';
                $colorClass = 'bg-green-100 text-green-800';
            } elseif ($customer->satisfaction >= 45) {
                $category = 'Netral';
                $emoji = '😐';
                $colorClass = 'bg-yellow-100 text-yellow-800';
            } else {
                $category = 'Tidak Puas';
                $emoji = '😞';
                $colorClass = 'bg-red-100 text-red-800';
            }

            return [
                'number' => $index + 1, 
                'session_id' => $customer->session_id,
                'date' => $customer->ended_at->format('d M Y'),
                'time' => $customer->ended_at->format('H:i:s'),
                'satisfaction_score' => $customer->satisfaction,
                'category' => $category,
                'emoji' => $emoji,
                'color_class' => $colorClass,
                'dominant_emotion' => $customer->dominant_emotion,
                'emotion_label' => $customer->emotion_label,
                'duration' => $customer->started_at && $customer->ended_at 
                    ? $customer->started_at->diffInSeconds($customer->ended_at) 
                    : 0,
                'notes' => $customer->notes,
            ];
        })->toArray();

        return array_reverse($customerList, false);
    }
}