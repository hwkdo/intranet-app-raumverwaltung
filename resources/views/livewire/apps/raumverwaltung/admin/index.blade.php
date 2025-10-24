<?php

use function Livewire\Volt\{state, title};

title('Raumverwaltung - Admin');

state(['activeTab' => 'einstellungen']);

?>

<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Raumverwaltung" subheading="Admin">
    <flux:tab.group>
        <flux:tabs wire:model="activeTab">
            <flux:tab name="einstellungen" icon="cog-6-tooth">Einstellungen</flux:tab>
            <flux:tab name="statistiken" icon="chart-bar">Statistiken</flux:tab>
        </flux:tabs>
        
        <flux:tab.panel name="einstellungen">
            <div style="min-height: 400px;">
                <x-intranet-app-base::admin-settings 
                    app-identifier="raumverwaltung"
                    settings-model-class="\Hwkdo\IntranetAppRaumverwaltung\Models\IntranetAppRaumverwaltungSettings"
                    app-settings-class="\Hwkdo\IntranetAppRaumverwaltung\Data\AppSettings"
                />
            </div>
        </flux:tab.panel>

        <flux:tab.panel name="statistiken">
            <div style="min-height: 400px;">
                <flux:card>
                    <flux:heading size="lg" class="mb-4">App-Statistiken</flux:heading>
                    <flux:text class="mb-6">
                        Übersicht über die Nutzung der Raumverwaltung App.
                    </flux:text>
                    
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <div class="rounded-lg border p-4">
                            <flux:heading size="md">Aktive Räume</flux:heading>
                            <flux:text size="xl" class="mt-2">156</flux:text>
                        </div>
                        
                        <div class="rounded-lg border p-4">
                            <flux:heading size="md">Gebäude</flux:heading>
                            <flux:text size="xl" class="mt-2">12</flux:text>
                        </div>
                        
                        <div class="rounded-lg border p-4">
                            <flux:heading size="md">Standorte</flux:heading>
                            <flux:text size="xl" class="mt-2">3</flux:text>
                        </div>
                    </div>
                </flux:card>
            </div>
        </flux:tab.panel>
    </flux:tab.group>
</x-intranet-app-raumverwaltung::raumverwaltung-layout>
