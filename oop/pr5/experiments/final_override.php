<?php
declare(strict_types=1);

require __DIR__ . '/../Employee.php';

// Пункт 6: переопределение final-метода — ошибка на этапе компиляции, поймать через try/catch нельзя
class BadDeveloper extends Employee
{
    public function getMaskedPassport(): string
    {
        return 'hidden';
    }
}
