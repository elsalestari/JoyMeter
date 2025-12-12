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

        return view('customer_satisfaction', compact(
            'stats',
            'satisfactionData',
            'categoryDistribution',
            'dailyHistory',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Export customer satisfaction statistics to PDF
     */
    public function exportPdf(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $stats = $this->getStatistics($startDate, $endDate);
        $satisfactionData = $this->getSatisfactionTrendData($startDate, $endDate);
        $categoryDistribution = $this->getCategoryDistribution($startDate, $endDate);
        $dailyHistory = $this->getDailySatisfactionHistory($startDate, $endDate);

        $pdf = Pdf::loadView('customer_satisfaction_pdf', compact(
            'stats',
            'satisfactionData',
            'categoryDistribution',
            'dailyHistory',
            'startDate',
            'endDate'
        ));

        $fileName = 'laporan-kepuasan-pelanggan-' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($fileName);
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

        // Kategori berdasarkan nilai satisfaction (0-100)
        $senang = (clone $query)->where('satisfaction', '>=', 70)->count();
        $netral = (clone $query)->whereBetween('satisfaction', [40, 69])->count();
        $tidakPuas = (clone $query)->where('satisfaction', '<', 40)->count();

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
     * Satisfaction trend data (percentage of Satisfied per period)
     */
    private function getSatisfactionTrendData(?string $startDate, ?string $endDate): array
    {
        $labels = [];
        $senangRates = [];

        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $daysDiff = $start->diffInDays($end);

            if ($daysDiff > 30) {
                $current = $start->copy()->startOfMonth();
                while ($current <= $end) {
                    $labels[] = $current->format('M Y');

                    $monthQuery = CustomerExpression::whereYear('ended_at', $current->year)
                        ->whereMonth('ended_at', $current->month);
                    $total = $monthQuery->count();
                    $senang = $monthQuery->where('satisfaction', '>=', 70)->count();

                    $senangRates[] = $total > 0 ? round(($senang / $total) * 100, 1) : 0;
                    $current->addMonth();
                }
            } else {
                $current = $start->copy();
                while ($current <= $end) {
                    $labels[] = $current->format('d M');

                    $dayQuery = CustomerExpression::whereDate('ended_at', $current->toDateString());
                    $total = $dayQuery->count();
                    $senang = $dayQuery->where('satisfaction', '>=', 70)->count();

                    $senangRates[] = $total > 0 ? round(($senang / $total) * 100, 1) : 0;
                    $current->addDay();
                }
            }
        } else {
            $firstRecord = CustomerExpression::orderBy('ended_at', 'asc')->first();

            if ($firstRecord) {
                $start = Carbon::parse($firstRecord->ended_at ?? $firstRecord->created_at)->startOfMonth();
                $end = Carbon::now()->endOfMonth();

                $current = $start->copy();
                while ($current <= $end) {
                    $labels[] = $current->format('M Y');

                    $monthQuery = CustomerExpression::whereYear('ended_at', $current->year)
                        ->whereMonth('ended_at', $current->month);
                    $total = $monthQuery->count();
                    $senang = $monthQuery->where('satisfaction', '>=', 70)->count();

                    $senangRates[] = $total > 0 ? round(($senang / $total) * 100, 1) : 0;
                    $current->addMonth();
                }
            }
        }

        return [
            'labels' => $labels,
            'senang_rates' => $senangRates,
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

        $senang = (clone $query)->where('satisfaction', '>=', 70)->count();
        $netral = (clone $query)->whereBetween('satisfaction', [40, 69])->count();
        $tidakPuas = (clone $query)->where('satisfaction', '<', 40)->count();

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
            ->selectRaw("SUM(CASE WHEN satisfaction >= 70 THEN 1 ELSE 0 END) as senang")
            ->selectRaw("SUM(CASE WHEN satisfaction BETWEEN 40 AND 69 THEN 1 ELSE 0 END) as netral")
            ->selectRaw("SUM(CASE WHEN satisfaction < 40 THEN 1 ELSE 0 END) as tidak_puas")
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
}