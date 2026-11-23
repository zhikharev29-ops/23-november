<?php
declare(strict_types=1);

namespace Shop\Helpers;

class PriceFormatter
{
    public static function format(float $price): string
    {
        return number_format($price, 2, ',', ' ') . ' ₽';
    }
}
