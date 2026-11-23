<?php
declare(strict_types=1);

require_once __DIR__ . '/Employee.php';

class Manager extends Employee
{
    private const TEAM_BONUS = 5000.0;

    private int $teamSize;

    public function __construct(string $name, float $baseSalary, string $passport, int $teamSize)
    {
        parent::__construct($name, $baseSalary, $passport);
        $this->teamSize = $teamSize;
    }

    // Оклад + 5 000 ₽ за каждого подчинённого
    public function getSalary(): float
    {
        return $this->baseSalary + self::TEAM_BONUS * $this->teamSize;
    }

    // Налог только с премии за команду (использует protected calculateTax)
    public function getBonusAfterTax(): float
    {
        $bonus = self::TEAM_BONUS * $this->teamSize;
        return $bonus - $this->calculateTax($bonus);
    }

    // --- Методы-пробы для таблицы экспериментов ---
    public function probeBaseSalary(): float
    {
        return $this->baseSalary;        // protected: из наследника можно
    }

    public function probePassport(): mixed
    {
        return $this->passport;          // private родителя: недоступно
    }
}
