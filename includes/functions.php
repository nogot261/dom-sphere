<?php
declare(strict_types=1);


function u_lower(string $value): string {
    return function_exists('mb_strtolower') ? mb_strtolower($value, 'UTF-8') : strtolower($value);
}

function u_len(string $value): int {
    return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
}

function u_ipos(string $haystack, string $needle): int|false {
    return function_exists('mb_stripos') ? mb_stripos($haystack, $needle, 0, 'UTF-8') : stripos($haystack, $needle);
}

function e(mixed $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function app_base(): string {
    static $base = null;
    if ($base !== null) return $base;
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/');
    $dir = rtrim(dirname($script), '/.');
    $base = ($dir === '/' || $dir === '\\') ? '' : $dir;
    return $base;
}

function url(string $path = ''): string {
    return app_base() . '/' . ltrim($path, '/');
}

function redirect(string $path): never {
    header('Location: ' . url($path));
    exit;
}

function storage_path(string $file): string {
    return APP_ROOT . '/storage/' . $file;
}

function ensure_storage(): void {
    if (!is_dir(APP_ROOT . '/storage')) mkdir(APP_ROOT . '/storage', 0775, true);
    if (!file_exists(storage_path('users.json'))) file_put_contents(storage_path('users.json'), "[]\n");
    if (!file_exists(storage_path('messages.json'))) file_put_contents(storage_path('messages.json'), "[]\n");
}

function read_json(string $file): array {
    $path = storage_path($file);
    $handle = fopen($path, 'c+');
    if (!$handle) return [];
    flock($handle, LOCK_SH);
    rewind($handle);
    $raw = stream_get_contents($handle) ?: '[]';
    flock($handle, LOCK_UN);
    fclose($handle);
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function write_json(string $file, array $data): bool {
    $path = storage_path($file);
    $handle = fopen($path, 'c+');
    if (!$handle) return false;
    flock($handle, LOCK_EX);
    ftruncate($handle, 0);
    rewind($handle);
    $ok = fwrite($handle, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . PHP_EOL) !== false;
    fflush($handle);
    flock($handle, LOCK_UN);
    fclose($handle);
    return $ok;
}

function users(): array { return read_json('users.json'); }
function messages(): array { return read_json('messages.json'); }

function find_user(string $username): ?array {
    foreach (users() as $user) {
        if (u_lower($user['username']) === u_lower($username)) return $user;
    }
    return null;
}

function current_user(): ?array {
    $username = $_SESSION['username'] ?? null;
    return $username ? find_user($username) : null;
}

function is_logged_in(): bool { return current_user() !== null; }
function is_admin(): bool { return (current_user()['role'] ?? '') === 'administrator'; }

function require_login(): void {
    if (!is_logged_in()) {
        flash('warning', 'Для продолжения войдите в учетную запись.');
        redirect('login.php');
    }
}

function require_admin(): void {
    if (!is_admin()) {
        http_response_code(403);
        $page_title = 'Доступ запрещен';
        require APP_ROOT . '/includes/header.php';
        echo '<main class="container page"><div class="notice error"><h1>Доступ запрещен</h1><p>Раздел доступен только администратору.</p></div></main>';
        require APP_ROOT . '/includes/footer.php';
        exit;
    }
}

function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(24));
    return $_SESSION['csrf_token'];
}

function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function check_csrf(): bool {
    $sent = $_POST['csrf_token'] ?? '';
    return is_string($sent) && hash_equals(csrf_token(), $sent);
}

function flash(string $type, string $message): void {
    $_SESSION['flashes'][] = ['type'=>$type,'message'=>$message];
}

function consume_flashes(): array {
    $items = $_SESSION['flashes'] ?? [];
    unset($_SESSION['flashes']);
    return $items;
}

function role_name(string $role): string {
    return $role === 'administrator' ? 'Администратор' : 'Покупатель';
}

function format_price(int|float $price): string {
    return number_format((float)$price, 0, ',', ' ') . ' ₽';
}

function format_date(string $date): string {
    $ts = strtotime($date);
    return $ts ? date('d.m.Y', $ts) : $date;
}

function product_by_id(int $id): ?array {
    global $content;
    foreach ($content['products'] as $item) if ((int)$item['id'] === $id) return $item;
    return null;
}

function article_by_id(int $id): ?array {
    global $content;
    foreach ($content['articles'] as $item) if ((int)$item['id'] === $id) return $item;
    return null;
}

function text_contains(string $haystack, string $needle): bool {
    return $needle === '' || u_ipos($haystack, $needle) !== false;
}
