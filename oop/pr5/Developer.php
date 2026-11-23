<?php
declare(strict_types=1);

require_once __DIR__ . '/Employee.php';

class Developer extends Employee
{
    private const LEVELS = ['junior' => 1.0, 'middle' => 1.5, 'senior' => 2.0];

    private string $level;

    public function __construct(string $name, float $baseSalary, string $passport, string $level)
    {
        if (!isset(self::LEVELS[$level])) {
            throw new InvalidArgumentException('Уровень должен быть junior, middle или senior, получено: ' . $level);
        }
        parent::__construct($name, $baseSalary, $passport);
        $this->level = $level;
    }

    public function getSalary(): float
    {
        return $this->baseSalary * self::LEVELS[$this->level];
    }

    public function getLevel(): string
    {
        return $this->level;
    }

    // --- Метод-проба для таблицы экспериментов ---
    public function probeValidatePercent(): void
    {
        $this->validatePercent(10);      // private родителя: недоступно
    }

    // Попытка переопределить final-метод (пункт 6) закомментирована, чтобы файл работал.
    // Раскомментируйте — PHP остановится с Fatal error (см. experiments/final_override.php):
    // public function getMaskedPassport(): string { return 'hidden'; }
}
