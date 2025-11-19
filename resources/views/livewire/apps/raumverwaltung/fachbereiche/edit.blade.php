<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Fachbereich;
use function Livewire\Volt\{state, title, rules, mount};

title('Fachbereich bearbeiten');

state([
    'fachbereich',
    'nr' => '',
    'bezeichnung' => '',
    'kst' => '',
]);

mount(function (Fachbereich $fachbereich) {
    $this->fachbereich = $fachbereich;
    $this->nr = $fachbereich->nr;
    $this->bezeichnung = $fachbereich->bezeichnung;
    $this->kst = $fachbereich->kst;
});

rules([
    'nr' => 'required|integer',
    'bezeichnung' => 'required|string|max:255',
    'kst' => 'required|integer',
]);

$update = function () {
    $validated = $this->validate();
    
    $this->fachbereich->update($validated);
    
    session()->flash('message', 'Fachbereich erfolgreich aktualisiert!');
    
    $this->redirect(route('apps.raumverwaltung.fachbereiche.index'), navigate: true);
};

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Fachbereich bearbeiten" subheading="Fachbereich bearbeiten">
        <flux:card>
            <flux:heading size="lg" class="mb-6">Fachbereich bearbeiten</flux:heading>
            
            <form wire:submit="update" class="space-y-6">
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
                        Aktualisieren
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </x-intranet-app-raumverwaltung::raumverwaltung-layout>
</div>

