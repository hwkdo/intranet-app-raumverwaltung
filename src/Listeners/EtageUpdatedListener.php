<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Listeners;

use Hwkdo\IntranetAppRaumverwaltung\Events\EtageUpdated;
use Illuminate\Support\Facades\Log;

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
            Log::info('Etage Zeichen Updated: '.$event->etage->zeichen);
            $event->etage->raums->each(function ($raum) {
                $raum->update(['raumnr_neu' => $raum->generateMyNumber()]);
            });
        }
    }
}
