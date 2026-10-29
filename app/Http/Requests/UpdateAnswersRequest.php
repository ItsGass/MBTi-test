<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateAnswersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Answers arrive as a position => value map, which is the same payload the
     * Blade form posts natively and the script sends while autosaving.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'answers' => ['required', 'array', 'min:1', 'max:40'],
            'answers.*' => ['required', 'integer', 'between:1,5'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'answers.required' => 'Tidak ada jawaban yang dikirim.',
            'answers.max' => 'Jumlah jawaban melebihi jumlah pernyataan.',
            'answers.*.required' => 'Semua pernyataan perlu dijawab.',
            'answers.*.integer' => 'Jawaban harus berupa angka.',
            'answers.*.between' => 'Jawaban harus bernilai 1 sampai 5.',
        ];
    }

    /**
     * Position => value map ready for the recorder.
     *
     * @return array<int, int>
     */
    public function values(): array
    {
        $values = [];

        foreach ((array) $this->validated('answers') as $position => $value) {
            if (! is_numeric($position) || (int) $position < 0 || (int) $position > 39) {
                throw ValidationException::withMessages([
                    'answers' => 'Nomor pernyataan tidak valid.',
                ]);
            }

            $values[(int) $position] = (int) $value;
        }

        return $values;
    }

    protected function failedValidation(Validator $validator): void
    {
        if ($this->expectsJson()) {
            throw (new ValidationException($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }

        parent::failedValidation($validator);
    }
}
