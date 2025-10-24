<?php

use function Livewire\Volt\{title};

title('Meine Einstellungen - Raumverwaltung');

?>

<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Raumverwaltung" subheading="Meine Einstellungen">
    <x-intranet-app-base::user-settings app-identifier="raumverwaltung" />
</x-intranet-app-raumverwaltung::raumverwaltung-layout>
