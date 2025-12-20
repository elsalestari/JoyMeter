<?php

namespace App\Http\Controllers;

use App\Models\CustomerExpression;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CameraSessionController extends Controller
{
    /**
     * Apply middleware to restrict access
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:staff,admin']);
    }

    /**
     * Show camera session page
     */
    public function show(): View
    {
        return view('camera.session');
    }

    /**
     * Save facial expression data from camera
     */
    public function saveExpression(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'session_id' => 'required|string|max:255',
            'expressions' => 'required|array',
            'expressions.happy' => 'required|numeric|min:0|max:1',
            'expressions.sad' => 'required|numeric|min:0|max:1',
            'expressions.angry' => 'required|numeric|min:0|max:1',
            'expressions.surprised' => 'required|numeric|min:0|max:1',
            'expressions.neutral' => 'required|numeric|min:0|max:1',
            'expressions.fearful' => 'required|numeric|min:0|max:1',
            'expressions.disgusted' => 'required|numeric|min:0|max:1',
            'started_at' => 'required|date',
            'ended_at' => 'nullable|date|after:started_at',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $expressions = $request->expressions;
            
            // Calculate dominant emotion
            $dominantEmotion = $this->getDominantEmotion($expressions);
            
            // Calculate satisfaction score (0-100)
            $satisfactionScore = $this->calculateSatisfaction($expressions);
            
            // Prepare avg_scores untuk database
            $avgScores = [
                'happy' => round($expressions['happy'], 4),
                'sad' => round($expressions['sad'], 4),
                'angry' => round($expressions['angry'], 4),
                'surprised' => round($expressions['surprised'], 4),
                'neutral' => round($expressions['neutral'], 4),
                'fear' => round($expressions['fearful'], 4),
                'disgust' => round($expressions['disgusted'], 4),
            ];
            
            // Create or update customer expression
            $customerExpression = CustomerExpression::updateOrCreate(
                ['session_id' => $request->session_id],
                [
                    'avg_scores' => $avgScores,
                    'dominant_emotion' => $dominantEmotion,
                    'satisfaction' => $satisfactionScore,
                    'started_at' => Carbon::parse($request->started_at),
                    'ended_at' => $request->ended_at ? Carbon::parse($request->ended_at) : Carbon::now(),
                    'notes' => 'Captured via camera - Staff: ' . auth()->user()->name,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Expression data saved successfully',
                'data' => [
                    'id' => $customerExpression->id,
                    'session_id' => $customerExpression->session_id,
                    'dominant_emotion' => $dominantEmotion,
                    'satisfaction_score' => $satisfactionScore,
                    'satisfaction_category' => $customerExpression->satisfaction_category,
                    'category_emoji' => $customerExpression->category_emoji,
                ]
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save expression data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get active camera sessions
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
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get dominant emotion from expression scores
     */
    private function getDominantEmotion(array $expressions): string
    {
        $emotionMap = [
            'happy' => 'happy',
            'sad' => 'sad',
            'angry' => 'angry',
            'surprised' => 'surprised',
            'neutral' => 'neutral',
            'fearful' => 'fear',
            'disgusted' => 'disgust',
        ];

        $maxScore = 0;
        $dominantEmotion = 'neutral';

        foreach ($expressions as $emotion => $score) {
            if ($score > $maxScore) {
                $maxScore = $score;
                $dominantEmotion = $emotionMap[$emotion] ?? 'neutral';
            }
        }

        return $dominantEmotion;
    }

    /**
     * Calculate satisfaction score (0-100) based on emotion weights
     * - Senang: ≥ 80 (very happy, big smile with teeth showing)
     * - Netral: 45-79 (slight smile, no teeth showing)
     * - Tidak Puas: < 45 (flat face, no smile)
     */
    private function calculateSatisfaction(array $expressions): int
    {
        $satisfaction = (
            ($expressions['happy'] * 120) +           
            ($expressions['surprised'] * 60) +      
            ($expressions['neutral'] * 25) +         
            ($expressions['sad'] * 15) +              
            ($expressions['fearful'] * 10) +          
            ($expressions['angry'] * 5) +             
            ($expressions['disgusted'] * 3)           
        );

        return min(100, max(0, (int) round($satisfaction)));
    }
}