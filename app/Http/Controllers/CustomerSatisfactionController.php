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
     * Halaman utama menu Kepuasan Pelanggan.
     */
    public function index(Request $request): View|RedirectResponse
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Akses ditolak. Hanya staff yang dapat mengakses menu ini.');
        }

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
     * Export statistik kepuasan pelanggan ke PDF.
     */
    public function exportPdf(Request $request)
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Akses ditolak. Hanya staff yang dapat mengakses menu ini.');
        }

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
     * Statistik ringkas kepuasan pelanggan.
     */
    private function getStatistics(?string $startDate, ?string $endDate): array
    {
        $query = CustomerExpression::query();

        if ($startDate && $endDate) {
            $query->whereBetween('detected_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        }

        $total = $query->count();

        $senangEmotions = CustomerExpression::getEmotionsByCategory('senang');
        $netralEmotions = CustomerExpression::getEmotionsByCategory('netral');
        $tidakPuasEmotions = CustomerExpression::getEmotionsByCategory('tidak puas');

        $senang = (clone $query)->whereIn('emotion', $senangEmotions)->count();
        $netral = (clone $query)->whereIn('emotion', $netralEmotions)->count();
        $tidakPuas = (clone $query)->whereIn('emotion', $tidakPuasEmotions)->count();

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
     * Data tren kepuasan (persentase Senang per periode).
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

                    $monthQuery = CustomerExpression::whereYear('detected_at', $current->year)
                        ->whereMonth('detected_at', $current->month);
                    $total = $monthQuery->count();
                    $senangEmotions = CustomerExpression::getEmotionsByCategory('senang');
                    $senang = $monthQuery->whereIn('emotion', $senangEmotions)->count();

                    $senangRates[] = $total > 0 ? round(($senang / $total) * 100, 1) : 0;
                    $current->addMonth();
                }
            } else {
                $current = $start->copy();
                while ($current <= $end) {
                    $labels[] = $current->format('d M');

                    $dayQuery = CustomerExpression::whereDate('detected_at', $current->toDateString());
                    $total = $dayQuery->count();
                    $senangEmotions = CustomerExpression::getEmotionsByCategory('senang');
                    $senang = $dayQuery->whereIn('emotion', $senangEmotions)->count();

                    $senangRates[] = $total > 0 ? round(($senang / $total) * 100, 1) : 0;
                    $current->addDay();
                }
            }
        } else {
            $firstRecord = CustomerExpression::orderBy('detected_at', 'asc')->first();

            if ($firstRecord) {
                $start = Carbon::parse($firstRecord->detected_at)->startOfMonth();
                $end = Carbon::now()->endOfMonth();

                $current = $start->copy();
                while ($current <= $end) {
                    $labels[] = $current->format('M Y');

                    $monthQuery = CustomerExpression::whereYear('detected_at', $current->year)
                        ->whereMonth('detected_at', $current->month);
                    $total = $monthQuery->count();
                    $senangEmotions = CustomerExpression::getEmotionsByCategory('senang');
                    $senang = $monthQuery->whereIn('emotion', $senangEmotions)->count();

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
     * Distribusi kategori kepuasan (Senang, Netral, Tidak Puas).
     */
    private function getCategoryDistribution(?string $startDate, ?string $endDate): array
    {
        $query = CustomerExpression::query();

        if ($startDate && $endDate) {
            $query->whereBetween('detected_at', [
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

        $senangEmotions = CustomerExpression::getEmotionsByCategory('senang');
        $netralEmotions = CustomerExpression::getEmotionsByCategory('netral');
        $tidakPuasEmotions = CustomerExpression::getEmotionsByCategory('tidak puas');

        $senang = (clone $query)->whereIn('emotion', $senangEmotions)->count();
        $netral = (clone $query)->whereIn('emotion', $netralEmotions)->count();
        $tidakPuas = (clone $query)->whereIn('emotion', $tidakPuasEmotions)->count();

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
     * Riwayat kepuasan per hari (maksimal 20 hari terakhir).
     */
    private function getDailySatisfactionHistory(?string $startDate, ?string $endDate): array
    {
        $query = CustomerExpression::query();

        if ($startDate && $endDate) {
            $query->whereBetween('detected_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        }

        $rows = $query
            ->selectRaw('DATE(detected_at) as date')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN emotion IN ('" . implode("','", CustomerExpression::getEmotionsByCategory('senang')) . "') THEN 1 ELSE 0 END) as senang")
            ->selectRaw("SUM(CASE WHEN emotion IN ('" . implode("','", CustomerExpression::getEmotionsByCategory('netral')) . "') THEN 1 ELSE 0 END) as netral")
            ->selectRaw("SUM(CASE WHEN emotion IN ('" . implode("','", CustomerExpression::getEmotionsByCategory('tidak puas')) . "') THEN 1 ELSE 0 END) as tidak_puas")
            ->groupBy(DB::raw('DATE(detected_at)'))
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

