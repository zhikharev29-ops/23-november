<?php
declare(strict_types=1);

class Employee
{
    public string $name;
    protected float $baseSalary;
    private string $passport;
    private array $salaryHistory = [];

    public function __construct(string $name, float $baseSalary, string $passport)
    {
        $this->name = $name;
        $this->baseSalary = $baseSalary;
        $this->passport = $passport;
    }

    public function getSalary(): float
    {
        return $this->baseSalary;
    }

    // Повышение оклада от 1 до 50 %, каждое изменение пишется в историю
    public function raiseSalary(float $percent): void
    {
        $this->validatePercent($percent);
        $old = $this->baseSalary;
        $this->baseSalary += $this->baseSalary * $percent / 100;
        $this->salaryHistory[] = sprintf(
            '%s: %s -> %s (+%s%%)',
            date('d.m.Y'),
            number_format($old, 2, ',', ' '),
            number_format($this->baseSalary, 2, ',', ' '),
            $percent
        );
    }

    // final: переопределить в наследнике нельзя
    final public function getMaskedPassport(): string
    {
        $digits = preg_replace('/\D/', '', $this->passport);
        return '**** **' . substr($digits, -4);
    }

    public function getSalaryHistory(): array
    {
        return $this->salaryHistory;
    }

    // Зарплата после вычета налога
    public function getNetSalary(): float
    {
        $salary = $this->getSalary();
        return $salary - $this->calculateTax($salary);
    }

    // Налог 13 %: нужен наследникам, снаружи недоступен
    protected function calculateTax(float $amount): float
    {
        return $amount * 0.13;
    }

    private function validatePercent(float $p): void
    {
        if ($p < 1 || $p > 50) {
            throw new InvalidArgumentException("Процент повышения должен быть от 1 до 50, получено: {$p}");
        }
    }
}
