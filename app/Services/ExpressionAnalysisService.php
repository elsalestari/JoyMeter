<?php

namespace App\Services;

use App\Models\CustomerExpression;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ExpressionAnalysisService
{
    private function getWeights(): array
    {
        return config('satisfaction.weights');
    }

    private function getRanges(): array
    {
        return config('satisfaction.ranges');
    }

    /**
     * Mapping antara nama face-api.js dan internal system
     */
    private const EXPRESSION_MAP = [
        'happy' => 'happy',
        'sad' => 'sad',
        'angry' => 'angry',
        'surprised' => 'surprised',
        'neutral' => 'neutral',
        'fearful' => 'fear',
        'disgusted' => 'disgust',
    ];

    /**
     * Process dan save expression data
     */
    public function processAndSaveExpression(array $data): array
    {
        try {
            Log::info('🎬 Processing expression data', [
                'session_id' => $data['session_id'],
                'expressions_received' => $data['expressions']
            ]);

            // 1. Normalize expressions
            $expressions = $this->normalizeExpressions($data['expressions']);
            
            // 2. Validate expression data
            $this->validateExpressions($expressions);
            
            // 3. Calculate metrics
            $dominantEmotion = $this->getDominantEmotion($expressions);
            $satisfactionScore = $this->calculateSatisfaction($expressions);
            $category = $this->getSatisfactionCategory($satisfactionScore);
            
            // 4. Prepare data for storage
            $avgScores = $this->prepareAvgScores($expressions);
            
            Log::info('📊 Calculated metrics', [
                'dominant_emotion' => $dominantEmotion,
                'satisfaction_score' => $satisfactionScore,
                'category' => $category['name'],
                'avg_scores' => $avgScores,
                'expression_breakdown' => $this->getExpressionBreakdown($expressions)
            ]);
           
            // 5. Save to database
            $customerExpression = CustomerExpression::updateOrCreate(
                ['session_id' => $data['session_id']],
                [
                    'avg_scores' => $avgScores,
                    'dominant_emotion' => $dominantEmotion,
                    'satisfaction' => $satisfactionScore,
                    'started_at' => Carbon::parse($data['started_at']),
                    'ended_at' => $data['ended_at'] ? Carbon::parse($data['ended_at']) : Carbon::now(),
                    'notes' => $data['notes'] ?? $this->generateAutoNotes($expressions, $satisfactionScore),
                ]
            );

            Log::info('✅ Expression data saved successfully', [
                'id' => $customerExpression->id,
                'session_id' => $data['session_id'],
                'satisfaction_score' => $satisfactionScore,
                'dominant_emotion' => $dominantEmotion,
            ]);

            return [
                'success' => true,
                'data' => [
                    'id' => $customerExpression->id,
                    'session_id' => $customerExpression->session_id,
                    'dominant_emotion' => $dominantEmotion,
                    'satisfaction_score' => $satisfactionScore,
                    'satisfaction_category' => $category['name'],
                    'category_emoji' => $category['emoji'],
                    'interpretation' => $this->getScoreInterpretation($satisfactionScore),
                ]
            ];
        } catch (\Exception $e) {
            Log::error('❌ Failed to save expression data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'session_id' => $data['session_id'] ?? 'unknown',
                'data_received' => $data
            ]);
            
            throw $e;
        }
    }

    /**
     * Normalize expressions dari frontend ke format internal
     */
    private function normalizeExpressions(array $expressions): array
    {
        $normalized = [];

        foreach ($expressions as $key => $value) {
            $normalizedKey = self::EXPRESSION_MAP[$key] ?? $key;
            $normalized[$normalizedKey] = (float) $value;
        }

        $required = ['happy', 'sad', 'angry', 'surprised', 'neutral', 'fear', 'disgust'];
        foreach ($required as $emotion) {
            if (!isset($normalized[$emotion])) {
                $normalized[$emotion] = 0.0;
            }
        }
        
        return $normalized;
    }

    /**
     * Validate expression data
     */
    private function validateExpressions(array $expressions): void
    {
        $sum = array_sum($expressions);

        if ($sum < 0.95 || $sum > 1.05) {
            Log::warning('⚠️ Expression values sum is unusual', [
                'sum' => $sum,
                'expressions' => $expressions
            ]);
        }
        
        // Check for invalid values
        foreach ($expressions as $emotion => $value) {
            if ($value < 0 || $value > 1) {
                throw new \InvalidArgumentException(
                    "Invalid expression value for {$emotion}: {$value}. Must be between 0 and 1."
                );
            }
        }
    }

    /**
     * Get dominant emotion (ekspresi dengan nilai tertinggi)
     */
    private function getDominantEmotion(array $expressions): string
    {
        $maxScore = 0;
        $dominantEmotion = 'neutral';

        foreach ($expressions as $emotion => $score) {
            if ($score > $maxScore) {
                $maxScore = $score;
                $dominantEmotion = $emotion;
            }
        }

        return $dominantEmotion;
    }

    /**
     * Calculate satisfaction score (0-100) menggunakan weighted average
     */
    private function calculateSatisfaction(array $expressions): int
    {
        $weights = $this->getWeights();
        $weightedSum = 0;

        foreach ($weights as $emotion => $weight) {
            $score = $expressions[$emotion] ?? 0;
            $weightedSum += $score * $weight;
        }

        $satisfaction = ($weightedSum / 100) * 100;

        return min(100, max(0, (int) round($satisfaction)));
    }

    /**
     * Get satisfaction category berdasarkan score
     */
    private function getSatisfactionCategory(int $score): array
    {
        $ranges = $this->getRanges();
        $labels = config('satisfaction.labels');
        $emojis = config('satisfaction.emojis');

        foreach ($ranges as $key => $range) {
            if ($score >= $range['min'] && $score <= $range['max']) {
                return [
                    'name' => $labels[$key],
                    'emoji' => $emojis[$key],
                    'score' => $score,
                    'key' => $key,
                ];
            }
        }

        return [
            'name' => $labels['netral'],
            'emoji' => $emojis['netral'],
            'score' => $score,
            'key' => 'netral',
        ];
    }

    /**
     * Get detailed score interpretation
     */
    private function getScoreInterpretation(int $score): array
    {
        $interpretations = config('satisfaction.interpretation');
        
        foreach ($interpretations as $level => $config) {
            if ($score >= $config['min'] && $score <= $config['max']) {
                return [
                    'level' => $level,
                    'label' => $config['label'],
                    'color' => $config['color'],
                    'action' => $config['action'],
                ];
            }
        }
        
        return [
            'level' => 'unknown',
            'label' => 'Tidak Diketahui',
            'color' => 'gray',
            'action' => 'Perlu evaluasi',
        ];
    }

    /**
     * Prepare avg_scores untuk database
     */
    private function prepareAvgScores(array $expressions): array
    {
        return [
            'happy' => round($expressions['happy'] ?? 0, 4),
            'sad' => round($expressions['sad'] ?? 0, 4),
            'angry' => round($expressions['angry'] ?? 0, 4),
            'surprised' => round($expressions['surprised'] ?? 0, 4),
            'neutral' => round($expressions['neutral'] ?? 0, 4),
            'fear' => round($expressions['fear'] ?? 0, 4),
            'disgust' => round($expressions['disgust'] ?? 0, 4),
        ];
    }

    /**
     * Get expression breakdown untuk logging
     */
    private function getExpressionBreakdown(array $expressions): array
    {
        arsort($expressions);
        
        $breakdown = [];
        foreach ($expressions as $emotion => $value) {
            if ($value > 0.01) { 
                $breakdown[] = sprintf(
                    '%s: %.1f%%',
                    ucfirst($emotion),
                    $value * 100
                );
            }
        }
        
        return $breakdown;
    }

    /**
     * Generate automatic notes based on expressions
     */
    private function generateAutoNotes(array $expressions, int $score): string
    {
        $dominant = $this->getDominantEmotion($expressions);
        $category = $this->getSatisfactionCategory($score);
        
        $expressionLabels = config('satisfaction.expressions');
        $dominantLabel = $expressionLabels[$dominant]['label'] ?? ucfirst($dominant);
        
        $notes = sprintf(
            'Captured via camera - Staff: %s | Score: %d (%s) | Dominant: %s',
            auth()->user()->name,
            $score,
            $category['name'],
            $dominantLabel
        );
        
        return $notes;
    }

    /**
     * Validasi data ekspresi 
     */
    public function validateExpressionData(array $expressions): bool
    {
        try {
            $normalized = $this->normalizeExpressions($expressions);
            $this->validateExpressions($normalized);
            return true;
        } catch (\Exception $e) {
            Log::warning('Expression validation failed', [
                'error' => $e->getMessage(),
                'expressions' => $expressions
            ]);
            return false;
        }
    }

    /**
     * Generate unique session ID
     */
    public function generateSessionId(): string
    {
        $now = now();
        $dateStr = $now->format('Ymd');
        $timeStr = $now->format('His');
        $random = substr(md5(uniqid(mt_rand(), true)), 0, 8);
        
        return "SESSION_{$dateStr}_{$timeStr}_{$random}";
    }

    /**
     * Get statistics for expressions
     */
    public function getExpressionStats(array $expressions): array
    {
        $dominant = $this->getDominantEmotion($expressions);
        $score = $this->calculateSatisfaction($expressions);
        $category = $this->getSatisfactionCategory($score);
        
        // Calculate sentiment distribution
        $positive = ($expressions['happy'] ?? 0) + ($expressions['surprised'] ?? 0) * 0.5;
        $negative = ($expressions['sad'] ?? 0) + ($expressions['angry'] ?? 0) + 
                    ($expressions['fear'] ?? 0) + ($expressions['disgust'] ?? 0);
        $neutral = $expressions['neutral'] ?? 0;
        
        return [
            'dominant_emotion' => $dominant,
            'satisfaction_score' => $score,
            'category' => $category,
            'sentiment_distribution' => [
                'positive' => round($positive * 100, 1),
                'negative' => round($negative * 100, 1),
                'neutral' => round($neutral * 100, 1),
            ],
            'expression_diversity' => $this->calculateExpressionDiversity($expressions),
        ];
    }

    /**
     * Calculate expression diversity (entropy measure)
     */
    private function calculateExpressionDiversity(array $expressions): float
    {
        $entropy = 0;
        
        foreach ($expressions as $value) {
            if ($value > 0) {
                $entropy -= $value * log($value);
            }
        }
        
        return round($entropy / 1.95, 3);
    }
}