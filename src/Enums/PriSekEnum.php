<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Enums;

use Hwkdo\IntranetAppBase\Traits\hasEnumTrait;

enum PriSekEnum: string
{
    use hasEnumTrait;

    case Primaer = 'primary';
    case Sekundaer = 'secondary';

}
