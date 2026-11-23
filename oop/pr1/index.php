<?php
declare(strict_types=1);

require __DIR__ . '/Book.php';
require __DIR__ . '/Library.php';

$library = new Library();
$library->addBook(new Book('Мастер и Маргарита', 'М. Булгаков', 1967, 480));
$library->addBook(new Book('Собачье сердце', 'М. Булгаков', 1925, 160));
$library->addBook(new Book('Война и мир', 'Л. Толстой', 1869, 1225));
$library->addBook(new Book('Преступление и наказание', 'Ф. Достоевский', 1866, 672));
$library->addBook(new Book('Анна Каренина', 'Л. Толстой', 1877, 864));

echo "=== Все книги ===" . PHP_EOL;
$library->printAll();

echo PHP_EOL . "=== Книги автора М. Булгаков ===" . PHP_EOL;
foreach ($library->findByAuthor('М. Булгаков') as $book) {
    echo $book->getInfo() . PHP_EOL;
}

echo PHP_EOL . "Всего книг: " . $library->count() . PHP_EOL;

echo PHP_EOL . "=== Возраст книги ===" . PHP_EOL;
$first = $library->findByAuthor('Л. Толстой')[0];
echo "«{$first->title}» издана {$first->getAge()} лет назад" . PHP_EOL;

echo PHP_EOL . "=== Самая старая книга ===" . PHP_EOL;
echo $library->getOldest()?->getInfo() . PHP_EOL;
echo "Пустая библиотека: ";
var_dump((new Library())->getOldest()); // NULL

// Пункт 7: присваивание и клонирование
echo PHP_EOL . "=== Присваивание и клонирование ===" . PHP_EOL;
$b1 = new Book('Идиот', 'Ф. Достоевский', 1869, 640);
$b2 = $b1;        // вторая ссылка на ТОТ ЖЕ объект
$b3 = clone $b1;  // независимая копия

$b1->title = 'Игрок';

echo '$b1: ' . $b1->getInfo() . PHP_EOL;
echo '$b2: ' . $b2->getInfo() . "  (изменился вместе с \$b1)" . PHP_EOL;
echo '$b3: ' . $b3->getInfo() . "  (не изменился)" . PHP_EOL;
var_dump($b1 === $b2, $b1 === $b3);
