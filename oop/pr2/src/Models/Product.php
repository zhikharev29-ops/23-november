<?php
declare(strict_types=1);

namespace Shop\Models;

class Product
{
    public function __construct(
        public string $name,
        public float $price,
    ) {}
}
