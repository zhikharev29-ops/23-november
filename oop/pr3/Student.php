<?php
declare(strict_types=1);

class Student
{
    public const MIN_COURSE = 1;
    public const MAX_COURSE = 4;

    public static int $totalStudents = 0;
    public static string $university = 'МГТУ им. Н. Э. Баумана';

    public ?string $email = null;
    public array $grades = [];
    public bool $isActive = true;

    // Дополнительно: журнал попыток записать несуществующее свойство
    private array $history = [];

    public function __construct(
        public readonly int $id,
        public string $lastName,
        public string $firstName,
        public int $course,
    ) {
        if ($course < self::MIN_COURSE || $course > self::MAX_COURSE) {
            throw new InvalidArgumentException(
                'Курс должен быть от ' . self::MIN_COURSE . ' до ' . self::MAX_COURSE . ", получено: $course"
            );
        }
        self::$totalStudents++;
    }

    public function getAverage(): float
    {
        return $this->grades === [] ? 0.0 : array_sum($this->grades) / count($this->grades);
    }

    // Дополнительно: вместо создания динамического свойства сохраняем имя в $history
    public function __set(string $name, mixed $value): void
    {
        $this->history[] = $name;
        echo "Предупреждение: свойство «{$name}» не существует, динамическое свойство не создано" . PHP_EOL;
    }

    // Нужен для эксперимента 5: get_object_vars() внутри класса видит и private
    public function getAllVars(): array
    {
        return get_object_vars($this);
    }
}
