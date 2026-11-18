<?php
declare(strict_types=1);
require_once dirname(__DIR__,2) . '/app/bootstrap.php';
require_once dirname(__DIR__,2) . '/app/i18n.php';
if (is_admin()) redirect('/admin/');
$lang = current_language();
$error = '';
$logo = brand_logo_html($lang);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $admin = db()->prepare('SELECT id,name,email,password_hash FROM admins WHERE email=?'); $admin->execute([$email]); $user = $admin->fetch();
    if ($user && password_verify((string)($_POST['password'] ?? ''), $user['password_hash'])) {
        session_regenerate_id(true); $_SESSION['admin_id'] = $user['id']; $_SESSION['admin_name'] = $user['name']; $_SESSION['admin_email'] = $user['email']; redirect('/admin/');
    }
    $error = 'Email or password was not recognized.';
}
?><!doctype html><html lang="<?=e($lang)?>"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin sign in · HAPPY HOME CARE</title><link rel="stylesheet" href="/assets/styles.css"><link rel="stylesheet" href="/assets/admin.css"></head><body class="admin-login"><main class="login-card"><a class="brand" href="/"><?=$logo?></a><h1>Welcome back</h1><p>Sign in to manage your website.</p><?php if($error): ?><div class="admin-alert error"><?=e($error)?></div><?php endif; ?><form method="post"><?=csrf_field()?><label>Admin username (email)<input type="email" name="email" autocomplete="username" required></label><label>Password<input type="password" name="password" autocomplete="current-password" required></label><button class="button" type="submit">Sign in <span>→</span></button></form><a class="admin-login-link" href="/login.php">Customer sign in / sign up</a><a class="back-home" href="/">← Back to website</a><label class="auth-language">Choose language<select data-language-select aria-label="Choose language"><?php foreach(['en'=>'English','pa'=>'ਪੰਜਾਬੀ','hi'=>'हिन्दी','es'=>'Español'] as $code=>$label): ?><option value="<?=$code?>" <?=$code===$lang?'selected':''?>><?=e($label)?></option><?php endforeach; ?></select></label></main><script src="/assets/google-translate.js" defer></script></body></html>
