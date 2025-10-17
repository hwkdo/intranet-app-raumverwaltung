<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Http\Requests;

use Hwkdo\IntranetAppRaumverwaltung\Enums\PriSekEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRaumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'raumnummer' => ['nullable', 'string', 'max:255'],
            'kurzzeichen' => ['nullable', 'string', 'max:255'],
            'druckbezeichnung' => ['nullable', 'string', 'max:255'],
            'gebaeude_id' => ['nullable', 'exists:app_raumverwaltung_gebaeudes,id'],
            'etage_id' => ['nullable', 'exists:app_raumverwaltung_etages,id'],
            'nutzungsart_id' => ['nullable', 'exists:app_raumverwaltung_nutzungsarts,id'],
            'fachbereich_id' => ['nullable', 'exists:app_raumverwaltung_fachbereichs,id'],
            'plaetze' => ['nullable', 'integer'],
            'plaetze_ff' => ['nullable', 'integer'],
            'qm' => ['nullable', 'numeric'],
            'strasse' => ['nullable', 'string', 'max:255'],
            'plz' => ['nullable', 'integer'],
            'ort' => ['nullable', 'string', 'max:255'],
            'pri_sek' => ['nullable', Rule::enum(PriSekEnum::class)],
            'gueltig_ab' => ['nullable', 'date'],
            'gueltig_bis' => ['nullable', 'date'],
            'bemerkung' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'gebaeude_id.exists' => 'Das gewählte Gebäude existiert nicht.',
            'etage_id.exists' => 'Die gewählte Etage existiert nicht.',
            'nutzungsart_id.exists' => 'Die gewählte Nutzungsart existiert nicht.',
            'fachbereich_id.exists' => 'Der gewählte Fachbereich existiert nicht.',
            'plaetze.integer' => 'Die Anzahl der Plätze muss eine Zahl sein.',
            'plaetze_ff.integer' => 'Die Anzahl der Plätze FF muss eine Zahl sein.',
            'qm.numeric' => 'Die Quadratmeter müssen eine Zahl sein.',
            'plz.integer' => 'Die Postleitzahl muss eine Zahl sein.',
        ];
    }
}
