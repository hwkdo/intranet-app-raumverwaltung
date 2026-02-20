<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Standort;
use Hwkdo\IntranetAppRaumverwaltung\Http\Requests\StoreStandortRequest;
use function Livewire\Volt\{state, title, rules};

title('Standort erstellen');

state([
    'kurz' => '',
    'lang' => '',
    'nr' => '',
    'zeichen' => '',
    'strasse' => '',
    'plz' => '',
    'ort' => '',
]);

rules([
    'kurz' => 'required|string|max:255',
    'lang' => 'required|string|max:255',
    'nr' => 'required|integer',
    'zeichen' => 'required|string|max:255',
    'strasse' => 'required|string|max:255',
    'plz' => 'required|integer',
    'ort' => 'required|string|max:255',
]);

$save = function () {
    $validated = $this->validate();
    
    Standort::create($validated);
    
    session()->flash('message', 'Standort erfolgreich erstellt!');
    
    $this->redirect(route('apps.raumverwaltung.standorte.index'), navigate: true);
};

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Standort erstellen" subheading="Neuen Standort anlegen">
        <flux:card class="glass-card">
            <flux:heading size="lg" class="mb-6">Neuer Standort</flux:heading>
            
            <form wire:submit="save" class="space-y-6">
                <div class="grid gap-6 md:grid-cols-2">
                    <flux:field>
                        <flux:label>Kurzbezeichnung</flux:label>
                        <flux:input wire:model="kurz" />
                        <flux:error name="kurz" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Langbezeichnung</flux:label>
                        <flux:input wire:model="lang" />
                        <flux:error name="lang" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Nummer</flux:label>
                        <flux:input wire:model="nr" type="number" />
                        <flux:error name="nr" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Zeichen</flux:label>
                        <flux:input wire:model="zeichen" />
                        <flux:error name="zeichen" />
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
                    <flux:button variant="ghost" :href="route('apps.raumverwaltung.standorte.index')" wire:navigate>
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
