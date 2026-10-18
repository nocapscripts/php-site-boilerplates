<?php
declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';
require $root . '/src/App.php';
require $root . '/src/Notes.php';

use App\App;
use App\Notes;

App::boot();

$path   = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET' && $path === '/') {
        App::view('notes', ['notes' => Notes::all()]);
    } elseif ($method === 'POST' && $path === '/add') {
        App::checkCsrf();
        $text = trim((string) ($_POST['text'] ?? ''));
        if ($text !== '') { Notes::add(mb_substr($text, 0, 255)); App::flash('Note added'); }
        App::redirect('/');
    } elseif ($method === 'POST' && $path === '/delete') {
        App::checkCsrf();
        Notes::delete((string) ($_POST['id'] ?? ''));
        App::flash('Note deleted');
        App::redirect('/');
    } else {
        http_response_code(404);
        echo 'Not found';
    }
} catch (Throwable $e) {
    error_log((string) $e);
    http_response_code(500);
    echo 'Server error';
}
