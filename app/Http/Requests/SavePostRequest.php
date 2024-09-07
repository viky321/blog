<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class SavePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|max:255',
            'text' => 'required',
            'tags' => 'required|array|min:1',
            'tags.*' => 'integer|exists:tags,id',
            'items' => 'array',
            'items.*' => 'mimes:txt,pdf,xls,csv,doc'
        ];

        return $rules;
    }

    public function messages()
    {
            $messages = [];

        // Skontrolujte, či sú súbory skutočne existujú
        if ($files = $this->file("items")) {
            foreach ($files as $key => $value) {
                // Pridajte správu pre každý súbor
                $messages["items.$key.mimes"] = "All file must be of type: :values";
            }
        }

        return $messages;
    }
}
