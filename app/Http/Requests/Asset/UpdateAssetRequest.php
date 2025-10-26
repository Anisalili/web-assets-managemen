<?php

namespace App\Http\Requests\Asset;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasPermission('update-assets');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $assetId = $this->route('asset');

        return [
            'asset_code' => ['required', 'string', 'max:50', 'unique:assets,asset_code,' . $assetId],
            'name' => ['required', 'string', 'max:150'],
            'category_id' => ['required', 'exists:asset_categories,id'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'status' => ['required', 'string', 'max:20', 'in:aktif,non-aktif,dalam_perbaikan,rusak'],
            'owner' => ['nullable', 'string', 'max:100'],
            'purchase_date' => ['nullable', 'date'],
            'value' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'asset_code' => 'kode aset',
            'name' => 'nama aset',
            'category_id' => 'kategori',
            'room_id' => 'ruangan',
            'status' => 'status',
            'owner' => 'pemilik/penanggung jawab',
            'purchase_date' => 'tanggal pembelian',
            'value' => 'nilai beli',
            'notes' => 'catatan',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'asset_code.required' => 'Kode aset wajib diisi.',
            'asset_code.unique' => 'Kode aset sudah digunakan.',
            'asset_code.max' => 'Kode aset maksimal 50 karakter.',
            'name.required' => 'Nama aset wajib diisi.',
            'name.max' => 'Nama aset maksimal 150 karakter.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'room_id.exists' => 'Ruangan tidak valid.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'value.numeric' => 'Nilai beli harus berupa angka.',
            'value.min' => 'Nilai beli tidak boleh negatif.',
            'purchase_date.date' => 'Tanggal pembelian tidak valid.',
        ];
    }
}
