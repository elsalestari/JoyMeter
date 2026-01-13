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
    public function __construct()
    {
        $this->middleware(['auth', 'role:staff,admin']);
    }

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

        $ranges = config('satisfaction.ranges');

        $senang = (clone $query)
            ->where('satisfaction', '>=', $ranges['senang']['min'])
            ->count();
            
        $netral = (clone $query)
            ->whereBetween('satisfaction', [$ranges['netral']['min'], $ranges['netral']['max']])
            ->count();
            
        $tidakPuas = (clone $query)
            ->where('satisfaction', '<', $ranges['netral']['min'])
            ->count();

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

    private function getSatisfactionTrendData(?string $startDate, ?string $endDate): array
    {
        $labels = [];
        $senangCounts = [];
        $netralCounts = [];
        $tidakPuasCounts = [];
 
        $ranges = config('satisfaction.ranges');

        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $daysDiff = $start->diffInDays($end);

            if ($daysDiff > 30) {
                // Monthly data
                $current = $start->copy()->startOfMonth();
                while ($current <= $end) {
                    $labels[] = $current->format('M Y');

                    $senang = CustomerExpression::whereYear('ended_at', $current->year)
                        ->whereMonth('ended_at', $current->month)
                        ->where('satisfaction', '>=', $ranges['senang']['min'])
                        ->count();
                    
                    $netral = CustomerExpression::whereYear('ended_at', $current->year)
                        ->whereMonth('ended_at', $current->month)
                        ->whereBetween('satisfaction', [$ranges['netral']['min'], $ranges['netral']['max']])
                        ->count();
                    
                    $tidakPuas = CustomerExpression::whereYear('ended_at', $current->year)
                        ->whereMonth('ended_at', $current->month)
                        ->where('satisfaction', '<', $ranges['netral']['min'])
                        ->count();

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

                    $senang = CustomerExpression::whereDate('ended_at', $current->toDateString())
                        ->where('satisfaction', '>=', $ranges['senang']['min'])
                        ->count();
                    
                    $netral = CustomerExpression::whereDate('ended_at', $current->toDateString())
                        ->whereBetween('satisfaction', [$ranges['netral']['min'], $ranges['netral']['max']])
                        ->count();
                    
                    $tidakPuas = CustomerExpression::whereDate('ended_at', $current->toDateString())
                        ->where('satisfaction', '<', $ranges['netral']['min'])
                        ->count();

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

                    $senang = CustomerExpression::whereYear('ended_at', $current->year)
                        ->whereMonth('ended_at', $current->month)
                        ->where('satisfaction', '>=', $ranges['senang']['min'])
                        ->count();
                    
                    $netral = CustomerExpression::whereYear('ended_at', $current->year)
                        ->whereMonth('ended_at', $current->month)
                        ->whereBetween('satisfaction', [$ranges['netral']['min'], $ranges['netral']['max']])
                        ->count();
                    
                    $tidakPuas = CustomerExpression::whereYear('ended_at', $current->year)
                        ->whereMonth('ended_at', $current->month)
                        ->where('satisfaction', '<', $ranges['netral']['min'])
                        ->count();

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
            'tidak_puas_counts' => $tidakPuasCounts,
        ];
    }

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

        $ranges = config('satisfaction.ranges');

        $senang = (clone $query)
            ->where('satisfaction', '>=', $ranges['senang']['min'])
            ->count();
            
        $netral = (clone $query)
            ->whereBetween('satisfaction', [$ranges['netral']['min'], $ranges['netral']['max']])
            ->count();
            
        $tidakPuas = (clone $query)
            ->where('satisfaction', '<', $ranges['netral']['min'])
            ->count();

        return [
            'labels' => ['Senang', 'Netral', 'Tidak Puas'],
            'data' => [
                round(($senang / $total) * 100, 1),
                round(($netral / $total) * 100, 1),
                round(($tidakPuas / $total) * 100, 1),
            ],
        ];
    }

    private function getDailySatisfactionHistory(?string $startDate, ?string $endDate): array
    {
        $query = CustomerExpression::query();

        if ($startDate && $endDate) {
            $query->whereBetween('ended_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        }

        $ranges = config('satisfaction.ranges');

        $rows = $query
            ->selectRaw('DATE(ended_at) as date')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN satisfaction >= {$ranges['senang']['min']} THEN 1 ELSE 0 END) as senang")
            ->selectRaw("SUM(CASE WHEN satisfaction BETWEEN {$ranges['netral']['min']} AND {$ranges['netral']['max']} THEN 1 ELSE 0 END) as netral")
            ->selectRaw("SUM(CASE WHEN satisfaction < {$ranges['netral']['min']} THEN 1 ELSE 0 END) as tidak_puas")
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

        $ranges = config('satisfaction.ranges');

        $customerList = $customers->map(function ($customer, $index) use ($ranges) {
            if ($customer->satisfaction >= $ranges['senang']['min']) {
                $category = 'Senang';
                $emoji = '😊';
                $colorClass = 'bg-green-100 text-green-800';
            } elseif ($customer->satisfaction >= $ranges['netral']['min']) {
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