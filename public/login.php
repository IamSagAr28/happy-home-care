<?php
declare(strict_types=1);
require dirname(__DIR__) . '/app/bootstrap.php';
require dirname(__DIR__) . '/app/member_auth.php';
if (!empty($_SESSION['member_id'])) redirect('/account.php');
$error = '';
$notice = get_flash();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $stmt = db()->prepare('SELECT * FROM members WHERE email=?'); $stmt->execute([$email]); $member = $stmt->fetch();
    if ($member && $member['password_hash'] && password_verify((string)($_POST['password'] ?? ''), $member['password_hash'])) member_login($member);
    $error = 'Email or password was not recognized. If you registered with Google or Facebook, use that option.';
}
$lang = current_language();
?><!doctype html><html lang="<?=e($lang)?>"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=e(tr('login'))?> · HAPPY HOME CARE</title><link rel="stylesheet" href="/assets/styles.css"><link rel="stylesheet" href="/assets/admin.css"></head><body class="admin-login"><main class="login-card"><a href="/" aria-label="HAPPY HOME CARE home"><span class="brand-logo-window login-logo-window"><img class="brand-logo" src="/images/hhc-approved-logo.svg" alt="HAPPY HOME CARE — Elevated Care. Right at Home."></span></a><h1><?=e(tr('sign_in'))?></h1><p>Welcome back. Sign in to your care account.</p><?php if($notice): ?><div class="admin-alert <?=e($notice['type']==='error'?'error':'')?>" role="status"><?=e($notice['message'])?></div><?php endif; ?><?php if($error): ?><div class="admin-alert error" role="alert"><?=e($error)?></div><?php endif; ?>
<div class="social-buttons"><a class="social-button" href="/auth/social.php?provider=google"><?=e(tr('google_signin'))?></a><a class="social-button" href="/auth/social.php?provider=facebook"><?=e(tr('facebook_signin'))?></a></div><p class="social-note">Instagram is a social profile channel, not a general customer sign-in provider.</p><div class="auth-divider"><span><?=e(tr('or_email'))?></span></div>
<form method="post"><?=csrf_field()?><label><?=e(tr('email'))?><input type="email" name="email" autocomplete="username" required maxlength="190"></label><label><?=e(tr('password'))?><input type="password" name="password" autocomplete="current-password" required></label><button class="button" type="submit"><?=e(tr('sign_in'))?> <span>→</span></button></form><p class="auth-switch">New here? <a href="/signup.php"><?=e(tr('signup'))?></a></p><a class="admin-login-link" href="/admin/login.php"><?=e(tr('admin_login'))?> · Username (email) and password</a><a class="back-home" href="/">← Back to website</a><label class="auth-language"><?=e(tr('language'))?><select data-language-select><?php foreach(['en'=>'English','pa'=>'ਪੰਜਾਬੀ','hi'=>'हिन्दी','es'=>'Español'] as $code=>$label): ?><option value="<?=$code?>" <?=$lang===$code?'selected':''?>><?=e($label)?></option><?php endforeach; ?></select></label></main><script src="/assets/script.js" defer></script></body></html>
