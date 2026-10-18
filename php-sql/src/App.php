<?php
declare(strict_types=1);
namespace App;

final class App
{
    private static array $env = [];

    public static function boot(): void
    {
        $f = dirname(__DIR__) . '/.env';
        if (is_file($f)) {
            foreach (file($f, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $l) {
                if ($l[0] !== '#' && str_contains($l, '=')) {
                    [$k, $v] = explode('=', $l, 2);
                    self::$env[trim($k)] = trim($v);
                }
            }
        }
        session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
        session_start();
    }

    public static function env(string $k, string $d = ''): string { return self::$env[$k] ?? $d; }

    public static function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

    public static function csrf(): string { return $_SESSION['csrf'] ??= bin2hex(random_bytes(32)); }

    public static function checkCsrf(): void
    {
        if (!hash_equals($_SESSION['csrf'] ?? '', (string) ($_POST['csrf'] ?? ''))) {
            http_response_code(419);
            exit('Invalid CSRF token');
        }
    }

    public static function flash(?string $msg = null): ?string
    {
        if ($msg !== null) { $_SESSION['flash'] = $msg; return null; }
        $f = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $f;
    }

    public static function redirect(string $to): never { header('Location: ' . $to); exit; }

    public static function view(string $name, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        ob_start();
        require dirname(__DIR__) . "/views/$name.php";
        $content = ob_get_clean();
        require dirname(__DIR__) . '/views/layout.php';
    }
}
