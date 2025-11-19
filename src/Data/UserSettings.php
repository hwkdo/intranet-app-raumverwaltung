<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Data;

use Hwkdo\IntranetAppBase\Data\Attributes\Description;
use Hwkdo\IntranetAppBase\Data\BaseUserSettings;

class UserSettings extends BaseUserSettings
{
    public function __construct(
        #[Description('Standard-Ansicht für Raumübersicht')]
        public string $defaultView = 'grid',

        #[Description('Favoriten-Räume des Benutzers')]
        public array $favoriteRooms = [],

        #[Description('E-Mail Benachrichtigungen aktiviert')]
        public bool $emailNotifications = true,
    ) {}
}
