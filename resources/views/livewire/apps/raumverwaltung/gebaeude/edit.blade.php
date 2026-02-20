<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Gebaeude;
use Hwkdo\IntranetAppRaumverwaltung\Models\Standort;
use function Livewire\Volt\{state, title, rules, mount, computed};

title('Gebäude bearbeiten');

state([
    'gebaeude',
    'bezeichnung' => '',
    'zeichen' => '',
    'strasse' => '',
    'plz' => '',
    'ort' => '',
    'standort_id' => '',
]);

mount(function (Gebaeude $gebaeude) {
    $this->gebaeude = $gebaeude;
    $this->bezeichnung = $gebaeude->bezeichnung;
    $this->zeichen = $gebaeude->zeichen;
    $this->strasse = $gebaeude->strasse;
    $this->plz = $gebaeude->plz;
    $this->ort = $gebaeude->ort;
    $this->standort_id = $gebaeude->standort_id;
});

$standorte = computed(fn() => Standort::orderBy('kurz')->get());

rules([
    'bezeichnung' => 'required|string|max:255',
    'zeichen' => 'required|string|max:255',
    'strasse' => 'nullable|string|max:255',
    'plz' => 'nullable|integer',
    'ort' => 'nullable|string|max:255',
    'standort_id' => 'required|exists:app_raumverwaltung_standorts,id',
]);

$update = function () {
    $validated = $this->validate();
    
    $this->gebaeude->update($validated);
    
    session()->flash('message', 'Gebäude erfolgreich aktualisiert!');
    
    $this->redirect(route('apps.raumverwaltung.gebaeude.index'), navigate: true);
};

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Gebäude bearbeiten" subheading="Gebäude bearbeiten">
        <flux:card class="glass-card">
            <flux:heading size="lg" class="mb-6">Gebäude bearbeiten</flux:heading>
            
            <form wire:submit="update" class="space-y-6">
                <div class="grid gap-6 md:grid-cols-2">
                    <flux:field>
                        <flux:label>Bezeichnung</flux:label>
                        <flux:input wire:model="bezeichnung" />
                        <flux:error name="bezeichnung" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Zeichen</flux:label>
                        <flux:input wire:model="zeichen" />
                        <flux:error name="zeichen" />
                    </flux:field>
                    
                    <flux:field class="md:col-span-2">
                        <flux:label>Standort</flux:label>
                        <flux:select wire:model="standort_id">
                            <option value="">Bitte wählen...</option>
                            @foreach($this->standorte as $standort)
                                <option value="{{ $standort->id }}">{{ $standort->kurz }} - {{ $standort->lang }}</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="standort_id" />
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
                </div>
                
                <div class="flex justify-end gap-2">
                    <flux:button variant="ghost" :href="route('apps.raumverwaltung.gebaeude.index')" wire:navigate>
                        Abbrechen
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Aktualisieren
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </x-intranet-app-raumverwaltung::raumverwaltung-layout>
</div>

