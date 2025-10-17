<?php

use function Livewire\Volt\{title};

title('Raumverwaltung');

?>  
<section class="w-full">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Raumverwaltung</flux:heading>
        <flux:subheading size="lg" class="mb-6">Verwaltung von Räumen und Standorten</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    
    <x-intranet-app-raumverwaltung::raumverwaltung-layout>
        <div class="space-y-6">
            <flux:card>
                <flux:heading size="lg" class="mb-4">Willkommen in der Raumverwaltung</flux:heading>
                <flux:text class="mb-6">
                    Hier können Sie alle Aspekte der Raumverwaltung verwalten, einschließlich Standorte, Gebäude, Etagen, Nutzungsarten, Fachbereiche und Räume.
                </flux:text>
                
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <flux:card>
                        <div class="flex items-center gap-3">
                            <flux:icon name="map-pin" class="size-8 text-zinc-500 dark:text-zinc-400" />
                            <div>
                                <flux:heading size="sm">Standorte</flux:heading>
                                <flux:text size="sm" class="text-zinc-500">Standorte verwalten</flux:text>
                            </div>
                        </div>
                        <flux:button 
                            :href="route('apps.raumverwaltung.standorte.index')" 
                            wire:navigate 
                            variant="primary" 
                            class="mt-4 w-full"
                        >
                            Standorte anzeigen
                        </flux:button>
                    </flux:card>
                    
                    <flux:card>
                        <div class="flex items-center gap-3">
                            <flux:icon name="building-office" class="size-8 text-zinc-500 dark:text-zinc-400" />
                            <div>
                                <flux:heading size="sm">Gebäude</flux:heading>
                                <flux:text size="sm" class="text-zinc-500">Gebäude verwalten</flux:text>
                            </div>
                        </div>
                        <flux:button 
                            :href="route('apps.raumverwaltung.gebaeude.index')" 
                            wire:navigate 
                            variant="primary" 
                            class="mt-4 w-full"
                        >
                            Gebäude anzeigen
                        </flux:button>
                    </flux:card>
                    
                    <flux:card>
                        <div class="flex items-center gap-3">
                            <flux:icon name="squares-2x2" class="size-8 text-zinc-500 dark:text-zinc-400" />
                            <div>
                                <flux:heading size="sm">Etagen</flux:heading>
                                <flux:text size="sm" class="text-zinc-500">Etagen verwalten</flux:text>
                            </div>
                        </div>
                        <flux:button 
                            :href="route('apps.raumverwaltung.etagen.index')" 
                            wire:navigate 
                            variant="primary" 
                            class="mt-4 w-full"
                        >
                            Etagen anzeigen
                        </flux:button>
                    </flux:card>
                    
                    <flux:card>
                        <div class="flex items-center gap-3">
                            <flux:icon name="tag" class="size-8 text-zinc-500 dark:text-zinc-400" />
                            <div>
                                <flux:heading size="sm">Nutzungsarten</flux:heading>
                                <flux:text size="sm" class="text-zinc-500">Nutzungsarten verwalten</flux:text>
                            </div>
                        </div>
                        <flux:button 
                            :href="route('apps.raumverwaltung.nutzungsarten.index')" 
                            wire:navigate 
                            variant="primary" 
                            class="mt-4 w-full"
                        >
                            Nutzungsarten anzeigen
                        </flux:button>
                    </flux:card>
                    
                    <flux:card>
                        <div class="flex items-center gap-3">
                            <flux:icon name="briefcase" class="size-8 text-zinc-500 dark:text-zinc-400" />
                            <div>
                                <flux:heading size="sm">Fachbereiche</flux:heading>
                                <flux:text size="sm" class="text-zinc-500">Fachbereiche verwalten</flux:text>
                            </div>
                        </div>
                        <flux:button 
                            :href="route('apps.raumverwaltung.fachbereiche.index')" 
                            wire:navigate 
                            variant="primary" 
                            class="mt-4 w-full"
                        >
                            Fachbereiche anzeigen
                        </flux:button>
                    </flux:card>
                    
                    <flux:card>
                        <div class="flex items-center gap-3">
                            <flux:icon name="home" class="size-8 text-zinc-500 dark:text-zinc-400" />
                            <div>
                                <flux:heading size="sm">Räume</flux:heading>
                                <flux:text size="sm" class="text-zinc-500">Räume verwalten</flux:text>
                            </div>
                        </div>
                        <flux:button 
                            :href="route('apps.raumverwaltung.raeume.index')" 
                            wire:navigate 
                            variant="primary" 
                            class="mt-4 w-full"
                        >
                            Räume anzeigen
                        </flux:button>
                    </flux:card>
                </div>
            </flux:card>
        </div>
    </x-intranet-app-raumverwaltung::raumverwaltung-layout>
</section>