<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Standort;
use Hwkdo\IntranetAppRaumverwaltung\Http\Requests\UpdateStandortRequest;
use function Livewire\Volt\{state, title, rules, mount};

title('Standort bearbeiten');

state([
    'standort',
    'kurz' => '',
    'lang' => '',
    'nr' => '',
    'zeichen' => '',
    'strasse' => '',
    'plz' => '',
    'ort' => '',
]);

mount(function (Standort $standort) {
    $this->standort = $standort;
    $this->kurz = $standort->kurz;
    $this->lang = $standort->lang;
    $this->nr = $standort->nr;
    $this->zeichen = $standort->zeichen;
    $this->strasse = $standort->strasse;
    $this->plz = $standort->plz;
    $this->ort = $standort->ort;
});

rules([
    'kurz' => 'required|string|max:255',
    'lang' => 'required|string|max:255',
    'nr' => 'required|integer',
    'zeichen' => 'required|string|max:255',
    'strasse' => 'required|string|max:255',
    'plz' => 'required|integer',
    'ort' => 'required|string|max:255',
]);

$update = function () {
    $validated = $this->validate();
    
    $this->standort->update($validated);
    
    session()->flash('message', 'Standort erfolgreich aktualisiert!');
    
    $this->redirect(route('apps.raumverwaltung.standorte.index'), navigate: true);
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
            <flux:heading size="lg" class="mb-6">Standort bearbeiten</flux:heading>
            
            <form wire:submit="update" class="space-y-6">
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
                        Aktualisieren
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </x-intranet-app-raumverwaltung::raumverwaltung-layout>
</section>

