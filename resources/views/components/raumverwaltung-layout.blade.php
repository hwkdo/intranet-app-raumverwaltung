@props([
    'heading' => '',
    'subheading' => '',
    'navItems' => []
])

@php
    $defaultNavItems = [
        ['label' => 'Übersicht', 'href' => route('apps.raumverwaltung.index'), 'icon' => 'home', 'description' => 'Zurück zur Übersicht', 'buttonText' => 'Übersicht anzeigen'],
        ['label' => 'Räume', 'href' => route('apps.raumverwaltung.raeume.index'), 'icon' => 'home', 'description' => 'Räume verwalten', 'buttonText' => 'Räume anzeigen'],
        ['label' => 'Standorte', 'href' => route('apps.raumverwaltung.standorte.index'), 'icon' => 'map-pin', 'description' => 'Standorte verwalten', 'buttonText' => 'Standorte anzeigen'],
        ['label' => 'Gebäude', 'href' => route('apps.raumverwaltung.gebaeude.index'), 'icon' => 'building-office', 'description' => 'Gebäude verwalten', 'buttonText' => 'Gebäude anzeigen'],
        ['label' => 'Nutzungsarten', 'href' => route('apps.raumverwaltung.nutzungsarten.index'), 'icon' => 'tag', 'description' => 'Nutzungsarten verwalten', 'buttonText' => 'Nutzungsarten anzeigen'],
        ['label' => 'Fachbereiche', 'href' => route('apps.raumverwaltung.fachbereiche.index'), 'icon' => 'briefcase', 'description' => 'Fachbereiche verwalten', 'buttonText' => 'Fachbereiche anzeigen'],
        ['label' => 'Etagen', 'href' => route('apps.raumverwaltung.etagen.index'), 'icon' => 'squares-2x2', 'description' => 'Etagen verwalten', 'buttonText' => 'Etagen anzeigen'],
        ['label' => 'Ereignisse', 'href' => route('apps.raumverwaltung.ereignisse.index'), 'icon' => 'clock', 'description' => 'Versionshistorie anzeigen', 'buttonText' => 'Ereignisse anzeigen'],
        ['label' => 'Meine Einstellungen', 'href' => route('apps.raumverwaltung.settings.user'), 'icon' => 'cog-6-tooth', 'description' => 'Persönliche Einstellungen anpassen', 'buttonText' => 'Einstellungen öffnen'],
        ['label' => 'Admin', 'href' => route('apps.raumverwaltung.admin.index'), 'icon' => 'shield-check', 'description' => 'Administrationsbereich verwalten', 'buttonText' => 'Admin öffnen', 'permission' => 'manage-app-raumverwaltung']
    ];
    
    $navItems = !empty($navItems) ? $navItems : $defaultNavItems;
    $customBgUrl = \Hwkdo\IntranetAppBase\Models\AppBackground::getCustomBackgroundUrl('raumverwaltung');
@endphp

@if($customBgUrl)
    @push('app-styles')
    <style data-app-bg data-ts="{{ uniqid() }}">
        :root { --app-bg-image: url('{{ $customBgUrl }}'); }
    </style>
    @endpush
@endif

@if(request()->routeIs('apps.raumverwaltung.index'))
    <x-intranet-app-base::app-layout 
        app-identifier="raumverwaltung"
        :heading="$heading"
        :subheading="$subheading"
        :nav-items="$navItems"
        :wrap-in-card="false"
    >
        <x-intranet-app-base::app-index-auto 
            app-identifier="raumverwaltung"
            app-name="Raumverwaltung"
            app-description="Verwaltung von Räumen und Standorten"
            :nav-items="$navItems"
            welcome-title="Willkommen in der Raumverwaltung"
            welcome-description="Hier können Sie alle Aspekte der Raumverwaltung verwalten, einschließlich Standorte, Gebäude, Etagen, Nutzungsarten, Fachbereiche und Räume."
        />
    </x-intranet-app-base::app-layout>
@else
    <x-intranet-app-base::app-layout 
        app-identifier="raumverwaltung"
        :heading="$heading"
        :subheading="$subheading"
        :nav-items="$navItems"
        :wrap-in-card="true"
    >
        {{ $slot }}
    </x-intranet-app-base::app-layout>
@endif

