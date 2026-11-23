<?php
declare(strict_types=1);

namespace Shop\Models;

// Дополнительное задание: новый класс, нигде не подключается вручную
class Order
{
    public function __construct(
        public int $number,
        public Customer $customer,
        public float $total,
    ) {}
}
