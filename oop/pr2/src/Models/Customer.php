<?php
declare(strict_types=1);

namespace Shop\Models;

class Customer
{
    public function __construct(
        public string $name,
        public string $email,
    ) {}
}
