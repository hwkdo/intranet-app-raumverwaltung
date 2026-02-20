<?php

use Flux\Flux;
use Hwkdo\IntranetAppRaumverwaltung\Enums\RaumartEnum;
use Hwkdo\IntranetAppRaumverwaltung\Models\Raum;
use Hwkdo\IntranetAppRaumverwaltung\Models\Standort;

use function Livewire\Volt\{state, title, computed, mount, on, usesPagination};

usesPagination();

title('Räume');

state([
    'search' => '',
    'filterMitBueId' => false,
    'filterMitItexiaId' => false,
    'filterOhneNeueNr' => false,
    'filterStandortId' => null,
    'filterRaumart' => null,
]);

mount(function () {
    if (session()->has('message')) {
        Flux::toast(text: session()->get('message'), variant: 'success');
    }
});

on(['raum-deleted' => function () {
    $this->dispatch('$refresh');
}]);

$standorte = computed(fn() => Standort::orderBy('kurz')->get());

$raeume = computed(function () {
    $query = Raum::query()
        ->with(['gebaeude.standort', 'etage', 'nutzungsart', 'fachbereich']);
    
    // Text-Suche
    if ($this->search) {
        $query->where(function ($q) {
            $q->where('raumnummer', 'like', "%{$this->search}%")
              ->orWhere('raumnr_neu', 'like', "%{$this->search}%")
              ->orWhere('kurzzeichen', 'like', "%{$this->search}%")
              ->orWhere('druckbezeichnung', 'like', "%{$this->search}%");
        });
    }
    
    // Toggle-Filter
    if ($this->filterMitBueId) {
        $query->whereNotNull('bue_id');
    }
    
    if ($this->filterMitItexiaId) {
        $query->whereNotNull('itexia_id');
    }
    
    if ($this->filterOhneNeueNr) {
        $query->whereNull('raumnr_neu');
    }
    
    // Standort-Filter
    if ($this->filterStandortId) {
        $query->whereHas('gebaeude', function ($q) {
            $q->where('standort_id', $this->filterStandortId);
        });
    }
    
    // Raumart-Filter
    if ($this->filterRaumart) {
        $query->whereHas('nutzungsart', function ($q) {
            $q->where('raumart', $this->filterRaumart);
        });
    }
    
    return $query->orderBy('raumnr_neu')->paginate(25);
});

$filteredCount = computed(function () {
    $query = Raum::query();
    
    // Text-Suche
    if ($this->search) {
        $query->where(function ($q) {
            $q->where('raumnummer', 'like', "%{$this->search}%")
              ->orWhere('raumnr_neu', 'like', "%{$this->search}%")
              ->orWhere('kurzzeichen', 'like', "%{$this->search}%")
              ->orWhere('druckbezeichnung', 'like', "%{$this->search}%");
        });
    }
    
    // Toggle-Filter
    if ($this->filterMitBueId) {
        $query->whereNotNull('bue_id');
    }
    
    if ($this->filterMitItexiaId) {
        $query->whereNotNull('itexia_id');
    }
    
    if ($this->filterOhneNeueNr) {
        $query->whereNull('raumnr_neu');
    }
    
    // Standort-Filter
    if ($this->filterStandortId) {
        $query->whereHas('gebaeude', function ($q) {
            $q->where('standort_id', $this->filterStandortId);
        });
    }
    
    // Raumart-Filter
    if ($this->filterRaumart) {
        $query->whereHas('nutzungsart', function ($q) {
            $q->where('raumart', $this->filterRaumart);
        });
    }
    
    return $query->count();
});

$delete = function (Raum $raum) {
    if (Gate::denies('delete', $raum)) {
        Flux::toast(text: 'Sie haben keine Berechtigung, diesen Raum zu löschen.', variant: 'danger');
        return;
    }
    
    $raum->delete();
    
    $this->dispatch('raum-deleted');
    Flux::toast(text: 'Raum erfolgreich gelöscht!', variant: 'success');
};

