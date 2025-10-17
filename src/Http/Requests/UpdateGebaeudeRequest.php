<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGebaeudeRequest extends FormRequest
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
            'strasse' => ['nullable', 'string', 'max:255'],
            'plz' => ['nullable', 'integer'],
            'ort' => ['nullable', 'string', 'max:255'],
            'standort_id' => ['required', 'exists:app_raumverwaltung_standorts,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'bezeichnung.required' => 'Die Bezeichnung ist erforderlich.',
            'zeichen.required' => 'Das Zeichen ist erforderlich.',
            'standort_id.required' => 'Der Standort ist erforderlich.',
            'standort_id.exists' => 'Der gewählte Standort existiert nicht.',
            'plz.integer' => 'Die Postleitzahl muss eine Zahl sein.',
        ];
    }
}
