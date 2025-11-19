<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Listeners;

use Hwkdo\IntranetAppRaumverwaltung\Events\NutzungsartUpdated;
use Illuminate\Support\Facades\Log;

class NutzungsartUpdatedListener
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
    public function handle(NutzungsartUpdated $event): void
    {
        if ($event->nutzungsart->isDirty('zeichen')) {
            Log::info('Nutzungsart Zeichen Updated: '.$event->nutzungsart->zeichen);
            $event->nutzungsart->raums->each(function ($raum) {
                $raum->update(['raumnr_neu' => $raum->generateMyNumber()]);
            });
        }
    }
}
