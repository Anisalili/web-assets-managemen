<?php

namespace App\Http\Requests\MaintenanceSchedule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaintenanceScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() &&
            auth()->user()->hasPermission("update-maintenance-schedules");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "asset_id" => ["required", "exists:assets,id"],
            "scheduled_date" => ["required", "date"],
            "frequency" => [
                "required",
                "string",
                "max:20",
                "in:harian,mingguan,bulanan,triwulan,semesteran,tahunan",
            ],
            "description" => ["nullable", "string"],
            "image_path" => ["nullable", "image", "max:2048"],
            "assigned_to" => ["nullable", "exists:users,id"],
            "status" => [
                "required",
                "string",
                "max:20",
                "in:terjadwal,selesai,dibatalkan",
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            "asset_id" => "aset",
            "scheduled_date" => "tanggal terjadwal",
            "frequency" => "frekuensi",
            "description" => "deskripsi",
            "assigned_to" => "ditugaskan kepada",
            "status" => "status",
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            "asset_id.required" => "Aset wajib dipilih.",
            "asset_id.exists" => "Aset tidak valid.",
            "scheduled_date.required" => "Tanggal terjadwal wajib diisi.",
            "frequency.required" => "Frekuensi wajib dipilih.",
            "frequency.in" => "Frekuensi tidak valid.",
            "status.required" => "Status wajib dipilih.",
            "status.in" => "Status tidak valid.",
        ];
    }
}
