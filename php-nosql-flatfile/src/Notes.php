<?php
declare(strict_types=1);
namespace App;

/** Stores notes in data/notes.json (outside public/, so not web-accessible). */
final class Notes
{
    private static function path(): string
    {
        $dir = dirname(__DIR__) . '/data';
        if (!is_dir($dir)) { mkdir($dir, 0775, true); }
        return $dir . '/notes.json';
    }

    private static function read(): array
    {
        $f = self::path();
        return is_file($f) ? (json_decode((string) file_get_contents($f), true) ?: []) : [];
    }

    private static function write(array $rows): void
    {
        file_put_contents(self::path(), json_encode(array_values($rows), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
    }

    public static function all(): array { return array_reverse(self::read()); }

    public static function add(string $text): void
    {
        $rows = self::read();
        $rows[] = ['id' => bin2hex(random_bytes(6)), 'text' => $text, 'created' => date('Y-m-d H:i')];
        self::write($rows);
    }

    public static function delete(string $id): void
    {
        self::write(array_filter(self::read(), fn($r) => $r['id'] !== $id));
    }
}
