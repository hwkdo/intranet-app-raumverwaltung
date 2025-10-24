<?php

use Flux\Flux;
use Hwkdo\IntranetAppRaumverwaltung\Models\Gebaeude;
use function Livewire\Volt\{state, title, computed, mount};

title('Gebäude');

state(['search' => '']);

mount(function () {
    if (session()->has('message')) {
        Flux::toast(text: session()->get('message'), variant: 'success');
    }
});

$gebaeude = computed(function () {
    return Gebaeude::query()
        ->with('standort')
        ->when($this->search, fn($query) => $query->where('bezeichnung', 'like', "%{$this->search}%")
            ->orWhere('zeichen', 'like', "%{$this->search}%")
            ->orWhere('ort', 'like', "%{$this->search}%"))
        ->orderBy('bezeichnung')
        ->paginate(15);
});

$delete = function (Gebaeude $gebaeude) {
    $gebaeude->delete();
    
    $this->dispatch('gebaeude-deleted');
    Flux::toast(text: 'Gebäude erfolgreich gelöscht!', variant: 'success');
};

?>

<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Gebäude" subheading="Verwalten Sie alle Gebäude">
        <div class="mb-6 flex items-center justify-between gap-4">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                placeholder="Suchen..." 
                class="w-full max-w-md"
            />
            
            <flux:button :href="route('apps.raumverwaltung.gebaeude.create')" wire:navigate variant="primary" icon="plus">
                Neues Gebäude
            </flux:button>
        </div>

        <flux:table :paginate="$this->gebaeude">
            <flux:table.columns>
                <flux:table.column>Bezeichnung</flux:table.column>
                <flux:table.column>Zeichen</flux:table.column>
                <flux:table.column>Standort</flux:table.column>
                <flux:table.column>Straße</flux:table.column>
                <flux:table.column>PLZ</flux:table.column>
                <flux:table.column>Ort</flux:table.column>
                <flux:table.column>Aktionen</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->gebaeude as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->bezeichnung }}</flux:table.cell>
                        <flux:table.cell>{{ $item->zeichen }}</flux:table.cell>
                        <flux:table.cell>{{ $item->standort?->kurz ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $item->strasse ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $item->plz ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $item->ort ?? '-' }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-2">
                                <flux:button 
                                    size="sm" 
                                    variant="ghost" 
                                    icon="pencil" 
                                    :href="route('apps.raumverwaltung.gebaeude.edit', $item)" 
                                    wire:navigate
                                />
                                <flux:button 
                                    size="sm" 
                                    variant="ghost" 
                                    icon="trash" 
                                    wire:click="delete({{ $item->id }})"
                                    wire:confirm="Sind Sie sicher, dass Sie dieses Gebäude löschen möchten?"
                                />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
</x-intranet-app-raumverwaltung::raumverwaltung-layout>

