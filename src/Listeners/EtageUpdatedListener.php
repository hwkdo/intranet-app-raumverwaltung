<?php

namespace App\Apps\Raumverwaltung\Listeners;

use App\Apps\Raumverwaltung\Events\EtageUpdated;

class EtageUpdatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EtageUpdated $event): void
    {
        if ($event->etage->isDirty('zeichen')) {
            \Log::info('Etage Zeichen Updated: '.$event->etage->zeichen);
            $event->etage->raums->each(function ($raum) {
                $raum->update(['raumnr_neu' => $raum->generateMyNumber()]);
            });
        }
    }
}
