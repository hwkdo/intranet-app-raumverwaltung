<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFachbereichRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nr' => ['required', 'integer'],
            'bezeichnung' => ['required', 'string', 'max:255'],
            'kst' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'nr.required' => 'Die Nummer ist erforderlich.',
            'nr.integer' => 'Die Nummer muss eine Zahl sein.',
            'bezeichnung.required' => 'Die Bezeichnung ist erforderlich.',
            'kst.required' => 'Die Kostenstelle ist erforderlich.',
            'kst.integer' => 'Die Kostenstelle muss eine Zahl sein.',
        ];
    }
}
