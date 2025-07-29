<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::middleware(['web','auth','can:see-app-raumverwaltung'])->group(function () {        
    Volt::route('apps/raumverwaltung', 'apps.raumverwaltung.index')->name('apps.raumverwaltung.index');                
});
