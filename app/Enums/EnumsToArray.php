<?php

namespace App\Enums;

trait EnumsToArray
{
    public static function toArray(): array {
        return array_map(
            fn(self $enum) => $enum->value,
            self::cases()
        );
    }
}
