<?php

namespace App\Http\Controllers;

use App\Models\CustomerExpression;
use App\Services\ExpressionAnalysisService;
use App\Http\Requests\SaveExpressionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Carbon\Carbon;

class CameraSessionController extends Controller
{
    protected ExpressionAnalysisService $expressionService;

    public function __construct(ExpressionAnalysisService $expressionService)
    {
        $this->middleware(['auth', 'role:staff,admin']);
        $this->expressionService = $expressionService;
    }

    /**
     * Show camera session page
     */
    public function show(): View
    {
        $sessionId = $this->expressionService->generateSessionId();
        
        return view('camera.session', compact('sessionId'));
    }

    /**
     * Save facial expression data from camera
     */
    public function saveExpression(SaveExpressionRequest $request): JsonResponse
    {
        try {
            $result = $this->expressionService->processAndSaveExpression(
                $request->validated()
            );

            return response()->json($result, 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data ekspresi',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get active camera sessions (last 24 hours)
     */
    public function activeSessions(): JsonResponse
    {
        try {
            $sessions = CustomerExpression::where('created_at', '>=', Carbon::now()->subHours(24))
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($session) {
                    return [
                        'id' => $session->id,
                        'session_id' => $session->session_id,
                        'satisfaction_category' => $session->satisfaction_category,
                        'satisfaction_score' => $session->satisfaction,
                        'emoji' => $session->category_emoji,
                        'started_at' => $session->started_at->format('H:i:s'),
                        'duration' => $session->started_at->diffForHumans(),
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $sessions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch sessions',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get session statistics
     */
    public function sessionStats(): JsonResponse
    {
        try {
            $today = Carbon::today();
            
            $stats = [
                'today' => CustomerExpression::whereDate('created_at', $today)->count(),
                'this_week' => CustomerExpression::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
                'this_month' => CustomerExpression::whereMonth('created_at', $today->month)
                    ->whereYear('created_at', $today->year)
                    ->count(),
                'average_satisfaction' => CustomerExpression::whereDate('created_at', $today)
                    ->avg('satisfaction') ?? 0,
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch statistics',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
}