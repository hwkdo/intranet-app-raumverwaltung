<?php

use Hwkdo\IntranetAppRaumverwaltung\Models\Raum;
use function Livewire\Volt\{state, title, computed, mount};

title('Raum-Vergleich');

state([
    'raum',
]);

mount(function (Raum $raum) {
    $this->raum = $raum;
});

$bueData = computed(fn() => $this->raum->bue() ?: null);
$itexiaData = computed(fn() => $this->raum->itexia() ?: null);

$compareField = function (string $field, $localValue, $bueValue = null, $itexiaValue = null) {
    $local = $localValue ?? '';
    $bue = $bueValue ?? '';
    $itexia = $itexiaValue ?? '';
    
    $localStr = is_object($local) ? (string) $local : (string) $local;
    $bueStr = is_object($bue) ? (string) $bue : (string) $bue;
    $itexiaStr = is_object($itexia) ? (string) $itexia : (string) $itexia;
    
    $bueMatch = $bueValue !== null && trim($localStr) === trim($bueStr);
    $itexiaMatch = $itexiaValue !== null && trim($localStr) === trim($itexiaStr);
    $allMatch = ($bueValue === null || $bueMatch) && ($itexiaValue === null || $itexiaMatch);
    
    return [
        'local' => $local,
        'bue' => $bueValue,
        'itexia' => $itexiaValue,
        'bue_match' => $bueMatch,
        'itexia_match' => $itexiaMatch,
        'all_match' => $allMatch,
    ];
};

$comparisons = computed(function () use ($compareField) {
    $bue = $this->bueData;
    $itexia = $this->itexiaData;
    
    return [
        'raumnummer' => $compareField(
            'raumnummer',
            $this->raum->raumnummer,
            $bue->raumnummer ?? null,
            $itexia->nummer ?? null
        ),
        'druckbezeichnung' => $compareField(
            'druckbezeichnung',
            $this->raum->druckbezeichnung,
            $bue->druckbezeichnung ?? null,
            $itexia->name ?? null
        ),
        'kurzzeichen' => $compareField(
            'kurzzeichen',
            $this->raum->kurzzeichen,
            $bue->kurzzeichen ?? null,
            null
        ),
        'plaetze' => $compareField(
            'plaetze',
            $this->raum->plaetze,
            $bue->plaetze ?? null,
            null
        ),
        'plaetze_ff' => $compareField(
            'plaetze_ff',
            $this->raum->plaetze_ff,
            $bue->plaetzefoerderfÄhig ?? null,
            null
        ),
        'qm' => $compareField(
            'qm',
            $this->raum->qm,
            $bue->flaeche ?? null,
            null
        ),
        'strasse' => $compareField(
            'strasse',
            $this->raum->strasse,
            $bue ? trim(($bue->strasse ?? '').' '.($bue->hausnummer ?? '')) : null,
            null
        ),
        'plz' => $compareField(
            'plz',
            $this->raum->plz,
            $bue->plz ?? null,
            null
        ),
        'ort' => $compareField(
            'ort',
            $this->raum->ort,
            $bue->ort ?? null,
            null
        ),
        'gueltig_ab' => $compareField(
            'gueltig_ab',
            $this->raum->gueltig_ab?->format('Y-m-d'),
            $bue->gueltig_ab ?? null,
            null
        ),
        'gueltig_bis' => $compareField(
            'gueltig_bis',
            $this->raum->gueltig_bis?->format('Y-m-d'),
            $bue->gueltig_bis ?? null,
            null
        ),
        'etage' => $compareField(
            'etage',
            $this->raum->etage?->bezeichnung,
            null,
            $itexia->etage ?? null
        ),
        'mitarbeiter' => $compareField(
            'mitarbeiter',
            null,
            null,
            $itexia->mitarbeiter ?? null
        ),
        'kostenstelle' => $compareField(
            'kostenstelle',
            $this->raum->fachbereich?->kst,
            null,
            $itexia->kostenstelle ?? null
        ),
    ];
});

?>

