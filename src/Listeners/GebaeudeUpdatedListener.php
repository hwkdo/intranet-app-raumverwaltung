<?php

namespace App\Apps\Raumverwaltung\Listeners;

use App\Apps\Raumverwaltung\Events\GebaeudeUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GebaeudeUpdatedListener
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
    public function handle(GebaeudeUpdated $event): void
    {
        if($event->gebaeude->isDirty('zeichen')){
            \Log::info('Gebaeude Zeichen Updated: ' . $event->gebaeude->zeichen);            
            $event->gebaeude->raums->each(function($raum){
                $raum->update(['raumnr_neu' => $raum->generateMyNumber()]);
            });
        }
    }
}