$exportExcel = function () {
    $query = Raum::query();
    
    // Gleiche Filter wie oben anwenden
    if ($this->search) {
        $query->where(function ($q) {
            $q->where('raumnummer', 'like', "%{$this->search}%")
              ->orWhere('raumnr_neu', 'like', "%{$this->search}%")
              ->orWhere('kurzzeichen', 'like', "%{$this->search}%")
              ->orWhere('druckbezeichnung', 'like', "%{$this->search}%");
        });
    }
    
    if ($this->filterMitBueId) {
        $query->whereNotNull('bue_id');
    }
    
    if ($this->filterMitItexiaId) {
        $query->whereNotNull('itexia_id');
    }
    
    if ($this->filterOhneNeueNr) {
        $query->whereNull('raumnr_neu');
    }
    
    if ($this->filterStandortId) {
        $query->whereHas('gebaeude', function ($q) {
            $q->where('standort_id', $this->filterStandortId);
        });
    }
    
    if ($this->filterRaumart) {
        $query->whereHas('nutzungsart', function ($q) {
            $q->where('raumart', $this->filterRaumart);
        });
    }
    
    $ids = $query->pluck('id')->toArray();
    
    return Raum::exportExcel($ids);
};

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Räume" subheading="Verwalten Sie alle Räume">
    <flux:card class="glass-card">
    <div class="space-y-6">
        <!-- Filter und Actions -->
        <div class="flex items-center justify-between gap-4">
            <div class="flex-1">
                <flux:input 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Suchen nach Raumnummer, Kurzzeichen, Druckbezeichnung..." 
                    class="w-full"
                />
            </div>
            
            <div class="flex gap-2">
                <flux:button wire:click="exportExcel" variant="ghost" icon="document-arrow-down">
                    Excel Export
                </flux:button>
                
                <flux:button :href="route('apps.raumverwaltung.raeume.create')" wire:navigate variant="primary" icon="plus">
                    Neuer Raum
                </flux:button>
            </div>
        </div>

        <!-- Filter-Optionen -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-5">
            <!-- Toggle-Filter -->
            <flux:field>
                <flux:checkbox wire:model.live="filterMitBueId" label="Nur mit BuE-ID" />
            </flux:field>
            
            <flux:field>
                <flux:checkbox wire:model.live="filterMitItexiaId" label="Nur mit Itexia-ID" />
            </flux:field>
            
            <flux:field>
                <flux:checkbox wire:model.live="filterOhneNeueNr" label="Nur ohne Neue Nr." />
            </flux:field>
            
            <!-- Standort-Filter -->
            <flux:field>
                <flux:label>Standort</flux:label>
                <flux:select wire:model.live="filterStandortId">
                    <option value="">Alle Standorte</option>
                    @foreach($this->standorte as $standort)
                        <option value="{{ $standort->id }}">{{ $standort->kurz }}</option>
                    @endforeach
                </flux:select>
            </flux:field>
            
            <!-- Raumart-Filter -->
            <flux:field>
                <flux:label>Raumart</flux:label>
                <flux:select wire:model.live="filterRaumart">
                    <option value="">Alle Raumarten</option>
                    @foreach(RaumartEnum::cases() as $raumart)
                        <option value="{{ $raumart->value }}">{{ $raumart->name }}</option>
                    @endforeach
                </flux:select>
            </flux:field>
        </div>

        <!-- Anzahl gefilterter Datensätze -->
        <div class="text-sm text-slate-500 dark:text-white/50">
            Gefilterte Räume: {{ $this->filteredCount }}
        </div>

        <!-- Tabelle -->
        <flux:table :paginate="$this->raeume">
            <flux:table.columns>
                <flux:table.column>ID</flux:table.column>
                <flux:table.column>Neue Nr.</flux:table.column>
                <flux:table.column>Druckbezeichnung</flux:table.column>
                <flux:table.column>Gültig ab</flux:table.column>
                <flux:table.column>Gültig bis</flux:table.column>
                <flux:table.column>Etage</flux:table.column>
                <flux:table.column>Pri/Sek</flux:table.column>
                <flux:table.column>Aktionen</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->raeume as $raum)
                    <flux:table.row>
                        <flux:table.cell>{{ $raum->id }}</flux:table.cell>
                        <flux:table.cell>{{ $raum->raumnr_neu ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $raum->druckbezeichnung ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $raum->gueltig_ab?->format('d.m.Y') ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $raum->gueltig_bis?->format('d.m.Y') ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $raum->etage?->bezeichnung ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $raum->pri_sek?->name ?? '-' }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-2">
                                @can('update', $raum)
                                    <flux:button 
                                        size="sm" 
                                        variant="ghost" 
                                        icon="pencil" 
                                        :href="route('apps.raumverwaltung.raeume.edit', $raum)" 
                                        wire:navigate
                                    />
                                @endcan
                                
                                @can('view', $raum)
                                    <flux:button 
                                        size="sm" 
                                        variant="ghost" 
                                        icon="clock" 
                                        :href="route('apps.raumverwaltung.raeume.versions', $raum)" 
                                        wire:navigate
                                    />
                                @endcan
                                
                                @if(($raum->bue_id || $raum->itexia_id) && Gate::allows('view', $raum))
                                    <flux:button 
                                        size="sm" 
                                        variant="ghost" 
                                        icon="arrows-right-left" 
                                        :href="route('apps.raumverwaltung.raeume.compare', $raum)" 
                                        wire:navigate
                                        title="Vergleich anzeigen"
                                    />
                                @endif
                                
                                @can('delete', $raum)
                                    <flux:button 
                                        size="sm" 
                                        variant="ghost" 
                                        icon="trash" 
                                        wire:click="delete({{ $raum->id }})"
                                        wire:confirm="Wollen Sie wirklich den Raum {{ $raum->id }} löschen?"
                                    />
                                @endcan
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
    </flux:card>
</x-intranet-app-raumverwaltung::raumverwaltung-layout>
</div>
