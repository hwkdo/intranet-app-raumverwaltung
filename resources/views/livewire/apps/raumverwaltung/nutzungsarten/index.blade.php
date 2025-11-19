<?php

use Flux\Flux;
use Hwkdo\IntranetAppRaumverwaltung\Models\Nutzungsart;

use function Livewire\Volt\{state, title, computed, mount, usesPagination};

usesPagination();

title('Nutzungsarten');

state(['search' => '']);

mount(function () {
    if (session()->has('message')) {
        Flux::toast(text: session()->get('message'), variant: 'success');
    }
});

$nutzungsarten = computed(function () {
    return Nutzungsart::query()
        ->when($this->search, fn($query) => $query->where('bezeichnung', 'like', "%{$this->search}%")
            ->orWhere('bezeichnung_lang', 'like', "%{$this->search}%")
            ->orWhere('zeichen', 'like', "%{$this->search}%"))
        ->orderBy('bezeichnung')
        ->paginate(15);
});

$delete = function (Nutzungsart $nutzungsart) {
    $nutzungsart->delete();
    
    $this->dispatch('nutzungsart-deleted');
    Flux::toast(text: 'Nutzungsart erfolgreich gelöscht!', variant: 'success');
};

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Nutzungsarten" subheading="Verwalten Sie alle Nutzungsarten">
        <div class="mb-6 flex items-center justify-between gap-4">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                placeholder="Suchen..." 
                class="w-full max-w-md"
            />
            
            <flux:button :href="route('apps.raumverwaltung.nutzungsarten.create')" wire:navigate variant="primary" icon="plus">
                Neue Nutzungsart
            </flux:button>
        </div>

        <flux:table :paginate="$this->nutzungsarten">
            <flux:table.columns>
                <flux:table.column>Bezeichnung</flux:table.column>
                <flux:table.column>Langbezeichnung</flux:table.column>
                <flux:table.column>Zeichen</flux:table.column>
                <flux:table.column>Raumart</flux:table.column>
                <flux:table.column>Aktionen</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->nutzungsarten as $nutzungsart)
                    <flux:table.row>
                        <flux:table.cell>{{ $nutzungsart->bezeichnung }}</flux:table.cell>
                        <flux:table.cell>{{ $nutzungsart->bezeichnung_lang }}</flux:table.cell>
                        <flux:table.cell>{{ $nutzungsart->zeichen }}</flux:table.cell>
                        <flux:table.cell>{{ $nutzungsart->raumart?->name ?? '-' }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-2">
                                <flux:button 
                                    size="sm" 
                                    variant="ghost" 
                                    icon="pencil" 
                                    :href="route('apps.raumverwaltung.nutzungsarten.edit', $nutzungsart)" 
                                    wire:navigate
                                />
                                <flux:button 
                                    size="sm" 
                                    variant="ghost" 
                                    icon="trash" 
                                    wire:click="delete({{ $nutzungsart->id }})"
                                    wire:confirm="Sind Sie sicher, dass Sie diese Nutzungsart löschen möchten?"
                                />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
</x-intranet-app-raumverwaltung::raumverwaltung-layout>
</div>
