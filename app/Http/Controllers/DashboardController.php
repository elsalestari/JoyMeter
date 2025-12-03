<?php

namespace App\Http\Controllers;

use App\Models\CustomerExpression;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(Request $request): View|RedirectResponse
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Akses ditolak. Hanya staff yang dapat mengakses dashboard.');
        }

        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $stats = $this->getStatistics($startDate, $endDate);
        
        $satisfactionData = $this->getSatisfactionTrendData($startDate, $endDate);
        $categoryDistribution = $this->getCategoryDistribution($startDate, $endDate);
        $dominantExpression = $this->getDominantExpression($startDate, $endDate);
        
        $monthlyHistory = $this->getMonthlySatisfactionHistory($startDate, $endDate);

        $staffActivities = User::where('role', 'staff')
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'satisfactionData',
            'categoryDistribution',
            'stats',
            'monthlyHistory',
            'staffActivities',
            'dominantExpression',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Get statistics with date filter (null = all data)
     */
    private function getStatistics(?string $startDate, ?string $endDate): array
    {
        $query = CustomerExpression::query();
        
        if ($startDate && $endDate) {
            $query->whereBetween('detected_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        $total = $query->count();
        
        $today = CustomerExpression::whereDate('detected_at', today())->count();
        
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
            'customers_today' => $today,
            'senang_count' => $senang,
            'netral_count' => $netral,
            'tidak_puas_count' => $tidakPuas,
            'senang_rate' => round($senangRate, 1),
            'netral_rate' => round($netralRate, 1),
            'tidak_puas_rate' => round($tidakPuasRate, 1),
        ];
    }

    /**
     * Get satisfaction trend data (percentage of Senang per period)
     * If dates are null, show monthly data from first record to now
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
     * Get category distribution (3 categories)
     */
    private function getCategoryDistribution(?string $startDate, ?string $endDate): array
    {
        $query = CustomerExpression::query();
        
        if ($startDate && $endDate) {
            $query->whereBetween('detected_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        $total = $query->count();
        
        if ($total == 0) {
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
     * Get dominant expression
     */
    private function getDominantExpression(?string $startDate, ?string $endDate): array
    {
        $query = CustomerExpression::query();
        
        if ($startDate && $endDate) {
            $query->whereBetween('detected_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }
        
        $expressionCounts = (clone $query)
            ->select('emotion', DB::raw('count(*) as count'))
            ->groupBy('emotion')
            ->orderBy('count', 'desc')
            ->first();

        if (!$expressionCounts) {
            return [
                'emotion' => '-',
                'emotion_label' => '-',
                'emotion_emoji' => '😐',
                'count' => 0,
                'percentage' => 0,
            ];
        }

        $total = $query->count();
        
        $tempExpression = new CustomerExpression(['emotion' => $expressionCounts->emotion]);

        return [
            'emotion' => $expressionCounts->emotion,
            'emotion_label' => $tempExpression->emotion_label,
            'emotion_emoji' => $tempExpression->emotion_emoji,
            'count' => $expressionCounts->count,
            'percentage' => round(($expressionCounts->count / $total) * 100, 1),
        ];
    }

    /**
     * Get monthly satisfaction history
     * If dates are null, show all months from first record to now
     */
    private function getMonthlySatisfactionHistory(?string $startDate, ?string $endDate): array
    {
        $history = [];
        
        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfMonth();
            $end = Carbon::parse($endDate)->endOfMonth();
        } else {
            $firstRecord = CustomerExpression::orderBy('detected_at', 'asc')->first();
            
            if (!$firstRecord) {
                return [];
            }
            
            $start = Carbon::parse($firstRecord->detected_at)->startOfMonth();
            $end = Carbon::now()->endOfMonth();
        }
        
        $current = $start->copy();

        while ($current <= $end) {
            $monthStart = $current->copy()->startOfMonth();
            $monthEnd = $current->copy()->endOfMonth();
            
            $query = CustomerExpression::whereBetween('detected_at', [
                $monthStart,
                $monthEnd
            ]);

            $total = $query->count();
            $senangEmotions = CustomerExpression::getEmotionsByCategory('senang');
            $netralEmotions = CustomerExpression::getEmotionsByCategory('netral');
            $tidakPuasEmotions = CustomerExpression::getEmotionsByCategory('tidak puas');
            
            $senang = $query->whereIn('emotion', $senangEmotions)->count();
            $netral = $query->whereIn('emotion', $netralEmotions)->count();
            $tidakPuas = $query->whereIn('emotion', $tidakPuasEmotions)->count();
            
            $senangRate = $total > 0 ? round(($senang / $total) * 100, 1) : 0;

            $history[] = [
                'month' => $current->format('F Y'),
                'month_short' => $current->format('M Y'),
                'start_date' => $monthStart->toDateString(),
                'end_date' => $monthEnd->toDateString(),
                'total' => $total,
                'senang' => $senang,
                'netral' => $netral,
                'tidak_puas' => $tidakPuas,
                'senang_rate' => $senangRate,
            ];

            $current->addMonth();
        }

        return $history;
    }
}
