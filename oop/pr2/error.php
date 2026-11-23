<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

// Шаг 7: обращение к несуществующему классу
try {
    $x = new Shop\Models\Invoice();
} catch (Error $e) {
    echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
}
