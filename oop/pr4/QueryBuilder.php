<?php
declare(strict_types=1);

class QueryBuilder
{
    private const OPERATORS = ['=', '!=', '>', '<', '>=', '<=', 'LIKE'];

    private string $table;
    private array $columns = ['*'];
    private array $wheres = [];
    private ?string $order = null;
    private ?int $limit = null;

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    // Статическая фабрика: QueryBuilder::table('users')
    public static function table(string $name): static
    {
        return new static($name);
    }

    public function select(string ...$columns): static
    {
        $this->columns = $columns === [] ? ['*'] : $columns;
        return $this;
    }

    public function where(string $column, string $operator, string|int $value): static
    {
        $operator = strtoupper($operator);
        if (!in_array($operator, self::OPERATORS, true)) {
            throw new InvalidArgumentException(
                "Недопустимый оператор «{$operator}». Разрешены: " . implode(', ', self::OPERATORS)
            );
        }
        $this->wheres[] = "{$column} {$operator} " . $this->quote($value);
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): static
    {
        $direction = strtoupper($direction);
        if ($direction !== 'ASC' && $direction !== 'DESC') {
            throw new InvalidArgumentException("Направление сортировки должно быть ASC или DESC, получено: {$direction}");
        }
        $this->order = "{$column} {$direction}";
        return $this;
    }

    public function limit(int $count): static
    {
        if ($count <= 0) {
            throw new InvalidArgumentException("limit должен быть больше 0, получено: {$count}");
        }
        $this->limit = $count;
        return $this;
    }

    public function toSql(): string
    {
        $sql = 'SELECT ' . implode(', ', $this->columns) . ' FROM ' . $this->table;
        if ($this->wheres !== []) {
            $sql .= ' WHERE ' . implode(' AND ', $this->wheres);
        }
        if ($this->order !== null) {
            $sql .= ' ORDER BY ' . $this->order;
        }
        if ($this->limit !== null) {
            $sql .= ' LIMIT ' . $this->limit;
        }
        return $sql;
    }

    public function __toString(): string
    {
        return $this->toSql();
    }

    // Строки — в одинарных кавычках, числа — как есть
    private function quote(string|int $value): string
    {
        if (is_int($value)) {
            return (string)$value;
        }
        return "'" . $value . "'";
    }

    // Дополнительно: ->whereCity('Москва') => where('city', '=', 'Москва')
    //                ->whereFirstName('Анна') => where('first_name', '=', 'Анна')
    public function __call(string $name, array $arguments): static
    {
        if (str_starts_with($name, 'where') && strlen($name) > 5) {
            if (count($arguments) !== 1) {
                throw new InvalidArgumentException("Метод {$name}() принимает ровно один аргумент");
            }
            $column = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', substr($name, 5)));
            return $this->where($column, '=', $arguments[0]);
        }
        throw new BadMethodCallException("Метод QueryBuilder::{$name}() не существует");
    }
}
