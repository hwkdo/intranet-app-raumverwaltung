<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Gebaeude;
use Hwkdo\IntranetAppRaumverwaltung\Models\Standort;
use function Livewire\Volt\{state, title, rules, computed};

title('Gebäude erstellen');

state([
    'bezeichnung' => '',
    'zeichen' => '',
    'strasse' => '',
    'plz' => '',
    'ort' => '',
    'standort_id' => '',
]);

$standorte = computed(fn() => Standort::orderBy('kurz')->get());

rules([
    'bezeichnung' => 'required|string|max:255',
    'zeichen' => 'required|string|max:255',
    'strasse' => 'nullable|string|max:255',
    'plz' => 'nullable|integer',
    'ort' => 'nullable|string|max:255',
    'standort_id' => 'required|exists:app_raumverwaltung_standorts,id',
]);

$save = function () {
    $validated = $this->validate();
    
    Gebaeude::create($validated);
    
    session()->flash('message', 'Gebäude erfolgreich erstellt!');
    
    $this->redirect(route('apps.raumverwaltung.gebaeude.index'), navigate: true);
};

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Gebäude erstellen" subheading="Neues Gebäude anlegen">
        <flux:card>
            <flux:heading size="lg" class="mb-6">Neues Gebäude</flux:heading>
            
            <form wire:submit="save" class="space-y-6">
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
                        Speichern
                    </flux:button>
                </div>
            </form>
        </flux:card>
</x-intranet-app-raumverwaltung::raumverwaltung-layout>
</div>
