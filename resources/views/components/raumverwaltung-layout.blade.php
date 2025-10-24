@props([
    'heading' => '',
    'subheading' => '',
    'navItems' => []
])

@php
    $defaultNavItems = [
        ['label' => 'Standorte', 'href' => route('apps.raumverwaltung.standorte.index'), 'icon' => 'map-pin', 'description' => 'Standorte verwalten', 'buttonText' => 'Standorte anzeigen'],
        ['label' => 'Gebäude', 'href' => route('apps.raumverwaltung.gebaeude.index'), 'icon' => 'building-office', 'description' => 'Gebäude verwalten', 'buttonText' => 'Gebäude anzeigen'],
        ['label' => 'Etagen', 'href' => route('apps.raumverwaltung.etagen.index'), 'icon' => 'squares-2x2', 'description' => 'Etagen verwalten', 'buttonText' => 'Etagen anzeigen'],
        ['label' => 'Nutzungsarten', 'href' => route('apps.raumverwaltung.nutzungsarten.index'), 'icon' => 'tag', 'description' => 'Nutzungsarten verwalten', 'buttonText' => 'Nutzungsarten anzeigen'],
        ['label' => 'Fachbereiche', 'href' => route('apps.raumverwaltung.fachbereiche.index'), 'icon' => 'briefcase', 'description' => 'Fachbereiche verwalten', 'buttonText' => 'Fachbereiche anzeigen'],
        ['label' => 'Räume', 'href' => route('apps.raumverwaltung.raeume.index'), 'icon' => 'home', 'description' => 'Räume verwalten', 'buttonText' => 'Räume anzeigen'],
        ['label' => 'Meine Einstellungen', 'href' => route('apps.raumverwaltung.settings.user'), 'icon' => 'cog-6-tooth', 'description' => 'Persönliche Einstellungen anpassen', 'buttonText' => 'Einstellungen öffnen'],
        ['label' => 'Admin', 'href' => route('apps.raumverwaltung.admin.index'), 'icon' => 'shield-check', 'description' => 'Administrationsbereich verwalten', 'buttonText' => 'Admin öffnen', 'permission' => 'manage-app-raumverwaltung']
    ];
    
    $navItems = !empty($navItems) ? $navItems : $defaultNavItems;
@endphp

<x-intranet-app-base::app-layout 
    app-identifier="raumverwaltung"
    :heading="$heading"
    :subheading="$subheading"
    :nav-items="$navItems"
>
    {{ $slot }}
</x-intranet-app-base::app-layout>

