<?php
declare(strict_types=1);

spl_autoload_register(function (string $class): void {
    $prefix  = 'Shop\\';
    $baseDir = __DIR__ . '/src/';

    if (!str_starts_with($class, $prefix)) {
        return; // не наш класс — пусть грузит другой загрузчик
    }

    $relative = substr($class, strlen($prefix));                        // Models\Product
    $file = $baseDir . str_replace('\\', '/', $relative) . '.php';      // src/Models/Product.php

    if (is_file($file)) {
        require $file;
    }
});
