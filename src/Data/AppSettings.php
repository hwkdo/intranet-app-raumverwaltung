<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Data;

use Hwkdo\IntranetAppBase\Data\BaseAppSettings;
use Hwkdo\IntranetAppBase\Data\Attributes\Description;

class AppSettings extends BaseAppSettings
{
    public function __construct(
        #[Description('Aktiviert die automatische Raum-Reservierung')]
        public bool $enableAutoReservation = true,
        
        #[Description('Maximale Reservierungsdauer in Stunden')]
        public int $maxReservationHours = 8,
        
        #[Description('Erlaubte Reservierungszeiten (JSON Array)')]
        public array $allowedTimeSlots = ['08:00-12:00', '13:00-17:00'],
        
        #[Description('Benachrichtigungen für Reservierungen aktiviert')]
        public bool $notificationsEnabled = true,
    ) {}
}
