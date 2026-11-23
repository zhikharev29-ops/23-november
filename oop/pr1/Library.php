<?php
declare(strict_types=1);

class Library
{
    private array $books = [];

    public function addBook(Book $book): void
    {
        $this->books[] = $book;
    }

    public function findByAuthor(string $author): array
    {
        return array_values(array_filter(
            $this->books,
            fn(Book $b) => $b->author === $author
        ));
    }

    public function count(): int
    {
        return count($this->books);
    }

    public function printAll(): void
    {
        foreach ($this->books as $i => $book) {
            echo ($i + 1) . '. ' . $book->getInfo() . PHP_EOL;
        }
    }

    // Дополнительно: самая старая книга или null, если библиотека пуста
    public function getOldest(): ?Book
    {
        $oldest = null;
        foreach ($this->books as $book) {
            if ($oldest === null || $book->year < $oldest->year) {
                $oldest = $book;
            }
        }
        return $oldest;
    }
}
