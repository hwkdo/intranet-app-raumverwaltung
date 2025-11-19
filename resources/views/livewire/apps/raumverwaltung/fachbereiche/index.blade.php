<?php

use Flux\Flux;
use Hwkdo\IntranetAppRaumverwaltung\Models\Fachbereich;

use function Livewire\Volt\{state, title, computed, mount, usesPagination};

usesPagination();

title('Fachbereiche');

state(['search' => '']);

mount(function () {
    if (session()->has('message')) {
        Flux::toast(text: session()->get('message'), variant: 'success');
    }
});

$fachbereiche = computed(function () {
    return Fachbereich::query()
        ->when($this->search, fn($query) => $query->where('bezeichnung', 'like', "%{$this->search}%")
            ->orWhere('nr', 'like', "%{$this->search}%")
            ->orWhere('kst', 'like', "%{$this->search}%"))
        ->orderBy('nr')
        ->paginate(15);
});

$delete = function (Fachbereich $fachbereich) {
    $fachbereich->delete();
    
    $this->dispatch('fachbereich-deleted');
    Flux::toast(text: 'Fachbereich erfolgreich gelöscht!', variant: 'success');
};

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Fachbereiche" subheading="Verwalten Sie alle Fachbereiche">
        <div class="mb-6 flex items-center justify-between gap-4">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                placeholder="Suchen..." 
                class="w-full max-w-md"
            />
            
            <flux:button :href="route('apps.raumverwaltung.fachbereiche.create')" wire:navigate variant="primary" icon="plus">
                Neuer Fachbereich
            </flux:button>
        </div>

        <flux:table :paginate="$this->fachbereiche">
            <flux:table.columns>
                <flux:table.column>Nr</flux:table.column>
                <flux:table.column>Bezeichnung</flux:table.column>
                <flux:table.column>Kostenstelle</flux:table.column>
                <flux:table.column>Aktionen</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->fachbereiche as $fachbereich)
                    <flux:table.row>
                        <flux:table.cell>{{ $fachbereich->nr }}</flux:table.cell>
                        <flux:table.cell>{{ $fachbereich->bezeichnung }}</flux:table.cell>
                        <flux:table.cell>{{ $fachbereich->kst }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-2">
                                <flux:button 
                                    size="sm" 
                                    variant="ghost" 
                                    icon="pencil" 
                                    :href="route('apps.raumverwaltung.fachbereiche.edit', $fachbereich)" 
                                    wire:navigate
                                />
                                <flux:button 
                                    size="sm" 
                                    variant="ghost" 
                                    icon="trash" 
                                    wire:click="delete({{ $fachbereich->id }})"
                                    wire:confirm="Sind Sie sicher, dass Sie diesen Fachbereich löschen möchten?"
                                />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
</x-intranet-app-raumverwaltung::raumverwaltung-layout>
</div>
