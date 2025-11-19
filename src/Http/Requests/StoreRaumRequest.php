<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Http\Requests;

use Hwkdo\IntranetAppRaumverwaltung\Enums\PriSekEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRaumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lfd_nr' => ['required', 'integer'],
            'bue_id' => ['nullable', 'integer'],
            'itexia_id' => ['nullable', 'integer'],
            'gueltig_ab' => ['nullable', 'date'],
            'gueltig_bis' => ['nullable', 'date'],
            'kurzzeichen' => ['nullable', 'string', 'max:255'],
            'druckbezeichnung' => ['nullable', 'string', 'max:255'],
            'raumnummer' => ['nullable', 'string', 'max:255'],
            'gebaeude_id' => ['required', 'integer', 'exists:app_raumverwaltung_gebaeudes,id'],
            'gebaeude_extern' => ['nullable', 'string', 'max:255'],
            'plaetze' => ['nullable', 'integer'],
            'plaetze_ff' => ['nullable', 'integer'],
            'qm' => ['nullable', 'numeric'],
            'strasse' => ['nullable', 'string', 'max:255'],
            'plz' => ['nullable', 'integer'],
            'ort' => ['nullable', 'string', 'max:255'],
            'raumnr_neu' => ['required', 'string', 'max:255', 'unique:app_raumverwaltung_raums,raumnr_neu'],
            'raumnr_vorgaenger' => ['nullable', 'string', 'max:255'],
            'raumnr_nachfolger' => ['nullable', 'string', 'max:255'],
            'fachbereich_id' => ['nullable', 'exists:app_raumverwaltung_fachbereichs,id'],
            'hpi_lfd_nr' => ['nullable', 'integer'],
            'hpi_anzahl_einheiten' => ['nullable', 'integer'],
            'bemerkung' => ['nullable', 'string'],
            'einheit_gueltig_ab' => ['nullable', 'date'],
            'einheit_gueltig_bis' => ['nullable', 'date'],
            'etage_id' => ['required', 'integer', 'exists:app_raumverwaltung_etages,id'],
            'pri_sek' => ['nullable', Rule::enum(PriSekEnum::class)],
            'nutzungsart_id' => ['required', 'integer', 'exists:app_raumverwaltung_nutzungsarts,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'lfd_nr.required' => 'Die laufende Nummer ist erforderlich.',
            'lfd_nr.integer' => 'Die laufende Nummer muss eine Zahl sein.',
            'gebaeude_id.required' => 'Das Gebäude ist erforderlich.',
            'gebaeude_id.exists' => 'Das gewählte Gebäude existiert nicht.',
            'etage_id.required' => 'Die Etage ist erforderlich.',
            'etage_id.exists' => 'Die gewählte Etage existiert nicht.',
            'nutzungsart_id.required' => 'Die Nutzungsart ist erforderlich.',
            'nutzungsart_id.exists' => 'Die gewählte Nutzungsart existiert nicht.',
            'fachbereich_id.exists' => 'Der gewählte Fachbereich existiert nicht.',
            'raumnr_neu.required' => 'Die neue Raumnummer ist erforderlich.',
            'raumnr_neu.unique' => 'Diese Raumnummer existiert bereits.',
            'plaetze.integer' => 'Die Anzahl der Plätze muss eine Zahl sein.',
            'plaetze_ff.integer' => 'Die Anzahl der Plätze FF muss eine Zahl sein.',
            'qm.numeric' => 'Die Quadratmeter müssen eine Zahl sein.',
            'plz.integer' => 'Die Postleitzahl muss eine Zahl sein.',
        ];
    }
}
