<?php
declare(strict_types=1);
require dirname(__DIR__) . '/app/bootstrap.php';
require dirname(__DIR__) . '/app/i18n.php';
if (empty($_SESSION['member_id'])) redirect('/login.php');
$lang = current_language();
?><!doctype html><html lang="<?=e($lang)?>"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>My account · HAPPY HOME CARE</title><link rel="stylesheet" href="/assets/styles.css"><link rel="stylesheet" href="/assets/admin.css"></head><body class="admin-login"><main class="login-card"><a href="/" aria-label="HAPPY HOME CARE home"><span class="brand-logo-window login-logo-window"><img class="brand-logo" src="/images/hhc-approved-logo.svg" alt="HAPPY HOME CARE — Elevated Care. Right at Home."></span></a><h1>Welcome, <?=e($_SESSION['member_name']??'')?></h1><p>Signed in as <?=e($_SESSION['member_email']??'')?></p><a class="button account-contact" href="/#contact">Contact our care team <span>→</span></a><form method="post" action="/logout.php"><?=csrf_field()?><button class="button button-outline" type="submit"><?=e(tr('logout'))?></button></form><a class="back-home" href="/">← Back to website</a></main></body></html>
