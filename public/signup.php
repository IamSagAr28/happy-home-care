<?php
declare(strict_types=1);
require dirname(__DIR__) . '/app/bootstrap.php';
require dirname(__DIR__) . '/app/member_auth.php';
if (!empty($_SESSION['member_id'])) redirect('/account.php');
$error = '';
$notice = get_flash();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim((string)($_POST['name'] ?? '')); $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $password = (string)($_POST['password'] ?? ''); $confirm = (string)($_POST['confirm_password'] ?? '');
    if ($name === '' || strlen($name) > 120 || !filter_var($email,FILTER_VALIDATE_EMAIL)) $error = 'Enter your name and a valid email address.';
    elseif (strlen($password) < 12) $error = 'Use a password with at least 12 characters.';
    elseif (!hash_equals($password,$confirm)) $error = 'The passwords do not match.';
    else {
        try { $stmt=db()->prepare('INSERT INTO members (name,email,password_hash) VALUES (?,?,?)'); $stmt->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT)]); member_login(['id'=>(int)db()->lastInsertId(),'name'=>$name,'email'=>$email]); }
        catch (PDOException $ex) { $error = (string)($ex->errorInfo[1]??0) === '1062' ? 'An account with this email already exists. Sign in instead.' : 'We could not create your account right now.'; }
    }
}
$lang = current_language();
?><!doctype html><html lang="<?=e($lang)?>"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=e(tr('signup'))?> · HAPPY HOME CARE</title><link rel="stylesheet" href="/assets/styles.css"><link rel="stylesheet" href="/assets/admin.css"></head><body class="admin-login"><main class="login-card"><a href="/" aria-label="HAPPY HOME CARE home"><span class="brand-logo-window login-logo-window"><img class="brand-logo" src="/images/hhc-approved-logo.svg" alt="HAPPY HOME CARE — Elevated Care. Right at Home."></span></a><h1><?=e(tr('create_account'))?></h1><p>Create an account to stay connected with your care team.</p><?php if($notice): ?><div class="admin-alert <?=e($notice['type']==='error'?'error':'')?>" role="status"><?=e($notice['message'])?></div><?php endif; ?><?php if($error): ?><div class="admin-alert error" role="alert"><?=e($error)?></div><?php endif; ?><div class="social-buttons"><a class="social-button" href="/auth/social.php?provider=google"><?=e(tr('google_signin'))?></a><a class="social-button" href="/auth/social.php?provider=facebook"><?=e(tr('facebook_signin'))?></a></div><p class="social-note">Instagram is a social profile channel, not a general customer sign-in provider.</p><div class="auth-divider"><span><?=e(tr('or_email'))?></span></div><form method="post"><?=csrf_field()?><label><?=e(tr('first_name'))?><input name="name" required maxlength="120" autocomplete="name"></label><label><?=e(tr('email'))?><input type="email" name="email" required maxlength="190" autocomplete="email"></label><label><?=e(tr('password'))?><input type="password" name="password" required minlength="12" autocomplete="new-password"></label><label><?=e(tr('confirm_password'))?><input type="password" name="confirm_password" required minlength="12" autocomplete="new-password"></label><button class="button" type="submit"><?=e(tr('create_account'))?> <span>→</span></button></form><p class="auth-switch">Already have an account? <a href="/login.php"><?=e(tr('login'))?></a></p><a class="admin-login-link" href="/admin/login.php"><?=e(tr('admin_login'))?></a><a class="back-home" href="/">← Back to website</a><label class="auth-language"><?=e(tr('language'))?><select data-language-select><?php foreach(['en'=>'English','pa'=>'ਪੰਜਾਬੀ','hi'=>'हिन्दी','es'=>'Español'] as $code=>$label): ?><option value="<?=$code?>" <?=$lang===$code?'selected':''?>><?=e($label)?></option><?php endforeach; ?></select></label></main><script src="/assets/script.js" defer></script></body></html>
