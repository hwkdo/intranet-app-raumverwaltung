<?php

use Flux\Flux;
use Hwkdo\IntranetAppRaumverwaltung\Models\Raum;
use function Livewire\Volt\{state, title, computed, mount};

title('Räume');

state(['search' => '']);

mount(function () {
    if (session()->has('message')) {
        Flux::toast(text: session()->get('message'), variant: 'success');
    }
});

$raeume = computed(function () {
    return Raum::query()
        ->with(['gebaeude', 'etage', 'nutzungsart', 'fachbereich'])
        ->when($this->search, fn($query) => $query->where('raumnummer', 'like', "%{$this->search}%")
            ->orWhere('kurzzeichen', 'like', "%{$this->search}%")
            ->orWhere('druckbezeichnung', 'like', "%{$this->search}%"))
        ->orderBy('raumnummer')
        ->paginate(15);
});

$delete = function (Raum $raum) {
    $raum->delete();
    
    $this->dispatch('raum-deleted');
    Flux::toast(text: 'Raum erfolgreich gelöscht!', variant: 'success');
};

?>
<section class="w-full">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Raumverwaltung</flux:heading>
        <flux:subheading size="lg" class="mb-6">Verwaltung von Räumen und Standorten</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    
    <x-intranet-app-raumverwaltung::raumverwaltung-layout>
        <div class="mb-6 flex items-center justify-between gap-4">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                placeholder="Suchen..." 
                class="w-full max-w-md"
            />
            
            <flux:button :href="route('apps.raumverwaltung.raeume.create')" wire:navigate variant="primary" icon="plus">
                Neuer Raum
            </flux:button>
        </div>

        <flux:table :paginate="$this->raeume">
            <flux:table.columns>
                <flux:table.column>Raumnummer</flux:table.column>
                <flux:table.column>Gebäude</flux:table.column>
                <flux:table.column>Etage</flux:table.column>
                <flux:table.column>Nutzungsart</flux:table.column>
                <flux:table.column>Fachbereich</flux:table.column>
                <flux:table.column>QM</flux:table.column>
                <flux:table.column>Plätze</flux:table.column>
                <flux:table.column>Aktionen</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->raeume as $raum)
                    <flux:table.row>
                        <flux:table.cell>{{ $raum->raumnummer ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $raum->gebaeude?->bezeichnung ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $raum->etage?->bezeichnung ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $raum->nutzungsart?->bezeichnung ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $raum->fachbereich?->bezeichnung ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $raum->qm ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $raum->plaetze ?? '-' }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-2">
                                <flux:button 
                                    size="sm" 
                                    variant="ghost" 
                                    icon="pencil" 
                                    :href="route('apps.raumverwaltung.raeume.edit', $raum)" 
                                    wire:navigate
                                />
                                <flux:button 
                                    size="sm" 
                                    variant="ghost" 
                                    icon="trash" 
                                    wire:click="delete({{ $raum->id }})"
                                    wire:confirm="Sind Sie sicher, dass Sie diesen Raum löschen möchten?"
                                />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </x-intranet-app-raumverwaltung::raumverwaltung-layout>
</section>

