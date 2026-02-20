<?php

use Flux\Flux;
use Hwkdo\IntranetAppRaumverwaltung\Models\Etage;

use function Livewire\Volt\{state, title, computed, mount, usesPagination};

usesPagination();

title('Etagen');

state(['search' => '']);

mount(function () {
    if (session()->has('message')) {
        Flux::toast(text: session()->get('message'), variant: 'success');
    }
});

$etagen = computed(function () {
    return Etage::query()
        ->when($this->search, fn($query) => $query->where('bezeichnung', 'like', "%{$this->search}%")
            ->orWhere('zeichen', 'like', "%{$this->search}%"))
        ->orderBy('bezeichnung')
        ->paginate(15);
});

$delete = function (Etage $etage) {
    $etage->delete();
    
    $this->dispatch('etage-deleted');
    Flux::toast(text: 'Etage erfolgreich gelöscht!', variant: 'success');
};

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Etagen" subheading="Verwalten Sie alle Etagen">
        <flux:card class="glass-card">
        <div class="mb-6 flex items-center justify-between gap-4">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                placeholder="Suchen..." 
                class="w-full max-w-md"
            />
            
            <flux:button :href="route('apps.raumverwaltung.etagen.create')" wire:navigate variant="primary" icon="plus">
                Neue Etage
            </flux:button>
        </div>

        <flux:table :paginate="$this->etagen">
            <flux:table.columns>
                <flux:table.column>Bezeichnung</flux:table.column>
                <flux:table.column>Zeichen</flux:table.column>
                <flux:table.column>Aktionen</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->etagen as $etage)
                    <flux:table.row>
                        <flux:table.cell>{{ $etage->bezeichnung }}</flux:table.cell>
                        <flux:table.cell>{{ $etage->zeichen }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-2">
                                <flux:button 
                                    size="sm" 
                                    variant="ghost" 
                                    icon="pencil" 
                                    :href="route('apps.raumverwaltung.etagen.edit', $etage)" 
                                    wire:navigate
                                />
                                <flux:button 
                                    size="sm" 
                                    variant="ghost" 
                                    icon="trash" 
                                    wire:click="delete({{ $etage->id }})"
                                    wire:confirm="Sind Sie sicher, dass Sie diese Etage löschen möchten?"
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
