<?php
declare(strict_types=1);
namespace App;

final class Notes
{
    private static ?\PDO $pdo = null;

    private static function db(): \PDO
    {
        return self::$pdo ??= new \PDO(
            sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
                App::env('DB_HOST', '127.0.0.1'), (int) App::env('DB_PORT', '3306'), App::env('DB_NAME')),
            App::env('DB_USER'),
            App::env('DB_PASS'),
            [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES   => false,
                \PDO::ATTR_TIMEOUT            => 5,
            ]
        );
    }

    public static function all(): array
    {
        return array_map(
            fn($r) => ['id' => $r['id'], 'text' => $r['text'], 'created' => $r['created_at']],
            self::db()->query('SELECT id, text, created_at FROM notes ORDER BY id DESC LIMIT 100')->fetchAll()
        );
    }

    public static function add(string $text): void
    {
        self::db()->prepare('INSERT INTO notes (text) VALUES (?)')->execute([$text]);
    }

    public static function delete(string $id): void
    {
        self::db()->prepare('DELETE FROM notes WHERE id = ?')->execute([(int) $id]);
    }
}
