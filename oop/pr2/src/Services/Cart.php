<?php
declare(strict_types=1);

namespace Shop\Services;

use Shop\Models\Customer;
use Shop\Models\Product;

class Cart
{
    private array $items = [];

    public function __construct(private Customer $customer) {}

    public function add(Product $p, int $qty): void
    {
        $this->items[] = ['product' => $p, 'qty' => $qty];
    }

    public function getTotal(): float
    {
        $total = 0.0;
        foreach ($this->items as $item) {
            $total += $item['product']->price * $item['qty'];
        }
        return $total;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}
