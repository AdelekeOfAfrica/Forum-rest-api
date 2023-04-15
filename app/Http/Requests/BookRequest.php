<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'isbn' => ['required', 'max:255', 'string'],
            'name' => ['required', 'min:2', 'string'],
            'authors' => ['required', 'max:255', 'string'],
            'number_of_pages' => ['required','integer'],
            'publisher' => ['required','min:5', 'max:255', 'string'],
            'country' => ['required','min:5', 'max:255', 'string'],
            'release_date' => ['required','min:5', 'max:255', 'string']
        ];
    }
}
