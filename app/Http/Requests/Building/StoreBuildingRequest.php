<?php

namespace App\Http\Requests\Building;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuildingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasPermission('create-buildings');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'building_code' => ['required', 'string', 'max:20', 'unique:buildings,building_code'],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'building_code' => 'kode gedung',
            'name' => 'nama gedung',
            'description' => 'deskripsi',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'building_code.required' => 'Kode gedung wajib diisi.',
            'building_code.unique' => 'Kode gedung sudah digunakan.',
            'building_code.max' => 'Kode gedung maksimal 20 karakter.',
            'name.required' => 'Nama gedung wajib diisi.',
            'name.max' => 'Nama gedung maksimal 100 karakter.',
        ];
    }
}
