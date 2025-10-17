<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Policies;

use Hwkdo\IntranetAppRaumverwaltung\IntranetAppRaumverwaltung;
use Hwkdo\IntranetAppRaumverwaltung\Models\Raum;
use Illuminate\Contracts\Auth\Authenticatable as User;

class RaumPolicy
{
    const APP_NAME = 'raumverwaltung';

    private $app;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        $this->app = new IntranetAppRaumverwaltung;
    }

    public function view(User $user, Raum $raum)
    {
        return $user->hasAnyRole($this->app->roles_user()) || $user->hasAnyRole($this->app->roles_admin());
    }

    public function update(User $user, Raum $raum)
    {
        if (! $raum->nutzungsart_id) {
            return true;
        }

        return $user->hasAnyRole($this->app->roles_admin()) ? true : match ($raum->nutzungsart->raumart->value) {
            'verwaltung' => $user->hasAnyRole(config('intranet-app-raumverwaltung.rollen.rw.verwaltung')),
            'schulung' => $user->hasAnyRole(config('intranet-app-raumverwaltung.rollen.rw.schulung')),
            default => false
        };
    }

    public function delete(User $user, Raum $raum)
    {
        if (! $raum->nutzungsart_id) {
            return true;
        }

        return $user->hasAnyRole($this->app->roles_admin()) ? true : match ($raum->nutzungsart->raumart->value) {
            'verwaltung' => $user->hasAnyRole(config('intranet-app-raumverwaltung.rollen.rw.verwaltung')),
            'schulung' => $user->hasAnyRole(config('intranet-app-raumverwaltung.rollen.rw.schulung')),
            default => false
        };
    }
}
