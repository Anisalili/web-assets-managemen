<?php

namespace App\Http\Requests\MaintenanceLog;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaintenanceLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasPermission('create-maintenance-logs');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'schedule_id' => ['nullable', 'exists:maintenance_schedules,id'],
            'asset_id' => ['required', 'exists:assets,id'],
            'performed_by' => ['required', 'string', 'max:100'],
            'date_performed' => ['required', 'date', 'before_or_equal:today'],
            'result' => ['nullable', 'string'],
            'next_recommendation_date' => ['nullable', 'date', 'after:date_performed'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'schedule_id' => 'jadwal pemeliharaan',
            'asset_id' => 'aset',
            'performed_by' => 'dilakukan oleh',
            'date_performed' => 'tanggal pelaksanaan',
            'result' => 'hasil',
            'next_recommendation_date' => 'tanggal rekomendasi berikutnya',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'schedule_id.exists' => 'Jadwal pemeliharaan tidak valid.',
            'asset_id.required' => 'Aset wajib dipilih.',
            'asset_id.exists' => 'Aset tidak valid.',
            'performed_by.required' => 'Pelaksana wajib diisi.',
            'date_performed.required' => 'Tanggal pelaksanaan wajib diisi.',
            'date_performed.before_or_equal' => 'Tanggal pelaksanaan tidak boleh melebihi hari ini.',
            'next_recommendation_date.after' => 'Tanggal rekomendasi harus setelah tanggal pelaksanaan.',
        ];
    }
}
