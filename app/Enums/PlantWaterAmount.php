<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum PlantWaterAmount: int
{
    use Values;
    case SMALL = 0;
    case NORMAL = 1;
    case LARGE = 2;

    public function label(): string
    {
        return match($this) {
            self::SMALL => 'Small (e.g. 250ml/week)',
            self::NORMAL => 'Normal (e.g. 500ml/week)',
            self::LARGE => 'Large (e.g. 1L+/week)',
        };
    }
}
