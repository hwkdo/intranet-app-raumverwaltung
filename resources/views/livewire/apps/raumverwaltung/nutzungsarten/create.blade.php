<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Nutzungsart;
use Hwkdo\IntranetAppRaumverwaltung\Enums\RaumartEnum;
use function Livewire\Volt\{state, title, rules};

title('Nutzungsart erstellen');

state([
    'bezeichnung' => '',
    'bezeichnung_lang' => '',
    'zeichen' => '',
    'raumart' => '',
]);

rules([
    'bezeichnung' => 'required|string|max:255',
    'bezeichnung_lang' => 'required|string|max:255',
    'zeichen' => 'required|string|max:255',
    'raumart' => 'required|string',
]);

$save = function () {
    $validated = $this->validate();
    
    Nutzungsart::create($validated);
    
    session()->flash('message', 'Nutzungsart erfolgreich erstellt!');
    
    $this->redirect(route('apps.raumverwaltung.nutzungsarten.index'), navigate: true);
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
            <flux:heading size="lg" class="mb-6">Neue Nutzungsart</flux:heading>
            
            <form wire:submit="save" class="space-y-6">
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
                        Speichern
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </x-intranet-app-raumverwaltung::raumverwaltung-layout>
</section>

