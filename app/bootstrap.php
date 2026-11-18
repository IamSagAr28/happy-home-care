<?php
declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));
$envFile = ROOT_PATH . '/.env';
if (is_file($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $value = trim(trim($value), "\"'");
        if (!array_key_exists(trim($key), $_ENV)) $_ENV[trim($key)] = $value;
    }
}
function envv(string $key, string $default = ''): string { return (string)($_ENV[$key] ?? $default); }
define('APP_ENV', envv('APP_ENV', 'local'));
define('APP_DEBUG', filter_var(envv('APP_DEBUG', 'false'), FILTER_VALIDATE_BOOLEAN));
define('APP_URL', rtrim(envv('APP_URL', 'http://localhost:8000'), '/'));
error_reporting(E_ALL);
ini_set('display_errors', APP_DEBUG ? '1' : '0');
date_default_timezone_set('America/Chicago');
ini_set('session.use_strict_mode', '1');
session_set_cookie_params(['httponly'=>true, 'samesite'=>'Lax', 'secure'=>!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off']);
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/i18n.php';

function db(): PDO {
    static $pdo;
    if ($pdo instanceof PDO) return $pdo;
    
    // SQLite option / fallback for cloud deployment (e.g. Render)
    $connection = envv('DB_CONNECTION', '');
    $sqlitePath = ROOT_PATH . '/database/database.sqlite';
    if ($connection === 'sqlite' || ($connection === '' && !envv('DB_HOST') && is_file($sqlitePath))) {
        $pdo = new PDO('sqlite:' . $sqlitePath, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
        return $pdo;
    }

    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', envv('DB_HOST','127.0.0.1'), envv('DB_PORT','3306'), envv('DB_NAME','happy_home_care'));
    try {
        $pdo = new PDO($dsn, envv('DB_USER','root'), envv('DB_PASSWORD'), [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES=>false]);
    } catch (PDOException $ex) {
        error_log('Database connection failed: ' . $ex->getMessage());
        if (is_file($sqlitePath)) {
            // Auto fallback to embedded SQLite if MySQL fails in cloud container
            $pdo = new PDO('sqlite:' . $sqlitePath, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
            return $pdo;
        }
        if ((string)$ex->getCode() === '1045' || (int)($ex->errorInfo[1] ?? 0) === 1045) {
            throw new RuntimeException('MySQL rejected the configured username/password. Check DB_USER and DB_PASSWORD in the project root .env file. Do not leave DB_PASSWORD empty if your MySQL account has a password.');
        }
        if ((string)$ex->getCode() === '1049' || (int)($ex->errorInfo[1] ?? 0) === 1049) {
            throw new RuntimeException('The configured MySQL database does not exist. Import database/schema.sql, then check DB_NAME in the project root .env file.');
        }
        throw new RuntimeException('Could not connect to MySQL. Confirm the MySQL service is running and check DB_HOST, DB_PORT, and DB_NAME in the project root .env file.');
    }
    return $pdo;
}
function e(mixed $value): string { return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function redirect(string $path): never { header('Location: ' . $path, true, 303); exit; }
function csrf_token(): string { return $_SESSION['csrf'] ??= bin2hex(random_bytes(32)); }
function csrf_field(): string { return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">'; }
function verify_csrf(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', (string)($_POST['csrf'] ?? ''))) { http_response_code(419); exit('Your session expired. Go back and try again.'); }
}
function flash(string $message, string $type = 'success'): void { $_SESSION['flash'] = ['message'=>$message, 'type'=>$type]; }
function get_flash(): ?array { $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f; }
function is_admin(): bool { return isset($_SESSION['admin_id']); }
function require_admin(): void { if (!is_admin()) redirect('/admin/login.php'); }
function setting(string $key, string $default = ''): string {
    static $settings;
    if ($settings === null) { try { $settings = db()->query('SELECT setting_key, setting_value FROM settings')->fetchAll(PDO::FETCH_KEY_PAIR); } catch (Throwable) { $settings = []; } }
    return (string)($settings[$key] ?? $default);
}
function slugify(string $text): string { $s = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $text) ?? '', '-')); return $s ?: 'item-' . bin2hex(random_bytes(3)); }
function brand_logo_html(?string $lang = null, string $extraClass = ''): string {
    $alt = 'HAPPY HOME CARE — Elevated Care. Right at Home.';
    $cls = 'brand-logo-window' . ($extraClass ? ' ' . e($extraClass) : '');
    return '<span class="' . $cls . ' notranslate" translate="no"><img class="brand-logo notranslate" translate="no" src="/images/hhc-approved-logo.svg" alt="' . $alt . '"></span>';
}
