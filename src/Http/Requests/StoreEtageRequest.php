<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEtageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bezeichnung' => ['required', 'string', 'max:255'],
            'zeichen' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'bezeichnung.required' => 'Die Bezeichnung ist erforderlich.',
            'zeichen.required' => 'Das Zeichen ist erforderlich.',
        ];
    }
}
