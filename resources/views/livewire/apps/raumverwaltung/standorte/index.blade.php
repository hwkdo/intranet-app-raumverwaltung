<?php

use Flux\Flux;
use Hwkdo\IntranetAppRaumverwaltung\Models\Standort;

use function Livewire\Volt\{state, title, computed, mount, usesPagination};

usesPagination();

title('Standorte');

state(['search' => '']);

mount(function () {
    if (session()->has('message')) {
        Flux::toast(text: session()->get('message'), variant: 'success');
    }
});

$standorte = computed(function () {
    return Standort::query()
        ->when($this->search, fn($query) => $query->where('kurz', 'like', "%{$this->search}%")
            ->orWhere('lang', 'like', "%{$this->search}%")
            ->orWhere('ort', 'like', "%{$this->search}%"))
        ->orderBy('nr')
        ->paginate(15);
});

$delete = function (Standort $standort) {
    $standort->delete();
    
    $this->dispatch('standort-deleted');
    Flux::toast(text: 'Standort erfolgreich gelöscht!', variant: 'success');
};

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Standorte" subheading="Verwalten Sie alle Standorte">
        <flux:card class="glass-card">
        <div class="mb-6 flex items-center justify-between gap-4">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                placeholder="Suchen..." 
                class="w-full max-w-md"
            />
            
            <flux:button :href="route('apps.raumverwaltung.standorte.create')" wire:navigate variant="primary" icon="plus">
                Neuer Standort
            </flux:button>
        </div>

        <flux:table :paginate="$this->standorte">
            <flux:table.columns>
                <flux:table.column>Kurz</flux:table.column>
                <flux:table.column>Lang</flux:table.column>
                <flux:table.column>Nr</flux:table.column>
                <flux:table.column>Zeichen</flux:table.column>
                <flux:table.column>Straße</flux:table.column>
                <flux:table.column>PLZ</flux:table.column>
                <flux:table.column>Ort</flux:table.column>
                <flux:table.column>Aktionen</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->standorte as $standort)
                    <flux:table.row>
                        <flux:table.cell>{{ $standort->kurz }}</flux:table.cell>
                        <flux:table.cell>{{ $standort->lang }}</flux:table.cell>
                        <flux:table.cell>{{ $standort->nr }}</flux:table.cell>
                        <flux:table.cell>{{ $standort->zeichen }}</flux:table.cell>
                        <flux:table.cell>{{ $standort->strasse }}</flux:table.cell>
                        <flux:table.cell>{{ $standort->plz }}</flux:table.cell>
                        <flux:table.cell>{{ $standort->ort }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-2">
                                <flux:button 
                                    size="sm" 
                                    variant="ghost" 
                                    icon="pencil" 
                                    :href="route('apps.raumverwaltung.standorte.edit', $standort)" 
                                    wire:navigate
                                />
                                <flux:button 
                                    size="sm" 
                                    variant="ghost" 
                                    icon="trash" 
                                    wire:click="delete({{ $standort->id }})"
                                    wire:confirm="Sind Sie sicher, dass Sie diesen Standort löschen möchten?"
                                />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
        </flux:card>
</x-intranet-app-raumverwaltung::raumverwaltung-layout>
</div>
