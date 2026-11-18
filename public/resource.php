<?php
declare(strict_types=1);
require dirname(__DIR__) . '/app/bootstrap.php';
require dirname(__DIR__) . '/app/i18n.php';
require dirname(__DIR__) . '/app/resource_content.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0;
$stmt = db()->prepare('SELECT * FROM resources WHERE id = ? AND published = 1 LIMIT 1');
$stmt->execute([$id]);
$article = $stmt->fetch();
if (!$article) {
    http_response_code(404);
    $article = null;
}
$brand = setting('site_name', 'HAPPY HOME CARE');
$phone = setting('phone', '+91 81440 01842');
$phoneLink = setting('phone_link', '918144001842');
$email = setting('email', 'mail2rakeshpandit@gmail.com');
$whatsappLink = 'https://wa.me/' . preg_replace('/\D/', '', $phoneLink) . '?text=' . rawurlencode('Hello, I would like to know more about home care.');
$lang = current_language();
$logo = brand_logo_html($lang);
?>
<!doctype html>
<html lang="<?=e($lang)?>">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#00466e">
  <title><?= $article ? e($article['title']) . ' · ' . e($brand) : 'Article not found · ' . e($brand) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/styles.css"><script src="/assets/script.js" defer></script><script src="/assets/google-translate.js" defer></script>
</head>
<body>
<div class="utility-bar"><div class="container utility-inner"><span><?=e(tr('elevated_care'))?></span><div><a href="mailto:<?=e($email)?>"><?=e($email)?></a><a href="tel:<?=e($phoneLink)?>">☎ &nbsp; <?=e($phone)?></a><label class="language-switch"><span class="sr-only"><?=e(tr('language'))?></span><select data-language-select aria-label="<?=e(tr('language'))?>"><?php foreach(['en'=>'English','pa'=>'ਪੰਜਾਬੀ','hi'=>'हिन्दी','es'=>'Español'] as $code=>$label): ?><option value="<?=$code?>" <?=$lang===$code?'selected':''?>><?=e($label)?></option><?php endforeach; ?></select></label></div></div></div>
<header class="site-header"><div class="container nav-wrap"><a class="brand" href="/" aria-label="<?=e($brand)?> home"><?=$logo?></a><button class="menu-toggle" aria-expanded="false" aria-controls="primary-nav" aria-label="Open menu"><span></span><span></span></button><nav id="primary-nav" class="primary-nav" aria-label="Main navigation"><a href="/#about"><?=e(tr('about'))?></a><a href="/#resources"><?=e(tr('resources'))?></a><a href="/#services"><?=e(tr('services'))?></a><a href="/#locations"><?=e(tr('locations'))?></a></nav><div class="nav-actions"><a class="phone-link" href="/login.php"><?=e(tr('login'))?></a><a class="button button-small" href="/signup.php"><?=e(tr('signup'))?></a><a class="button button-small nav-request" href="/#contact"><?=e(tr('request_care'))?> <span>↗</span></a></div></div></header>
<main class="resource-page">
<?php if ($article): ?>
  <article class="container resource-detail resource-tone-<?=e(match((int)$article['id']) {1=>1,2=>2,3=>3,default=>1})?>">
    <a class="resource-back" href="/#resources">← <?=e(tr('resources'))?></a>
    <header class="resource-detail-head"><div class="resource-meta"><span><?=e(tr_resource_category($article['category']))?></span><?php if (trim((string)($article['read_time']??''))!==''): ?><span><?=e(tr_resource_read_time($article['read_time']))?></span><?php endif; ?></div><h1><?=e(tr_resource_title($article['title']))?></h1><p><?=e(tr_resource_summary($article['title'], $article['summary']))?></p></header>
    <div class="resource-detail-content"><?=resource_body_html((string)tr_resource_body((int)$article['id'], $article['body']))?></div>
    <?php if (trim((string)($article['button_label']??''))!==''): ?><a class="button resource-detail-cta" href="/#contact"><?=e(tr_resource_btn($article['button_label']))?> <span>→</span></a><?php endif; ?>
    <a class="resource-back resource-back-bottom" href="/#resources">← <?=e(tr('resources'))?></a>
  </article>
<?php else: ?>
  <section class="container resource-not-found"><span class="eyebrow"><?=e(tr('resources'))?></span><h1>Article not found</h1><p>This article may have been unpublished. Browse the other helpful reads or contact our team.</p><a class="button" href="/#resources"><?=e(tr('resources'))?> <span>→</span></a></section>
<?php endif; ?>
</main>
<footer class="footer"><div class="container footer-main"><div class="footer-about"><a class="brand" href="/"><?=$logo?></a><p><?=e(tr('elevated_care'))?></p></div><div><h4><?=e(tr('brand_name'))?></h4><a href="/#about"><?=e(tr('about'))?></a><a href="/#services"><?=e(tr('services'))?></a><a href="/#locations"><?=e(tr('locations'))?></a></div><div><h4><?=e(tr('here_to_help'))?></h4><a href="/#resources"><?=e(tr('resources'))?></a><a href="/#contact"><?=e(tr('contact'))?></a><a href="mailto:<?=e($email)?>"><?=e($email)?></a><a href="tel:<?=e($phoneLink)?>"><?=e(tr('call'))?></a><a href="<?=e($whatsappLink)?>" target="_blank" rel="noopener">WhatsApp</a></div></div><div class="container footer-bottom"><span>© <?=date('Y')?> <?=e(tr('brand_name'))?>. <?=e(tr('all_rights'))?></span><div><a href="/#contact"><?=e(tr('contact'))?></a><a href="#top"><?=e(tr('back_to_top'))?></a></div></div></footer>
<div class="floating-contact" aria-label="Quick contact"><a class="quick-contact quick-request" href="/#contact" aria-label="<?=e(tr('request_care'))?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg><span><?=e(tr('request_care'))?></span></a><a class="quick-contact quick-whatsapp" href="<?=e($whatsappLink)?>" target="_blank" rel="noopener" aria-label="WhatsApp"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 11.7a8.4 8.4 0 0 1-12.4 7.4L3 20l.9-4.9a8.4 8.4 0 1 1 16.6-3.4Z"/><path d="M8.4 8.2c.3-.7.6-.7.9-.7h.5c.2 0 .4.1.5.4l.7 1.7c.1.2 0 .4-.1.6l-.5.6c-.2.2-.2.4 0 .6.5.8 1.1 1.4 1.9 1.8.2.1.4.1.6-.1l.7-.8c.2-.2.4-.2.6-.1l1.6.8c.2.1.3.3.3.5 0 .4-.2 1.1-.6 1.4-.4.4-1 .6-1.7.5-1.1-.2-2.4-.8-3.7-2-1.1-1-2-2.3-2.2-3.4-.2-.8.1-1.4.5-1.8Z"/></svg><span>WhatsApp</span></a><a class="quick-contact quick-call" href="tel:<?=e($phoneLink)?>" aria-label="<?=e(tr('call'))?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3h3l1.5 4.2-2 1.7a15 15 0 0 0 5.6 5.6l1.7-2L21 14v3c0 1.1-.9 2-2 2C10.2 19 5 13.8 5 5c0-1.1.9-2 2-2Z"/></svg><span><?=e(tr('call'))?> <?=e($phone)?></span></a></div>
</body></html>
