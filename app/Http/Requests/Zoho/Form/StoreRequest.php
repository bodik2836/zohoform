<?php

namespace App\Http\Requests\Zoho\Form;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'Account_Name' => 'required|string|max:255',
            'Phone' => 'nullable|string|max:64',
            'Website' => 'nullable|url',
            'Deal_Name' => 'required|string|max:255',
            'Stage' => 'required|string|max:255',
            'Closing_Date' => 'required|date',
        ];
    }
}
