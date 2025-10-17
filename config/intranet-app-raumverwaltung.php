<?php

// config for Hwkdo/IntranetAppRaumverwaltung
return [
    'roles' => [
        'admin' => [
            'name' => 'App-Raumverwaltung-Admin',
            'permissions' => [
                'see-app-raumverwaltung',
                'manage-app-raumverwaltung',
            ],
        ],
        'user' => [
            'name' => 'App-Raumverwaltung-Benutzer',
            'permissions' => [
                'see-app-raumverwaltung',
            ],
        ],
        'others' => [
            'verwaltung' => [
                'name' => 'App-Raumverwaltung-Bearbeiten-Verwaltung',
                'permissions' => [
                    'see-app-raumverwaltung',
                    'edit-app-raumverwaltung-verwaltung',
                ],
            ],
            'schulung' => [
                'name' => 'App-Raumverwaltung-Bearbeiten-Schulung',
                'permissions' => [
                    'see-app-raumverwaltung',
                    'edit-app-raumverwaltung-schulung',
                ],
            ],
        ],
    ],
];
