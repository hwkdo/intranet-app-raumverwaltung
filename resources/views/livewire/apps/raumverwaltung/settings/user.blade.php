<?php

use function Livewire\Volt\{title};

title('Meine Einstellungen - Raumverwaltung');

?>

<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="Meine Einstellungen" subheading="Persönliche Einstellungen für die Raumverwaltung">
    @livewire('intranet-app-base::user-settings', ['appIdentifier' => 'raumverwaltung'])
</x-intranet-app-raumverwaltung::raumverwaltung-layout>
</div>
