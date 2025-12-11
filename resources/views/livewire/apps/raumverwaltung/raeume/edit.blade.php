<?php

use Flux\Flux;
use Hwkdo\IntranetAppRaumverwaltung\Enums\PriSekEnum;
use Hwkdo\IntranetAppRaumverwaltung\Models\{Raum, Gebaeude, Etage, Nutzungsart, Fachbereich, Standort};
use function Livewire\Volt\{state, title, computed, mount};

title('Raum bearbeiten');

state([
    'raum',
    'lfd_nr',
    'bue_id',
    'itexia_id',
    'gueltig_ab',
    'gueltig_bis',
    'kurzzeichen',
    'druckbezeichnung',
    'raumnummer',
    'standort_id',
    'gebaeude_id',
    'gebaeude_extern',
    'nutzungsart_id',
    'plaetze',
    'plaetze_ff',
    'qm',
    'strasse',
    'plz',
    'ort',
    'raumnr_neu',
    'raumnr_vorgaenger',
    'raumnr_nachfolger',
    'fachbereich_id',
    'hpi_lfd_nr',
    'hpi_anzahl_einheiten',
    'bemerkung',
    'einheit_gueltig_ab',
    'einheit_gueltig_bis',
    'etage_id',
    'pri_sek',
]);

mount(function (Raum $raum) {
    $this->raum = $raum;
    $this->lfd_nr = $raum->lfd_nr;
    $this->bue_id = $raum->bue_id;
    $this->itexia_id = $raum->itexia_id;
    $this->gueltig_ab = $raum->gueltig_ab?->format('Y-m-d');
    $this->gueltig_bis = $raum->gueltig_bis?->format('Y-m-d');
    $this->kurzzeichen = $raum->kurzzeichen;
    $this->druckbezeichnung = $raum->druckbezeichnung;
    $this->raumnummer = $raum->raumnummer;
    $this->gebaeude_id = $raum->gebaeude_id;
    $this->standort_id = $raum->gebaeude?->standort_id;
    $this->gebaeude_extern = $raum->gebaeude_extern;
    $this->nutzungsart_id = $raum->nutzungsart_id;
    $this->plaetze = $raum->plaetze;
    $this->plaetze_ff = $raum->plaetze_ff;
    $this->qm = $raum->qm;
    $this->strasse = $raum->strasse;
    $this->plz = $raum->plz;
    $this->ort = $raum->ort;
    $this->raumnr_neu = $raum->raumnr_neu;
    $this->raumnr_vorgaenger = $raum->raumnr_vorgaenger;
    $this->raumnr_nachfolger = $raum->raumnr_nachfolger;
    $this->fachbereich_id = $raum->fachbereich_id;
    $this->hpi_lfd_nr = $raum->hpi_lfd_nr;
    $this->hpi_anzahl_einheiten = $raum->hpi_anzahl_einheiten;
    $this->bemerkung = $raum->bemerkung;
    $this->einheit_gueltig_ab = $raum->einheit_gueltig_ab?->format('Y-m-d');
    $this->einheit_gueltig_bis = $raum->einheit_gueltig_bis?->format('Y-m-d');
    $this->etage_id = $raum->etage_id;
    $this->pri_sek = $raum->pri_sek?->value;
});

$standorte = computed(fn() => Standort::orderBy('kurz')->get());

$gebaeude = computed(function () {
    if ($this->standort_id) {
        return Gebaeude::where('standort_id', $this->standort_id)->with('standort')->orderBy('bezeichnung')->get();
    }
    return Gebaeude::with('standort')->orderBy('bezeichnung')->get();
});

$etagen = computed(fn() => Etage::orderBy('bezeichnung')->get());
$nutzungsarten = computed(fn() => Nutzungsart::orderBy('bezeichnung')->get());
$fachbereiche = computed(fn() => Fachbereich::orderBy('bezeichnung')->get());

