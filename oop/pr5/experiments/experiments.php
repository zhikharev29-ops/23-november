<?php
declare(strict_types=1);

require __DIR__ . '/../Employee.php';
require __DIR__ . '/../Manager.php';
require __DIR__ . '/../Developer.php';

// Предупреждения PHP превращаем в исключения, чтобы увидеть текст
set_error_handler(function (int $no, string $msg): bool {
    throw new ErrorException($msg, 0, $no);
});

$manager = new Manager('Олег Иванов', 90000, '4513 654321', 4);
$developer = new Developer('Мария Петрова', 80000, '4514 987654', 'senior');

$tests = [
    '1. Чтение $name снаружи'            => fn() => $manager->name,
    '2. Чтение $baseSalary снаружи'      => fn() => $manager->baseSalary,
    '3. Чтение $baseSalary в Manager'    => fn() => $manager->probeBaseSalary(),
    '4. Чтение $passport в Manager'      => fn() => $manager->probePassport(),
    '5. Вызов calculateTax() снаружи'    => fn() => $manager->calculateTax(1000.0),
    '6. Вызов validatePercent() в Developer' => fn() => $developer->probeValidatePercent(),
];

foreach ($tests as $label => $action) {
    echo $label . PHP_EOL . '   ';
    try {
        $result = $action();
        echo 'OK, результат: ' . var_export($result, true) . PHP_EOL;
    } catch (Throwable $e) {
        echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
    }
}
