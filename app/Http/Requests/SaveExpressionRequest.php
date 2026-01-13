<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SaveExpressionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasRole(['staff', 'admin']);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'session_id' => [
                'required',
                'string',
                'max:255',
                'regex:/^SESSION_\d{8}_\d{6}_[a-f0-9]{8}$/',
            ],
            
            // Expressions array dengan 7 ekspresi
            'expressions' => 'required|array|size:7',
            'expressions.happy' => 'required|numeric|min:0|max:1',
            'expressions.sad' => 'required|numeric|min:0|max:1',
            'expressions.angry' => 'required|numeric|min:0|max:1',
            'expressions.surprised' => 'required|numeric|min:0|max:1',
            'expressions.neutral' => 'required|numeric|min:0|max:1',
            'expressions.fearful' => 'required|numeric|min:0|max:1',
            'expressions.disgusted' => 'required|numeric|min:0|max:1',
            
            'started_at' => 'required|date|before_or_equal:now',
            'ended_at' => 'nullable|date|after:started_at|before_or_equal:now',
            
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'session_id.required' => 'Session ID wajib diisi.',
            'session_id.regex' => 'Format Session ID tidak valid. Harus: SESSION_YYYYMMDD_HHMMSS_xxxxxxxx',
            
            'expressions.required' => 'Data ekspresi wajib diisi.',
            'expressions.array' => 'Data ekspresi harus berupa array.',
            'expressions.size' => 'Data ekspresi harus memiliki 7 nilai (happy, sad, angry, surprised, neutral, fearful, disgusted).',
            
            'expressions.happy.required' => 'Nilai ekspresi happy wajib diisi.',
            'expressions.happy.numeric' => 'Nilai ekspresi happy harus berupa angka.',
            'expressions.happy.min' => 'Nilai ekspresi happy tidak boleh kurang dari 0.',
            'expressions.happy.max' => 'Nilai ekspresi happy tidak boleh lebih dari 1.',
            
            'expressions.sad.required' => 'Nilai ekspresi sad wajib diisi.',
            'expressions.sad.numeric' => 'Nilai ekspresi sad harus berupa angka.',
            'expressions.sad.min' => 'Nilai ekspresi sad tidak boleh kurang dari 0.',
            'expressions.sad.max' => 'Nilai ekspresi sad tidak boleh lebih dari 1.',
            
            'expressions.angry.required' => 'Nilai ekspresi angry wajib diisi.',
            'expressions.angry.numeric' => 'Nilai ekspresi angry harus berupa angka.',
            'expressions.angry.min' => 'Nilai ekspresi angry tidak boleh kurang dari 0.',
            'expressions.angry.max' => 'Nilai ekspresi angry tidak boleh lebih dari 1.',
            
            'expressions.surprised.required' => 'Nilai ekspresi surprised wajib diisi.',
            'expressions.surprised.numeric' => 'Nilai ekspresi surprised harus berupa angka.',
            'expressions.surprised.min' => 'Nilai ekspresi surprised tidak boleh kurang dari 0.',
            'expressions.surprised.max' => 'Nilai ekspresi surprised tidak boleh lebih dari 1.',
            
            'expressions.neutral.required' => 'Nilai ekspresi neutral wajib diisi.',
            'expressions.neutral.numeric' => 'Nilai ekspresi neutral harus berupa angka.',
            'expressions.neutral.min' => 'Nilai ekspresi neutral tidak boleh kurang dari 0.',
            'expressions.neutral.max' => 'Nilai ekspresi neutral tidak boleh lebih dari 1.',
            
            'expressions.fearful.required' => 'Nilai ekspresi fearful wajib diisi.',
            'expressions.fearful.numeric' => 'Nilai ekspresi fearful harus berupa angka.',
            'expressions.fearful.min' => 'Nilai ekspresi fearful tidak boleh kurang dari 0.',
            'expressions.fearful.max' => 'Nilai ekspresi fearful tidak boleh lebih dari 1.',
            
            'expressions.disgusted.required' => 'Nilai ekspresi disgusted wajib diisi.',
            'expressions.disgusted.numeric' => 'Nilai ekspresi disgusted harus berupa angka.',
            'expressions.disgusted.min' => 'Nilai ekspresi disgusted tidak boleh kurang dari 0.',
            'expressions.disgusted.max' => 'Nilai ekspresi disgusted tidak boleh lebih dari 1.',
            
            'started_at.required' => 'Waktu mulai wajib diisi.',
            'started_at.date' => 'Waktu mulai harus berupa tanggal yang valid.',
            'started_at.before_or_equal' => 'Waktu mulai tidak boleh di masa depan.',
            
            'ended_at.date' => 'Waktu selesai harus berupa tanggal yang valid.',
            'ended_at.after' => 'Waktu selesai harus setelah waktu mulai.',
            'ended_at.before_or_equal' => 'Waktu selesai tidak boleh di masa depan.',
            
            'notes.max' => 'Catatan tidak boleh lebih dari 1000 karakter.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422)
        );
    }

    /**
     * Get validated data dengan additional processing
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();
        
        // Ensure ended_at has value
        if (empty($validated['ended_at'])) {
            $validated['ended_at'] = now()->toIso8601String();
        }
        
        return $validated;
    }
    
    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'session_id' => 'Session ID',
            'expressions.happy' => 'Happy',
            'expressions.sad' => 'Sad',
            'expressions.angry' => 'Angry',
            'expressions.surprised' => 'Surprised',
            'expressions.neutral' => 'Neutral',
            'expressions.fearful' => 'Fearful',
            'expressions.disgusted' => 'Disgusted',
            'started_at' => 'Waktu Mulai',
            'ended_at' => 'Waktu Selesai',
            'notes' => 'Catatan',
        ];
    }
}