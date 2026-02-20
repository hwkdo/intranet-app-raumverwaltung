<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Fachbereich;
use function Livewire\Volt\{state, title, rules};

title('Fachbereich erstellen');

state([
    'nr' => '',
    'bezeichnung' => '',
    'kst' => '',
]);

rules([
    'nr' => 'required|integer',
    'bezeichnung' => 'required|string|max:255',
    'kst' => 'required|integer',
]);

$save = function () {
    $validated = $this->validate();
    
    Fachbereich::create($validated);
    
    session()->flash('message', 'Fachbereich erfolgreich erstellt!');
    
    $this->redirect(route('apps.raumverwaltung.fachbereiche.index'), navigate: true);
};

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Fachbereich erstellen" subheading="Neuen Fachbereich anlegen">
        <flux:card class="glass-card">
            <flux:heading size="lg" class="mb-6">Neuer Fachbereich</flux:heading>
            
            <form wire:submit="save" class="space-y-6">
                <flux:field>
                    <flux:label>Nummer</flux:label>
                    <flux:input wire:model="nr" type="number" />
                    <flux:error name="nr" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Bezeichnung</flux:label>
                    <flux:input wire:model="bezeichnung" />
                    <flux:error name="bezeichnung" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Kostenstelle</flux:label>
                    <flux:input wire:model="kst" type="number" />
                    <flux:error name="kst" />
                </flux:field>
                
                <div class="flex justify-end gap-2">
                    <flux:button variant="ghost" :href="route('apps.raumverwaltung.fachbereiche.index')" wire:navigate>
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

