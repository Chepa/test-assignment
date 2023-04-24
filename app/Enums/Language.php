<?php

namespace App\Enums;

enum Language:string
{
    use EnumsToArray;

    case EN = 'en';
    case RU = 'ru';
    case ES = 'es';
}