<div>
    <x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Raum-Vergleich" subheading="Vergleich der Datenstände">
        <flux:card class="glass-card">
            <div class="mb-6">
                <flux:heading size="lg" class="mb-4">Raum: {{ $raum->raumnr_neu ?? $raum->raumnummer ?? 'N/A' }}</flux:heading>
                
                <div class="mb-4 flex gap-4">
                    <flux:badge variant="{{ $raum->bue_id ? 'success' : 'muted' }}">
                        BUE: {{ $raum->bue_id ? 'Verfügbar (ID: ' . $raum->bue_id . ')' : 'Nicht verfügbar' }}
                    </flux:badge>
                    <flux:badge variant="{{ $raum->itexia_id ? 'success' : 'muted' }}">
                        Itexia/Seventhings: {{ $raum->itexia_id ? 'Verfügbar (ID: ' . $raum->itexia_id . ')' : 'Nicht verfügbar' }}
                    </flux:badge>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b-2 border-[#d0e3f9] dark:border-white/20">
                            <th class="text-left p-3 font-semibold">Feld</th>
                            <th class="text-left p-3 font-semibold bg-blue-50 dark:bg-blue-950">Lokales System</th>
                            @if($raum->bue_id)
                                <th class="text-left p-3 font-semibold bg-green-50 dark:bg-green-950">BUE</th>
                            @endif
                            @if($raum->itexia_id)
                                <th class="text-left p-3 font-semibold bg-purple-50 dark:bg-purple-950">Itexia/Seventhings</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->comparisons as $fieldName => $comparison)
                            @php
                                $fieldLabels = [
                                    'raumnummer' => 'Raumnummer',
                                    'druckbezeichnung' => 'Druckbezeichnung',
                                    'kurzzeichen' => 'Kurzzeichen',
                                    'plaetze' => 'Plätze',
                                    'plaetze_ff' => 'Plätze FF',
                                    'qm' => 'Quadratmeter',
                                    'strasse' => 'Straße',
                                    'plz' => 'PLZ',
                                    'ort' => 'Ort',
                                    'gueltig_ab' => 'Gültig ab',
                                    'gueltig_bis' => 'Gültig bis',
                                    'etage' => 'Etage',
                                    'mitarbeiter' => 'Mitarbeiter',
                                    'kostenstelle' => 'Kostenstelle',
                                ];
                                $label = $fieldLabels[$fieldName] ?? $fieldName;
                            @endphp
                            <tr class="border-b border-[#d0e3f9]/60 dark:border-white/10 hover:bg-[#d0e3f9]/20 dark:hover:bg-white/5">
                                <td class="p-3 font-medium">{{ $label }}</td>
                                
                                <!-- Lokales System -->
                                <td class="p-3 bg-blue-50 dark:bg-blue-950">
                                    <div class="flex items-center gap-2">
                                        <span>{{ $comparison['local'] ?: '-' }}</span>
                                    </div>
                                </td>
                                
                                <!-- BUE -->
                                @if($raum->bue_id)
                                    <td class="p-3 bg-green-50 dark:bg-green-950">
                                        <div class="flex items-center gap-2">
                                            <span>{{ $comparison['bue'] !== null ? $comparison['bue'] : '-' }}</span>
                                            @if($comparison['bue'] !== null)
                                                @if($comparison['bue_match'])
                                                    <flux:badge size="sm" variant="success">✓</flux:badge>
                                                @else
                                                    <flux:badge size="sm" variant="danger">✗</flux:badge>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                @endif
                                
                                <!-- Itexia/Seventhings -->
                                @if($raum->itexia_id)
                                    <td class="p-3 bg-purple-50 dark:bg-purple-950">
                                        <div class="flex items-center gap-2">
                                            <span>{{ $comparison['itexia'] !== null ? $comparison['itexia'] : '-' }}</span>
                                            @if($comparison['itexia'] !== null)
                                                @if($comparison['itexia_match'])
                                                    <flux:badge size="sm" variant="success">✓</flux:badge>
                                                @else
                                                    <flux:badge size="sm" variant="danger">✗</flux:badge>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex gap-4">
                <flux:button :href="route('apps.raumverwaltung.raeume.edit', $raum)" wire:navigate variant="primary">
                    Zur Bearbeitung
                </flux:button>
                <flux:button :href="route('apps.raumverwaltung.raeume.index')" wire:navigate variant="ghost">
                    Zurück zur Übersicht
                </flux:button>
            </div>
        </flux:card>
    </x-intranet-app-raumverwaltung::raumverwaltung-layout>
</div>

