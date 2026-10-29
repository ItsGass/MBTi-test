<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:80'],
            'age' => ['nullable', 'integer', 'between:10,99'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama perlu diisi agar bisa dicetak di sertifikat.',
            'name.min' => 'Nama minimal 2 karakter.',
            'name.max' => 'Nama maksimal 80 karakter.',
            'age.integer' => 'Umur harus berupa angka.',
            'age.between' => 'Umur harus di antara 10 sampai 99 tahun.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('name')) {
            $this->merge(['name' => trim((string) $this->input('name'))]);
        }
    }
}
