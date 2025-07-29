<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::middleware(['web','auth'])->group(function () {        
    Volt::route('apps/raumverwaltung', 'apps.raumverwaltung.index')->name('apps.raumverwaltung.index');                
});
