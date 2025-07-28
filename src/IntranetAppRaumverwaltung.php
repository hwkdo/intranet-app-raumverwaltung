<?php

namespace Hwkdo\IntranetAppRaumverwaltung;
use Hwkdo\IntranetAppBase\Interfaces\IntranetAppInterface;
use Illuminate\Support\Collection;

class IntranetAppRaumverwaltung implements IntranetAppInterface
{
    public static function app_name(): string
    {
        return 'Raumverwaltung';
    }

    public static function app_icon(): string
    {
        return 'magnifying-glass';
    }

    public static function identifier(): string
    {
        return 'raumverwaltung';
    }

    public static function roles_admin(): Collection
    {
        return collect(config('intranet-app-raumverwaltung.roles.admin'));
    }

    public static function roles_user(): Collection
    {
        return collect(config('intranet-app-raumverwaltung.roles.user'));
    }    
    
}
