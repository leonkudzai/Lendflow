<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NYTBooksAPIRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['string'],
            'author' => ['string'],
            'isbn' => [function ($attribute, $value, $fail) {
                // Split the string by semicolon
                $isbns = explode(';', $value);

                foreach ($isbns as $isbn) {
                    $isbn = trim($isbn);
                    //checking if isbn is valid
                    if (!preg_match('/^\d{10}$|^\d{13}$/', $isbn)) {
                        $fail("The isbn must be either 10 or 13 digits and searching for multiple isbn, must be seperated by semicolon (;).");
                    }
                }
            }],
            //checking if offset is valid and is multiple of 20
            'offset' => [
                'integer',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($value % 20 !== 0) {
                        $fail("The offset must be a multiple of 20.");
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'The title must be a string.',
            'author.string' => 'The author must be a string.',
        ];
    }
}
