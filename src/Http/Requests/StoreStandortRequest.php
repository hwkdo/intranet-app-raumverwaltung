<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStandortRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kurz' => ['required', 'string', 'max:255'],
            'lang' => ['required', 'string', 'max:255'],
            'nr' => ['required', 'integer'],
            'zeichen' => ['required', 'string', 'max:255'],
            'strasse' => ['required', 'string', 'max:255'],
            'plz' => ['required', 'integer'],
            'ort' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'kurz.required' => 'Die Kurzbezeichnung ist erforderlich.',
            'lang.required' => 'Die Langbezeichnung ist erforderlich.',
            'nr.required' => 'Die Nummer ist erforderlich.',
            'nr.integer' => 'Die Nummer muss eine Zahl sein.',
            'zeichen.required' => 'Das Zeichen ist erforderlich.',
            'strasse.required' => 'Die Straße ist erforderlich.',
            'plz.required' => 'Die Postleitzahl ist erforderlich.',
            'plz.integer' => 'Die Postleitzahl muss eine Zahl sein.',
            'ort.required' => 'Der Ort ist erforderlich.',
        ];
    }
}
