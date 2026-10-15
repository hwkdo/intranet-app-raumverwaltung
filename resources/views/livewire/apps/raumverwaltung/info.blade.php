<?php

use function Livewire\Volt\{title};

title('Raumverwaltung - App-Info');

?>
<div>
<x-intranet-app-raumverwaltung::raumverwaltung-layout heading="App-Info" subheading="Installierte Version und Release-Historie">
    @livewire('intranet-app-base::app-info', ['appIdentifier' => 'raumverwaltung'])
</x-intranet-app-raumverwaltung::raumverwaltung-layout>
</div>
