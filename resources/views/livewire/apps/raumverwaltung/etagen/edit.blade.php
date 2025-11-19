<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Etage;
use function Livewire\Volt\{state, title, rules, mount};

title('Etage bearbeiten');

state([
    'etage',
    'bezeichnung' => '',
    'zeichen' => '',
]);

mount(function (Etage $etage) {
    $this->etage = $etage;
    $this->bezeichnung = $etage->bezeichnung;
    $this->zeichen = $etage->zeichen;
});

rules([
    'bezeichnung' => 'required|string|max:255',
    'zeichen' => 'required|string|max:255',
]);

$update = function () {
    $validated = $this->validate();
    
    $this->etage->update($validated);
    
    session()->flash('message', 'Etage erfolgreich aktualisiert!');
    
    $this->redirect(route('apps.raumverwaltung.etagen.index'), navigate: true);
};

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Etage bearbeiten" subheading="Etage bearbeiten">
        <flux:card>
            <flux:heading size="lg" class="mb-6">Etage bearbeiten</flux:heading>
            
            <form wire:submit="update" class="space-y-6">
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
                
                <div class="flex justify-end gap-2">
                    <flux:button variant="ghost" :href="route('apps.raumverwaltung.etagen.index')" wire:navigate>
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

