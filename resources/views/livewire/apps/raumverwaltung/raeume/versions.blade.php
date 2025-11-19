<?php

use Flux\Flux;
use Hwkdo\IntranetAppRaumverwaltung\Models\Raum;
use Mpociot\Versionable\Version;
use function Livewire\Volt\{state, title, computed, mount};

title('Raum Versionen');

state(['raum']);

mount(function (Raum $raum) {
    if (Gate::denies('view', $raum)) {
        abort(403, 'Sie haben keine Berechtigung, die Versionen dieses Raums anzuzeigen.');
    }
    
    $this->raum = $raum;
});

$versions = computed(function () {
    return $this->raum->versions()->orderBy('version_id', 'desc')->get();
});

$revert = function ($versionId) {
    if (Gate::denies('update', $this->raum)) {
        Flux::toast(text: 'Sie haben keine Berechtigung, diesen Raum zu bearbeiten.', variant: 'danger');
        return;
    }
    
    try {
        $version = Version::find($versionId);
        if ($version && $version->versionable_id == $this->raum->id) {
            $version->revert();
            
            Flux::toast(text: 'Version erfolgreich wiederhergestellt!', variant: 'success');
            
            $this->redirect(route('apps.raumverwaltung.raeume.edit', $this->raum), navigate: true);
        }
    } catch (\Exception $e) {
        Flux::toast(text: 'Fehler beim Wiederherstellen der Version: '.$e->getMessage(), variant: 'danger');
    }
};

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Raum {{ $raum->id }} Versionen" subheading="Versionshistorie anzeigen und wiederherstellen">
    <div class="space-y-4">
        <flux:button :href="route('apps.raumverwaltung.raeume.edit', $raum)" wire:navigate variant="ghost" icon="arrow-left">
            Zurück zum Raum
        </flux:button>
        
        @if($this->versions->count() > 0)
            <div class="space-y-4">
                @foreach($this->versions as $version)
                    <flux:card class="p-4">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <flux:heading size="lg">Version {{ $version->version_id }}</flux:heading>
                                    <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        Erstellt am: {{ $version->created_at->format('d.m.Y H:i:s') }}
                                        @if($version->user_id)
                                            | Benutzer ID: {{ $version->user_id }}
                                        @endif
                                    </div>
                                </div>
                                
                                @can('update', $raum)
                                    <flux:button 
                                        size="sm" 
                                        variant="primary" 
                                        wire:click="revert({{ $version->version_id }})"
                                        wire:confirm="Möchten Sie wirklich diese Version wiederherstellen? Die aktuelle Version wird als neue Version gespeichert."
                                    >
                                        Wiederherstellen
                                    </flux:button>
                                @endcan
                            </div>
                            
                            <!-- Diff zur aktuellen Version -->
                            <div class="mt-4">
                                <flux:heading size="md" class="mb-2">Änderungen zur aktuellen Version:</flux:heading>
                                <div class="rounded bg-gray-50 p-4 text-sm dark:bg-gray-900">
                                    @php
                                        $currentData = $raum->toArray();
                                        $versionData = json_decode($version->model_data, true);
                                        $diff = [];
                                        
                                        foreach ($currentData as $key => $currentValue) {
                                            if (isset($versionData[$key]) && $versionData[$key] != $currentValue) {
                                                $diff[$key] = [
                                                    'old' => $versionData[$key],
                                                    'new' => $currentValue
                                                ];
                                            }
                                        }
                                    @endphp
                                    
                                    @if(count($diff) > 0)
                                        <table class="w-full table-auto">
                                            <thead>
                                                <tr class="border-b dark:border-gray-700">
                                                    <th class="px-2 py-1 text-left">Feld</th>
                                                    <th class="px-2 py-1 text-left">Alte Version</th>
                                                    <th class="px-2 py-1 text-left">Aktuelle Version</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($diff as $field => $values)
                                                    <tr class="border-b dark:border-gray-800">
                                                        <td class="px-2 py-1 font-medium">{{ $field }}</td>
                                                        <td class="px-2 py-1 text-red-600 dark:text-red-400">
                                                            {{ is_null($values['old']) ? 'NULL' : $values['old'] }}
                                                        </td>
                                                        <td class="px-2 py-1 text-green-600 dark:text-green-400">
                                                            {{ is_null($values['new']) ? 'NULL' : $values['new'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p class="text-gray-600 dark:text-gray-400">
                                            Keine Unterschiede zur aktuellen Version.
                                        </p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Vollständige Version-Daten (Details) -->
                            <details class="mt-4">
                                <summary class="cursor-pointer text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Vollständige Versionsdaten anzeigen
                                </summary>
                                <div class="mt-2 rounded bg-gray-100 p-3 text-xs dark:bg-gray-800">
                                    <pre class="overflow-auto">{{ json_encode(json_decode($version->model_data, true), JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </details>
                        </div>
                    </flux:card>
                @endforeach
            </div>
        @else
            <flux:card class="p-6 text-center">
                <p class="text-gray-600 dark:text-gray-400">
                    Für diesen Raum gibt es noch keine Versionen.
                </p>
            </flux:card>
        @endif
    </div>
</x-intranet-app-raumverwaltung::raumverwaltung-layout>
</div>
