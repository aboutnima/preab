<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumToArray;

enum GenderEnum: string
{
    use EnumToArray;

    case Male = 'male';
    case Female = 'female';

    public function getLabel(): string
    {
        return match ($this) {
            self::Male => 'Male',
            self::Female => 'Female',
        };
    }
}
