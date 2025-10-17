<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\{Raum, Gebaeude, Etage, Nutzungsart, Fachbereich};
use Hwkdo\IntranetAppRaumverwaltung\Enums\PriSekEnum;
use function Livewire\Volt\{state, title, rules, mount, computed};

title('Raum bearbeiten');

state([
    'raum',
    'raumnummer' => '',
    'kurzzeichen' => '',
    'druckbezeichnung' => '',
    'gebaeude_id' => '',
    'etage_id' => '',
    'nutzungsart_id' => '',
    'fachbereich_id' => '',
    'plaetze' => '',
    'plaetze_ff' => '',
    'qm' => '',
    'strasse' => '',
    'plz' => '',
    'ort' => '',
    'pri_sek' => '',
    'gueltig_ab' => '',
    'gueltig_bis' => '',
    'bemerkung' => '',
]);

mount(function (Raum $raum) {
    $this->raum = $raum;
    $this->raumnummer = $raum->raumnummer;
    $this->kurzzeichen = $raum->kurzzeichen;
    $this->druckbezeichnung = $raum->druckbezeichnung;
    $this->gebaeude_id = $raum->gebaeude_id;
    $this->etage_id = $raum->etage_id;
    $this->nutzungsart_id = $raum->nutzungsart_id;
    $this->fachbereich_id = $raum->fachbereich_id;
    $this->plaetze = $raum->plaetze;
    $this->plaetze_ff = $raum->plaetze_ff;
    $this->qm = $raum->qm;
    $this->strasse = $raum->strasse;
    $this->plz = $raum->plz;
    $this->ort = $raum->ort;
    $this->pri_sek = $raum->pri_sek?->value ?? '';
    $this->gueltig_ab = $raum->gueltig_ab?->format('Y-m-d') ?? '';
    $this->gueltig_bis = $raum->gueltig_bis?->format('Y-m-d') ?? '';
    $this->bemerkung = $raum->bemerkung;
});

$gebaeude = computed(fn() => Gebaeude::with('standort')->orderBy('bezeichnung')->get());
$etagen = computed(fn() => Etage::orderBy('bezeichnung')->get());
$nutzungsarten = computed(fn() => Nutzungsart::orderBy('bezeichnung')->get());
$fachbereiche = computed(fn() => Fachbereich::orderBy('bezeichnung')->get());

rules([
    'raumnummer' => 'nullable|string|max:255',
    'kurzzeichen' => 'nullable|string|max:255',
    'druckbezeichnung' => 'nullable|string|max:255',
    'gebaeude_id' => 'nullable|exists:app_raumverwaltung_gebaeudes,id',
    'etage_id' => 'nullable|exists:app_raumverwaltung_etages,id',
    'nutzungsart_id' => 'nullable|exists:app_raumverwaltung_nutzungsarts,id',
    'fachbereich_id' => 'nullable|exists:app_raumverwaltung_fachbereichs,id',
    'plaetze' => 'nullable|integer',
    'plaetze_ff' => 'nullable|integer',
    'qm' => 'nullable|numeric',
    'strasse' => 'nullable|string|max:255',
    'plz' => 'nullable|integer',
    'ort' => 'nullable|string|max:255',
    'pri_sek' => 'nullable|string',
    'gueltig_ab' => 'nullable|date',
    'gueltig_bis' => 'nullable|date',
    'bemerkung' => 'nullable|string',
]);

$update = function () {
    $validated = $this->validate();
    
    $this->raum->update($validated);
    
    session()->flash('message', 'Raum erfolgreich aktualisiert!');
    
    $this->redirect(route('apps.raumverwaltung.raeume.index'), navigate: true);
};

?>
<section class="w-full">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Raumverwaltung</flux:heading>
        <flux:subheading size="lg" class="mb-6">Verwaltung von Räumen und Standorten</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    
    <x-intranet-app-raumverwaltung::raumverwaltung-layout>
        <flux:card>
            <flux:heading size="lg" class="mb-6">Raum bearbeiten</flux:heading>
            
            <form wire:submit="update" class="space-y-6">
                <div class="grid gap-6 md:grid-cols-2">
                    <flux:field>
                        <flux:label>Raumnummer</flux:label>
                        <flux:input wire:model="raumnummer" />
                        <flux:error name="raumnummer" />
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
                        <flux:label>Gebäude</flux:label>
                        <flux:select wire:model="gebaeude_id">
                            <option value="">Bitte wählen...</option>
                            @foreach($this->gebaeude as $item)
                                <option value="{{ $item->id }}">{{ $item->bezeichnung }} ({{ $item->standort?->kurz }})</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="gebaeude_id" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Etage</flux:label>
                        <flux:select wire:model="etage_id">
                            <option value="">Bitte wählen...</option>
                            @foreach($this->etagen as $etage)
                                <option value="{{ $etage->id }}">{{ $etage->bezeichnung }}</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="etage_id" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Nutzungsart</flux:label>
                        <flux:select wire:model="nutzungsart_id">
                            <option value="">Bitte wählen...</option>
                            @foreach($this->nutzungsarten as $nutzungsart)
                                <option value="{{ $nutzungsart->id }}">{{ $nutzungsart->bezeichnung }}</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="nutzungsart_id" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Fachbereich</flux:label>
                        <flux:select wire:model="fachbereich_id">
                            <option value="">Bitte wählen...</option>
                            @foreach($this->fachbereiche as $fachbereich)
                                <option value="{{ $fachbereich->id }}">{{ $fachbereich->bezeichnung }}</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="fachbereich_id" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Quadratmeter</flux:label>
                        <flux:input wire:model="qm" type="number" step="0.01" />
                        <flux:error name="qm" />
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
                        <flux:label>Primär/Sekundär</flux:label>
                        <flux:select wire:model="pri_sek">
                            <option value="">Bitte wählen...</option>
                            @foreach(PriSekEnum::cases() as $priSek)
                                <option value="{{ $priSek->value }}">{{ $priSek->name }}</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="pri_sek" />
                    </flux:field>
                    
                    <flux:field class="md:col-span-2">
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
                        <flux:label>Gültig ab</flux:label>
                        <flux:input wire:model="gueltig_ab" type="date" />
                        <flux:error name="gueltig_ab" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Gültig bis</flux:label>
                        <flux:input wire:model="gueltig_bis" type="date" />
                        <flux:error name="gueltig_bis" />
                    </flux:field>
                    
                    <flux:field class="md:col-span-2">
                        <flux:label>Bemerkung</flux:label>
                        <flux:textarea wire:model="bemerkung" rows="3" />
                        <flux:error name="bemerkung" />
                    </flux:field>
                </div>
                
                <div class="flex justify-end gap-2">
                    <flux:button variant="ghost" :href="route('apps.raumverwaltung.raeume.index')" wire:navigate>
                        Abbrechen
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Aktualisieren
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </x-intranet-app-raumverwaltung::raumverwaltung-layout>
</section>

