<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Http\Requests;

use Hwkdo\IntranetAppRaumverwaltung\Enums\RaumartEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNutzungsartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bezeichnung' => ['required', 'string', 'max:255'],
            'bezeichnung_lang' => ['required', 'string', 'max:255'],
            'zeichen' => ['required', 'string', 'max:255'],
            'raumart' => ['required', Rule::enum(RaumartEnum::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'bezeichnung.required' => 'Die Bezeichnung ist erforderlich.',
            'bezeichnung_lang.required' => 'Die Langbezeichnung ist erforderlich.',
            'zeichen.required' => 'Das Zeichen ist erforderlich.',
            'raumart.required' => 'Die Raumart ist erforderlich.',
        ];
    }
}
