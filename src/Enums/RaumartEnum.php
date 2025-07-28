<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Enums;

use Hwkdo\IntranetAppBase\Traits\hasEnumTrait;

enum RaumartEnum: string
{
    use hasEnumTrait;
    
    case Schulung = 'schulung';
    case Verwaltung = 'verwaltung';
        
}