$generatedNumber = computed(function () {
    if ($this->gebaeude_id && $this->etage_id && $this->nutzungsart_id && $this->lfd_nr) {
        try {
            return Raum::generateNumber($this->gebaeude_id, $this->etage_id, $this->nutzungsart_id, $this->lfd_nr);
        } catch (\Exception $e) {
            return null;
        }
    }
    return null;
});

$updateRaumnummer = function () {
    $this->raumnr_neu = $this->generatedNumber;
};

$save = function () {
    if (Gate::denies('update', $this->raum)) {
        Flux::toast(text: 'Sie haben keine Berechtigung, diesen Raum zu bearbeiten.', variant: 'danger');
        return;
    }
    
    // Automatisch raumnr_neu setzen
    $this->raumnr_neu = $this->generatedNumber;
    
    $validated = $this->validate([
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
        'raumnr_neu' => ['required', 'string', 'max:255', 'unique:app_raumverwaltung_raums,raumnr_neu,'.$this->raum->id],
        'raumnr_vorgaenger' => ['nullable', 'string', 'max:255'],
        'raumnr_nachfolger' => ['nullable', 'string', 'max:255'],
        'fachbereich_id' => ['nullable', 'exists:app_raumverwaltung_fachbereichs,id'],
        'hpi_lfd_nr' => ['nullable', 'integer'],
        'hpi_anzahl_einheiten' => ['nullable', 'integer'],
        'bemerkung' => ['nullable', 'string'],
        'einheit_gueltig_ab' => ['nullable', 'date'],
        'einheit_gueltig_bis' => ['nullable', 'date'],
        'etage_id' => ['required', 'integer', 'exists:app_raumverwaltung_etages,id'],
        'pri_sek' => ['nullable', 'string'],
        'nutzungsart_id' => ['required', 'integer', 'exists:app_raumverwaltung_nutzungsarts,id'],
    ]);
    
    $this->raum->update($validated);
    
    Flux::toast(text: 'Raum erfolgreich aktualisiert!', variant: 'success');
    
    $this->dispatch('raum-updated');
};

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Raum bearbeiten" subheading="Raum {{ $raum->id }} bearbeiten">
    <flux:card>
        <!-- Live-Vorschau der generierten Raumnummer -->
        <div class="mb-6 rounded-lg border p-4 @if($this->generatedNumber) bg-green-50 border-green-200 dark:bg-green-950 dark:border-green-800 @else bg-gray-50 border-gray-200 dark:bg-gray-900 dark:border-gray-700 @endif">
            <flux:heading size="lg" class="mb-4">Generierte Raumnummer</flux:heading>
            
            @if($this->generatedNumber)
                <div class="text-2xl font-bold text-green-700 dark:text-green-300">
                    {{ $this->generatedNumber }}
                </div>
            @else
                <div class="text-gray-500 dark:text-gray-400">
                    Bitte füllen Sie alle Pflichtfelder aus
                </div>
            @endif
            
            <!-- Status-Indikatoren -->
            <div class="mt-4 grid grid-cols-2 gap-2 md:grid-cols-4">
                <div class="flex items-center gap-2">
                    @if($gebaeude_id)
                        <span class="text-green-600 dark:text-green-400">✓</span>
                        <span class="text-sm text-green-700 dark:text-green-300">Gebäude OK</span>
                    @else
                        <span class="text-red-600 dark:text-red-400">✗</span>
                        <span class="text-sm text-red-700 dark:text-red-300">Gebäude fehlt</span>
                    @endif
                </div>
                
                <div class="flex items-center gap-2">
                    @if($etage_id)
                        <span class="text-green-600 dark:text-green-400">✓</span>
                        <span class="text-sm text-green-700 dark:text-green-300">Etage OK</span>
                    @else
                        <span class="text-red-600 dark:text-red-400">✗</span>
                        <span class="text-sm text-red-700 dark:text-red-300">Etage fehlt</span>
                    @endif
                </div>
                
                <div class="flex items-center gap-2">
                    @if($nutzungsart_id)
                        <span class="text-green-600 dark:text-green-400">✓</span>
                        <span class="text-sm text-green-700 dark:text-green-300">Nutzungsart OK</span>
                    @else
                        <span class="text-red-600 dark:text-red-400">✗</span>
                        <span class="text-sm text-red-700 dark:text-red-300">Nutzungsart fehlt</span>
                    @endif
                </div>
                
                <div class="flex items-center gap-2">
                    @if($lfd_nr)
                        <span class="text-green-600 dark:text-green-400">✓</span>
                        <span class="text-sm text-green-700 dark:text-green-300">Lfd. Nr. OK</span>
                    @else
                        <span class="text-red-600 dark:text-red-400">✗</span>
                        <span class="text-sm text-red-700 dark:text-red-300">Lfd. Nr. fehlt</span>
                    @endif
                </div>
            </div>
        </div>
        
        <form wire:submit="save" class="space-y-6">
            <!-- Pflichtfelder Section -->
            <div class="rounded-lg border-2 border-blue-300 bg-blue-50 p-6 dark:border-blue-700 dark:bg-blue-950">
                <flux:heading size="lg" class="mb-4 text-blue-900 dark:text-blue-100">Pflichtfelder für Raumnummerngenerierung</flux:heading>
                
                <div class="grid gap-6 md:grid-cols-2">
                    <flux:field>
                        <flux:label>Standort (für Filterung)</flux:label>
                        <flux:select wire:model.live="standort_id">
                            <option value="">Bitte wählen...</option>
                            @foreach($this->standorte as $item)
                                <option value="{{ $item->id }}">{{ $item->kurz }} - {{ $item->lang }}</option>
                            @endforeach
                        </flux:select>
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Gebäude *</flux:label>
                        <flux:select wire:model.live="gebaeude_id">
                            <option value="">Bitte wählen...</option>
                            @foreach($this->gebaeude as $item)
                                <option value="{{ $item->id }}">{{ $item->bezeichnung }} ({{ $item->standort->kurz }})</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="gebaeude_id" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Etage *</flux:label>
                        <flux:select wire:model.live="etage_id">
                            <option value="">Bitte wählen...</option>
                            @foreach($this->etagen as $item)
                                <option value="{{ $item->id }}">{{ $item->bezeichnung }}</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="etage_id" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Nutzungsart *</flux:label>
                        <flux:select wire:model.live="nutzungsart_id">
                            <option value="">Bitte wählen...</option>
                            @foreach($this->nutzungsarten as $item)
                                <option value="{{ $item->id }}">{{ $item->bezeichnung }} ({{ $item->raumart->name }})</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="nutzungsart_id" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Laufende Nummer *</flux:label>
                        <flux:input wire:model.live="lfd_nr" type="number" />
                        <flux:error name="lfd_nr" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Neue Raumnummer (automatisch generiert) *</flux:label>
                        <flux:input wire:model="raumnr_neu" readonly class="bg-gray-100 dark:bg-gray-800" />
                        <flux:error name="raumnr_neu" />
                    </flux:field>
                </div>
            </div>
            
            <!-- Weitere Felder -->
            <div class="grid gap-6 md:grid-cols-2">
                <flux:field>
                    <flux:label>BUE ID</flux:label>
                    <flux:input wire:model="bue_id" type="number" />
                    <flux:error name="bue_id" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Itexia ID</flux:label>
                    <flux:input wire:model="itexia_id" type="number" />
                    <flux:error name="itexia_id" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Gültig ab</flux:label>
                    <flux:input wire:model="gueltig_ab" type="date" />
                    <flux:error name="gueltig_ab" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Gültig bis</flux:label>
                    <flux:input wire:model="gueltig_bis" type="date" />
                    <flux:error name="gueltig_bis" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Kurzzeichen</flux:label>
                    <flux:input wire:model="kurzzeichen" />
                    <flux:error name="kurzzeichen" />
                </flux:field>
                
                <flux:field class="md:col-span-2">
                    <flux:label>Druckbezeichnung</flux:label>
                    <flux:input wire:model="druckbezeichnung" />
                    <flux:error name="druckbezeichnung" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Raumnummer (Alt/Bisher)</flux:label>
                    <flux:input wire:model="raumnummer" />
                    <flux:error name="raumnummer" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Gebäude Extern</flux:label>
                    <flux:input wire:model="gebaeude_extern" />
                    <flux:error name="gebaeude_extern" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Plätze</flux:label>
                    <flux:input wire:model="plaetze" type="number" />
                    <flux:error name="plaetze" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Plätze FF</flux:label>
                    <flux:input wire:model="plaetze_ff" type="number" />
                    <flux:error name="plaetze_ff" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Quadratmeter</flux:label>
                    <flux:input wire:model="qm" type="number" step="0.01" />
                    <flux:error name="qm" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Straße</flux:label>
                    <flux:input wire:model="strasse" />
                    <flux:error name="strasse" />
                </flux:field>
                
                <flux:field>
                    <flux:label>PLZ</flux:label>
                    <flux:input wire:model="plz" type="number" />
                    <flux:error name="plz" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Ort</flux:label>
                    <flux:input wire:model="ort" />
                    <flux:error name="ort" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Vorgänger Raumnummer</flux:label>
                    <flux:input wire:model="raumnr_vorgaenger" />
                    <flux:error name="raumnr_vorgaenger" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Nachfolger Raumnummer</flux:label>
                    <flux:input wire:model="raumnr_nachfolger" />
                    <flux:error name="raumnr_nachfolger" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Fachbereich</flux:label>
                    <flux:select 
                        variant="listbox" 
                        wire:model="fachbereich_id" 
                        searchable 
                        placeholder="Fachbereich auswählen..."
                    >
                        <flux:select.option value="">Bitte wählen...</flux:select.option>
                        @foreach($this->fachbereiche as $item)
                            <flux:select.option value="{{ $item->id }}">{{ $item->bezeichnung }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="fachbereich_id" />
                </flux:field>
                
                <flux:field>
                    <flux:label>HPI Laufende Nummer</flux:label>
                    <flux:input wire:model="hpi_lfd_nr" type="number" />
                    <flux:error name="hpi_lfd_nr" />
                </flux:field>
                
                <flux:field>
                    <flux:label>HPI Anzahl Einheiten</flux:label>
                    <flux:input wire:model="hpi_anzahl_einheiten" type="number" />
                    <flux:error name="hpi_anzahl_einheiten" />
                </flux:field>
                
                <flux:field class="md:col-span-2">
                    <flux:label>Bemerkung</flux:label>
                    <flux:textarea wire:model="bemerkung" rows="3" />
                    <flux:error name="bemerkung" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Einheit gültig ab</flux:label>
                    <flux:input wire:model="einheit_gueltig_ab" type="date" />
                    <flux:error name="einheit_gueltig_ab" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Einheit gültig bis</flux:label>
                    <flux:input wire:model="einheit_gueltig_bis" type="date" />
                    <flux:error name="einheit_gueltig_bis" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Pri/Sek</flux:label>
                    <flux:select wire:model="pri_sek">
                        <option value="">Bitte wählen...</option>
                        @foreach(PriSekEnum::cases() as $case)
                            <option value="{{ $case->value }}">{{ $case->name }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="pri_sek" />
                </flux:field>
            </div>
            
            <div class="flex gap-4">
                <flux:button type="submit" variant="primary">Speichern</flux:button>
                <flux:button :href="route('apps.raumverwaltung.raeume.index')" wire:navigate variant="ghost">Abbrechen</flux:button>
            </div>
        </form>
    </flux:card>
</x-intranet-app-raumverwaltung::raumverwaltung-layout>
</div>
