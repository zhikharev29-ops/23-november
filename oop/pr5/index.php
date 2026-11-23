<?php
declare(strict_types=1);

require __DIR__ . '/Employee.php';
require __DIR__ . '/Manager.php';
require __DIR__ . '/Developer.php';

function pad(string $s, int $width): string
{
    return $s . str_repeat(' ', max(0, $width - preg_match_all('/./us', $s)));
}
function money(float $x): string
{
    return number_format($x, 2, ',', ' ') . ' ₽';
}

$employees = [
    new Employee('Анна Смирнова', 60000, '4512 123456'),
    new Manager('Олег Иванов', 90000, '4513 654321', 4),
    new Developer('Мария Петрова', 80000, '4514 987654', 'senior'),
    new Developer('Игорь Кузнецов', 70000, '4515 111222', 'middle'),
    new Developer('Павел Орлов', 50000, '4516 333444', 'junior'),
];

echo pad('Имя', 18) . pad('Тип', 11) . pad('До налога', 16) . pad('После налога', 16) . 'Паспорт' . PHP_EOL;
echo str_repeat('-', 76) . PHP_EOL;
foreach ($employees as $e) {
    echo pad($e->name, 18)
        . pad($e::class, 11)
        . pad(money($e->getSalary()), 16)
        . pad(money($e->getNetSalary()), 16)
        . $e->getMaskedPassport() . PHP_EOL;
}

echo PHP_EOL . "=== Премия менеджера после налога ===" . PHP_EOL;
echo $employees[1]->name . ': ' . money($employees[1]->getBonusAfterTax()) . PHP_EOL;

echo PHP_EOL . "=== Повышение оклада и история ===" . PHP_EOL;
$employees[0]->raiseSalary(10);
$employees[0]->raiseSalary(5.5);
echo $employees[0]->name . ', новый оклад: ' . money($employees[0]->getSalary()) . PHP_EOL;
foreach ($employees[0]->getSalaryHistory() as $line) {
    echo '  ' . $line . PHP_EOL;
}
foreach ([0, 51] as $bad) {
    try {
        $employees[0]->raiseSalary($bad);
    } catch (InvalidArgumentException $ex) {
        echo "raiseSalary($bad): " . $ex->getMessage() . PHP_EOL;
    }
}
