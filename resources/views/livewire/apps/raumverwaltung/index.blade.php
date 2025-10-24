<?php

use function Livewire\Volt\{title};

title('Raumverwaltung');

?>

<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Raumverwaltung" subheading="Verwaltung von Räumen und Standorten">
    <x-intranet-app-base::app-index-auto 
        app-identifier="raumverwaltung"
        app-name="Raumverwaltung"
        app-description="Verwaltung von Räumen und Standorten"
        welcome-title="Willkommen in der Raumverwaltung"
        welcome-description="Hier können Sie alle Aspekte der Raumverwaltung verwalten, einschließlich Standorte, Gebäude, Etagen, Nutzungsarten, Fachbereiche und Räume."
    />
</x-intranet-app-raumverwaltung::raumverwaltung-layout>