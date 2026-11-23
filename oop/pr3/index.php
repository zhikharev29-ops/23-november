<?php
declare(strict_types=1);

require __DIR__ . '/Student.php';

// Дополняет строку пробелами до ширины (str_pad не умеет считать кириллицу)
function pad(string $s, int $width): string
{
    $len = preg_match_all('/./us', $s);
    return $s . str_repeat(' ', max(0, $width - $len));
}

// Пункт 5: 4 студента
$students = [];

$s1 = new Student(1001, 'Иванов', 'Пётр', 2);
$s1->email = 'ivanov@example.com';
$s1->grades = [5, 4, 5, 5];

$s2 = new Student(1002, 'Петрова', 'Анна', 1);
$s2->email = 'petrova@example.com';
$s2->grades = [4, 4, 3, 5];

$s3 = new Student(1003, 'Сидоров', 'Олег', 3);
$s3->grades = [3, 4, 4];            // почту не указываем (null)

$s4 = new Student(1004, 'Кузнецова', 'Мария', 4);
$s4->email = 'kuznetsova@example.com';
$s4->grades = [5, 5, 5, 4, 5];

$students = [$s1, $s2, $s3, $s4];

// Пункт 6: таблица
echo "Вуз: " . Student::$university . PHP_EOL;
echo pad('Билет', 8) . pad('ФИО', 20) . pad('Курс', 6) . pad('Почта', 26) . 'Средний балл' . PHP_EOL;
echo str_repeat('-', 70) . PHP_EOL;
foreach ($students as $s) {
    echo pad((string)$s->id, 8)
        . pad($s->lastName . ' ' . $s->firstName, 20)
        . pad((string)$s->course, 6)
        . pad($s->email ?? 'не указана', 26)
        . number_format($s->getAverage(), 2) . PHP_EOL;
}
echo str_repeat('-', 70) . PHP_EOL;
echo 'Всего студентов (static): ' . Student::$totalStudents . PHP_EOL;

// Пункт 7: эксперименты
echo PHP_EOL . "=== Эксперимент 1: изменение readonly \$id ===" . PHP_EOL;
try {
    $s1->id = 5;
} catch (Error $e) {
    echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== Эксперимент 2: строка в \$course при strict_types=1 ===" . PHP_EOL;
try {
    $s1->course = 'второй';
} catch (TypeError $e) {
    echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== Эксперимент 3: курс 7 ===" . PHP_EOL;
try {
    new Student(1005, 'Тестов', 'Тест', 7);
} catch (InvalidArgumentException $e) {
    echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
}
echo 'Студентов после неудачной попытки: ' . Student::$totalStudents . PHP_EOL;

echo PHP_EOL . "=== Эксперимент 4: изменение Student::\$university ===" . PHP_EOL;
Student::$university = 'МГУ им. М. В. Ломоносова';
echo 'Student::$university = ' . Student::$university . PHP_EOL;
echo 'Через объект $s1::$university = ' . $s1::$university . PHP_EOL;
echo 'Через объект $s4::$university = ' . $s4::$university . PHP_EOL;

echo PHP_EOL . "=== Эксперимент 5: var_dump() и get_object_vars() ===" . PHP_EOL;
var_dump($s3);
echo 'get_object_vars() снаружи класса:' . PHP_EOL;
print_r(get_object_vars($s3));
echo 'get_object_vars() внутри класса (видны и private):' . PHP_EOL;
print_r($s3->getAllVars());

// Дополнительно: __set()
echo PHP_EOL . "=== Дополнительно: __set() ===" . PHP_EOL;
$s2->phone = '+7 900 000-00-00';
$s2->groupName = 'ИУ5-21';
echo 'Попытки записи несуществующих свойств: ' . implode(', ', $s2->getAllVars()['history']) . PHP_EOL;
var_dump(property_exists($s2, 'phone'));
