<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Shop\Helpers\PriceFormatter;
use Shop\Models\Customer;
use Shop\Models\Product;
use Shop\Services\Cart;

$customer = new Customer('Иван Петров', 'ivan@example.com');
$cart = new Cart($customer);
$cart->add(new Product('Клавиатура', 1250.0), 1);
$cart->add(new Product('Мышь', 790.5), 2);
$cart->add(new Product('Коврик', 300.0), 3);

echo "Покупатель: {$customer->name} ({$customer->email})" . PHP_EOL;
echo "Итого: " . PriceFormatter::format($cart->getTotal()) . PHP_EOL;
