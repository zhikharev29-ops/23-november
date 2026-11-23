<?php
declare(strict_types=1);

class Book
{
    public string $title;
    public string $author;
    public int $year;
    public int $pages;

    public function __construct(string $title, string $author, int $year, int $pages)
    {
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
        $this->pages = $pages;
    }

    public function getInfo(): string
    {
        return "{$this->title} — {$this->author}, {$this->year}, {$this->pages} стр.";
    }

    public function getAge(): int
    {
        return (int)date('Y') - $this->year;
    }
}
