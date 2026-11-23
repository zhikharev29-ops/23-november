<?php
declare(strict_types=1);

require __DIR__ . '/QueryBuilder.php';

echo "=== Запрос 1: пример из задания ===" . PHP_EOL;
echo QueryBuilder::table('users')
    ->select('id', 'name', 'email')
    ->where('age', '>=', 18)
    ->where('city', '=', 'Москва')
    ->orderBy('name')
    ->limit(10) . PHP_EOL;

echo PHP_EOL . "=== Запрос 2: без select (по умолчанию *) ===" . PHP_EOL;
echo QueryBuilder::table('products') . PHP_EOL;

echo PHP_EOL . "=== Запрос 3: LIKE и сортировка по убыванию ===" . PHP_EOL;
echo QueryBuilder::table('products')
    ->select('title', 'price')
    ->where('title', 'LIKE', 'Ноут%')
    ->where('price', '<', 100000)
    ->orderBy('price', 'desc')
    ->limit(5)->toSql() . PHP_EOL;

echo PHP_EOL . "=== Дополнительно: __call() ===" . PHP_EOL;
echo QueryBuilder::table('users')
    ->select('id')
    ->whereCity('Москва')
    ->whereFirstName('Анна')
    ->whereAge(25) . PHP_EOL;

echo PHP_EOL . "=== Перехваченные исключения ===" . PHP_EOL;
$errors = [
    'Неверное направление' => fn() => QueryBuilder::table('t')->orderBy('id', 'UP'),
    'limit = 0'            => fn() => QueryBuilder::table('t')->limit(0),
    'Отрицательный limit'  => fn() => QueryBuilder::table('t')->limit(-5),
    'Неверный оператор'    => fn() => QueryBuilder::table('t')->where('id', '<>', 1),
    'whereX без аргумента' => fn() => QueryBuilder::table('t')->whereCity(),
    'Несуществующий метод' => fn() => QueryBuilder::table('t')->groupBy('id'),
];
foreach ($errors as $label => $action) {
    try {
        $action();
        echo "{$label}: ошибки нет (неожиданно)" . PHP_EOL;
    } catch (InvalidArgumentException | BadMethodCallException $e) {
        echo "{$label}: " . get_class($e) . ' — ' . $e->getMessage() . PHP_EOL;
    }
}
