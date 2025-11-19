<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Raum;
use Mpociot\Versionable\Version;
use function Livewire\Volt\{state, title, computed};

title('Ereignisse');

$ereignisse = computed(function () {
    return Version::where('versionable_type', Raum::class)
        ->orderBy('version_id', 'desc')
        ->limit(20)
        ->get();
});

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Ereignisse" subheading="Letzte 20 Änderungen an Räumen">
    <div class="space-y-6">
        @if($this->ereignisse->count() > 0)
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Version ID</flux:table.column>
                    <flux:table.column>Raum ID</flux:table.column>
                    <flux:table.column>Benutzer ID</flux:table.column>
                    <flux:table.column>Erstellt am</flux:table.column>
                    <flux:table.column>Aktionen</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($this->ereignisse as $ereignis)
                        <flux:table.row>
                            <flux:table.cell>{{ $ereignis->version_id }}</flux:table.cell>
                            <flux:table.cell>{{ $ereignis->versionable_id }}</flux:table.cell>
                            <flux:table.cell>{{ $ereignis->user_id ?? '-' }}</flux:table.cell>
                            <flux:table.cell>{{ $ereignis->created_at->format('d.m.Y H:i:s') }}</flux:table.cell>
                            <flux:table.cell>
                                @php
                                    $raum = Raum::withTrashed()->find($ereignis->versionable_id);
                                @endphp
                                @if($raum && Gate::allows('view', $raum))
                                    <flux:button 
                                        size="sm" 
                                        variant="ghost" 
                                        icon="eye" 
                                        :href="route('apps.raumverwaltung.raeume.versions', $ereignis->versionable_id)" 
                                        wire:navigate
                                    >
                                        Details
                                    </flux:button>
                                @endif
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        @else
            <flux:card class="p-6 text-center">
                <p class="text-gray-600 dark:text-gray-400">
                    Keine Ereignisse gefunden.
                </p>
            </flux:card>
        @endif
    </div>
</x-intranet-app-raumverwaltung::raumverwaltung-layout>
</div>
