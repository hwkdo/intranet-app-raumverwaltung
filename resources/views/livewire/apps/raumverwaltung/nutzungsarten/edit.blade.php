<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Nutzungsart;
use Hwkdo\IntranetAppRaumverwaltung\Enums\RaumartEnum;
use function Livewire\Volt\{state, title, rules, mount};

title('Nutzungsart bearbeiten');

state([
    'nutzungsart',
    'bezeichnung' => '',
    'bezeichnung_lang' => '',
    'zeichen' => '',
    'raumart' => '',
]);

mount(function (Nutzungsart $nutzungsart) {
    $this->nutzungsart = $nutzungsart;
    $this->bezeichnung = $nutzungsart->bezeichnung;
    $this->bezeichnung_lang = $nutzungsart->bezeichnung_lang;
    $this->zeichen = $nutzungsart->zeichen;
    $this->raumart = $nutzungsart->raumart?->value ?? '';
});

rules([
    'bezeichnung' => 'required|string|max:255',
    'bezeichnung_lang' => 'required|string|max:255',
    'zeichen' => 'required|string|max:255',
    'raumart' => 'required|string',
]);

$update = function () {
    $validated = $this->validate();
    
    $this->nutzungsart->update($validated);
    
    session()->flash('message', 'Nutzungsart erfolgreich aktualisiert!');
    
    $this->redirect(route('apps.raumverwaltung.nutzungsarten.index'), navigate: true);
};

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Nutzungsart bearbeiten" subheading="Nutzungsart bearbeiten">
        <flux:card>
            <flux:heading size="lg" class="mb-6">Nutzungsart bearbeiten</flux:heading>
            
            <form wire:submit="update" class="space-y-6">
                <flux:field>
                    <flux:label>Bezeichnung</flux:label>
                    <flux:input wire:model="bezeichnung" />
                    <flux:error name="bezeichnung" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Langbezeichnung</flux:label>
                    <flux:input wire:model="bezeichnung_lang" />
                    <flux:error name="bezeichnung_lang" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Zeichen</flux:label>
                    <flux:input wire:model="zeichen" />
                    <flux:error name="zeichen" />
                </flux:field>
                
                <flux:field>
                    <flux:label>Raumart</flux:label>
                    <flux:select wire:model="raumart">
                        <option value="">Bitte wählen...</option>
                        @foreach(RaumartEnum::cases() as $raumart)
                            <option value="{{ $raumart->value }}">{{ $raumart->name }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="raumart" />
                </flux:field>
                
                <div class="flex justify-end gap-2">
                    <flux:button variant="ghost" :href="route('apps.raumverwaltung.nutzungsarten.index')" wire:navigate>
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

