<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasPermission('create-rooms');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'room_code' => ['required', 'string', 'max:20', 'unique:rooms,room_code'],
            'building_id' => ['required', 'exists:buildings,id'],
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
            'room_code' => 'kode ruangan',
            'building_id' => 'gedung',
            'name' => 'nama ruangan',
            'description' => 'deskripsi',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'room_code.required' => 'Kode ruangan wajib diisi.',
            'room_code.unique' => 'Kode ruangan sudah digunakan.',
            'room_code.max' => 'Kode ruangan maksimal 20 karakter.',
            'building_id.required' => 'Gedung wajib dipilih.',
            'building_id.exists' => 'Gedung yang dipilih tidak valid.',
            'name.required' => 'Nama ruangan wajib diisi.',
            'name.max' => 'Nama ruangan maksimal 100 karakter.',
        ];
    }
}
