<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Etage;
use function Livewire\Volt\{state, title, rules};

title('Etage erstellen');

state([
    'bezeichnung' => '',
    'zeichen' => '',
]);

rules([
    'bezeichnung' => 'required|string|max:255',
    'zeichen' => 'required|string|max:255',
]);

$save = function () {
    $validated = $this->validate();
    
    Etage::create($validated);
    
    session()->flash('message', 'Etage erfolgreich erstellt!');
    
    $this->redirect(route('apps.raumverwaltung.etagen.index'), navigate: true);
};

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Etage erstellen" subheading="Neue Etage anlegen">
        <flux:card>
            <flux:heading size="lg" class="mb-6">Neue Etage</flux:heading>
            
            <form wire:submit="save" class="space-y-6">
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
                        Speichern
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </x-intranet-app-raumverwaltung::raumverwaltung-layout>
</div>

