<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware(['web', 'auth', 'can:see-app-raumverwaltung'])->group(function () {
    Volt::route('apps/raumverwaltung', 'apps.raumverwaltung.index')->name('apps.raumverwaltung.index');

    // Standorte
    Volt::route('apps/raumverwaltung/standorte', 'apps.raumverwaltung.standorte.index')->name('apps.raumverwaltung.standorte.index');
    Volt::route('apps/raumverwaltung/standorte/create', 'apps.raumverwaltung.standorte.create')->name('apps.raumverwaltung.standorte.create');
    Volt::route('apps/raumverwaltung/standorte/{standort}/edit', 'apps.raumverwaltung.standorte.edit')->name('apps.raumverwaltung.standorte.edit');

    // Gebäude
    Volt::route('apps/raumverwaltung/gebaeude', 'apps.raumverwaltung.gebaeude.index')->name('apps.raumverwaltung.gebaeude.index');
    Volt::route('apps/raumverwaltung/gebaeude/create', 'apps.raumverwaltung.gebaeude.create')->name('apps.raumverwaltung.gebaeude.create');
    Volt::route('apps/raumverwaltung/gebaeude/{gebaeude}/edit', 'apps.raumverwaltung.gebaeude.edit')->name('apps.raumverwaltung.gebaeude.edit');

    // Etagen
    Volt::route('apps/raumverwaltung/etagen', 'apps.raumverwaltung.etagen.index')->name('apps.raumverwaltung.etagen.index');
    Volt::route('apps/raumverwaltung/etagen/create', 'apps.raumverwaltung.etagen.create')->name('apps.raumverwaltung.etagen.create');
    Volt::route('apps/raumverwaltung/etagen/{etage}/edit', 'apps.raumverwaltung.etagen.edit')->name('apps.raumverwaltung.etagen.edit');

    // Nutzungsarten
    Volt::route('apps/raumverwaltung/nutzungsarten', 'apps.raumverwaltung.nutzungsarten.index')->name('apps.raumverwaltung.nutzungsarten.index');
    Volt::route('apps/raumverwaltung/nutzungsarten/create', 'apps.raumverwaltung.nutzungsarten.create')->name('apps.raumverwaltung.nutzungsarten.create');
    Volt::route('apps/raumverwaltung/nutzungsarten/{nutzungsart}/edit', 'apps.raumverwaltung.nutzungsarten.edit')->name('apps.raumverwaltung.nutzungsarten.edit');

    // Fachbereiche
    Volt::route('apps/raumverwaltung/fachbereiche', 'apps.raumverwaltung.fachbereiche.index')->name('apps.raumverwaltung.fachbereiche.index');
    Volt::route('apps/raumverwaltung/fachbereiche/create', 'apps.raumverwaltung.fachbereiche.create')->name('apps.raumverwaltung.fachbereiche.create');
    Volt::route('apps/raumverwaltung/fachbereiche/{fachbereich}/edit', 'apps.raumverwaltung.fachbereiche.edit')->name('apps.raumverwaltung.fachbereiche.edit');

    // Räume
    Volt::route('apps/raumverwaltung/raeume', 'apps.raumverwaltung.raeume.index')->name('apps.raumverwaltung.raeume.index');
    Volt::route('apps/raumverwaltung/raeume/create', 'apps.raumverwaltung.raeume.create')->name('apps.raumverwaltung.raeume.create');
    Volt::route('apps/raumverwaltung/raeume/{raum}/edit', 'apps.raumverwaltung.raeume.edit')->name('apps.raumverwaltung.raeume.edit');
    Volt::route('apps/raumverwaltung/raeume/{raum}/versions', 'apps.raumverwaltung.raeume.versions')->name('apps.raumverwaltung.raeume.versions');
    Volt::route('apps/raumverwaltung/raeume/{raum}/compare', 'apps.raumverwaltung.raeume.compare')->name('apps.raumverwaltung.raeume.compare');
    
    // Ereignisse
    Volt::route('apps/raumverwaltung/ereignisse', 'apps.raumverwaltung.ereignisse.index')->name('apps.raumverwaltung.ereignisse.index');
    
    // Settings
    Volt::route('apps/raumverwaltung/settings/user', 'apps.raumverwaltung.settings.user')->name('apps.raumverwaltung.settings.user');
});

Route::middleware(['web','auth','can:manage-app-raumverwaltung'])->group(function () {
    Volt::route('apps/raumverwaltung/admin', 'apps.raumverwaltung.admin.index')->name('apps.raumverwaltung.admin.index');
});
