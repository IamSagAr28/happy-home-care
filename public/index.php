<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/app/bootstrap.php';
require_once dirname(__DIR__) . '/app/i18n.php';
$aboutContent = require dirname(__DIR__) . '/app/about_content.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    if (!empty($_POST['website'])) { redirect('/'); } // honeypot
    $action = (string)($_POST['action'] ?? '');
    try {
        if ($action === 'inquiry') {
            $data = [trim((string)($_POST['first_name'] ?? '')), trim((string)($_POST['last_name'] ?? '')), trim((string)($_POST['phone'] ?? '')), trim((string)($_POST['email'] ?? '')), trim((string)($_POST['zip_code'] ?? '')), trim((string)($_POST['care_type'] ?? '')), trim((string)($_POST['details'] ?? ''))];
            if (in_array('', array_slice($data, 0, 6), true) || !filter_var($data[3], FILTER_VALIDATE_EMAIL)) throw new InvalidArgumentException('Please complete all required fields with a valid email address.');
            $stmt = db()->prepare('INSERT INTO inquiries (first_name,last_name,phone,email,zip_code,care_type,details) VALUES (?,?,?,?,?,?,?)'); $stmt->execute($data);
            flash('Thank you. Your care request has been received. Our team will follow up soon.');
        } elseif ($action === 'application') {
            $data = [trim((string)($_POST['first_name'] ?? '')), trim((string)($_POST['last_name'] ?? '')), trim((string)($_POST['email'] ?? '')), trim((string)($_POST['role'] ?? ''))];
            if (in_array('', $data, true) || !filter_var($data[2], FILTER_VALIDATE_EMAIL)) throw new InvalidArgumentException('Please complete all fields with a valid email address.');
            $stmt = db()->prepare('INSERT INTO applications (first_name,last_name,email,role) VALUES (?,?,?,?)'); $stmt->execute($data);
            flash('Thank you for your interest. Your application has been received.');
        }
    } catch (InvalidArgumentException $ex) { flash($ex->getMessage(), 'error'); }
      catch (Throwable $ex) { error_log($ex->getMessage()); flash('We could not save your request right now. Please call us directly.', 'error'); }
    redirect('/#' . ($action === 'application' ? 'careers' : 'contact'));
}

$services = db()->query('SELECT * FROM services WHERE active=1 ORDER BY sort_order,id')->fetchAll();
$resources = db()->query("SELECT * FROM resources WHERE published=1 ORDER BY CASE title WHEN 'What Medicare won’t cover, and what to do about it' THEN 1 WHEN 'Health care decisions' THEN 2 WHEN 'Caring for your parents shouldn’t mean losing yourself' THEN 3 ELSE 10 END, id DESC")->fetchAll();
$faqs = db()->query('SELECT * FROM faqs WHERE active=1 ORDER BY sort_order,id')->fetchAll();
$testimonials = db()->query('SELECT * FROM testimonials WHERE active=1 ORDER BY id LIMIT 3')->fetchAll();
$caregivers = db()->query('SELECT * FROM caregivers WHERE active=1 ORDER BY id LIMIT 3')->fetchAll();
$caregiverFallbacks = ['/images/caregiver1.jpg', '/images/caregiver2.jpg', '/images/caregiver3.jpg'];
$query = trim((string)($_GET['location'] ?? '')); $stateQuery = trim((string)($_GET['state'] ?? ''));
$locationStmt = db()->prepare('SELECT * FROM locations WHERE active=1 AND (? = ? OR city LIKE ? OR state LIKE ? OR zip_code LIKE ?) AND (? = ? OR state = ?) ORDER BY state,city LIMIT 6');
$like = '%' . $query . '%'; $locationStmt->execute([$query,'',$like,$like,$like,$stateQuery,'',$stateQuery]); $locations = $locationStmt->fetchAll();
$notice = get_flash();
$lang = current_language();
$brand = tr('brand_name');
$phone = setting('phone', '+91 81440 01842');
$phoneLink = setting('phone_link', '918144001842');
$email = setting('email','mail2rakeshpandit@gmail.com');
$whatsappLink = 'https://wa.me/' . preg_replace('/\D/', '', $phoneLink) . '?text=' . rawurlencode('Hello, I would like to know more about home care.');
$logo = brand_logo_html($lang);
?>
<!doctype html>
<html lang="<?=e($lang)?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#00466e">
  <meta name="description" content="<?=e(tr('elevated_care'))?> — <?=e($brand)?>">
  <title><?=e($brand)?> — <?=e(tr('elevated_care'))?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&family=Noto+Sans+Devanagari:wght@400;600;700&family=Noto+Sans+Gurmukhi:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/styles.css">
  <script src="/assets/script.js" defer></script>
  <script src="/assets/google-translate.js" defer></script>
</head>
<body>
<div class="utility-bar">
  <div class="container utility-inner">
    <span><?=e(tr('elevated_care'))?></span>
    <div>
      <a href="mailto:<?=e($email)?>"><?=e($email)?></a>
      <a href="tel:<?=e($phoneLink)?>">✳ &nbsp; <?=e($phone)?></a>
      <label class="language-switch">
        <span class="sr-only"><?=e(tr('language'))?></span>
        <select data-language-select aria-label="<?=e(tr('language'))?>">
          <?php foreach(['en'=>'English','pa'=>'ਪੰਜਾਬੀ','hi'=>'हिन्दी','es'=>'Español'] as $code=>$label): ?>
            <option value="<?=$code?>" <?=$lang===$code?'selected':''?>><?=e($label)?></option>
          <?php endforeach; ?>
        </select>
      </label>
    </div>
  </div>
</div>

<header class="site-header">
  <div class="container nav-wrap">
    <a class="brand" href="#top" aria-label="<?=e($brand)?> home"><?=$logo?></a>
    <button class="menu-toggle" aria-expanded="false" aria-controls="primary-nav" aria-label="Open menu"><span></span><span></span></button>
    <nav id="primary-nav" class="primary-nav" aria-label="Main navigation">
      <a href="#about"><?=e(tr('about'))?></a>
      <a href="#resources"><?=e(tr('resources'))?></a>
      <a href="#services"><?=e(tr('services'))?></a>
      <a href="#locations"><?=e(tr('locations'))?></a>
    </nav>
    <div class="nav-actions">
      <a class="header-call" href="tel:<?=e($phoneLink)?>"><span aria-hidden="true">☎</span><span><?=e($phone)?></span></a>
      <?php if (!empty($_SESSION['member_id'])): ?>
        <a class="phone-link" href="/account.php"><?=e($_SESSION['member_name']??tr('login'))?></a>
      <?php else: ?>
        <a class="phone-link" href="/login.php"><?=e(tr('login'))?></a>
        <a class="button button-small" href="/signup.php"><?=e(tr('signup'))?></a>
      <?php endif; ?>
      <a class="button button-small nav-request" href="#contact"><?=e(tr('request_care'))?> <span>↗</span></a>
    </div>
  </div>
</header>

<main id="top">
<?php if ($notice): ?>
  <div class="container"><div class="site-notice <?=e($notice['type'])?>" role="status"><?=e($notice['message'])?></div></div>
<?php endif; ?>

<section class="hero">
  <div class="container hero-grid">
    <div class="hero-copy">
      <span class="eyebrow"><i></i> <?=e(tr('hero_eyebrow'))?></span>
      <h1><?=e(tr('hero_first'))?><br><em><?=e(tr('hero_second'))?></em></h1>
      <p class="hero-lede"><?=e(tr('hero_intro'))?></p>
      <form class="zip-search" action="/" method="get">
        <label class="sr-only" for="zip"><?=e(tr('zip_placeholder'))?></label>
        <span aria-hidden="true">⌖</span>
        <input id="zip" name="location" value="<?=e($query)?>" placeholder="<?=e(tr('zip_placeholder'))?>">
        <button type="submit"><?=e(tr('search_care'))?> <b>→</b></button>
      </form>
      <div class="hero-actions">
        <a class="button" href="#contact"><?=e(tr('free_assessment'))?> <span>↗</span></a>
        <a class="text-link" href="#services"><?=e(tr('explore_services'))?> <span>→</span></a>
      </div>
      <div class="hero-proof">
        <div class="avatar-stack"><span>J</span><span>M</span><span>A</span><span>+</span></div>
        <div>
          <strong><?=e(tr('care_shaped_family'))?></strong>
          <small><?=e(tr('help_close_home'))?></small>
        </div>
        <span class="proof-stars">★★★★★</span>
      </div>
    </div>
    <div class="hero-art">
      <div class="hero-photo">
        <img src="/images/hero_caregiver.jpg" alt="<?=e(tr('help_feels_home'))?>">
        <div class="photo-wash"></div>
      </div>
      <div class="floating-note note-top">
        <span class="note-icon">✳</span>
        <div><strong><?=e(tr('care_your_way'))?></strong><small><?=e(tr('made_around_family'))?></small></div>
      </div>
      <div class="floating-note note-bottom">
        <span class="rating">♡</span><small><?=e(tr('help_feels_home'))?></small>
      </div>
    </div>
  </div>
  <div class="container hero-foot">
    <span><?=e(tr('thoughtful_matching'))?></span>
    <span><?=e(tr('support_family_caregivers'))?></span>
    <span><?=e(tr('personalized_plans'))?></span>
    <span><?=e(tr('care_close_home'))?></span>
  </div>
</section>

<section class="process section-pad">
  <div class="container">
    <div class="section-heading centered">
      <span class="eyebrow"><?=e(tr('process_eyebrow'))?></span>
      <h2><?=e(tr('process_heading'))?></h2>
      <p><?=e(tr('process_sub'))?></p>
    </div>
    <div class="steps">
      <?php foreach ([
        [tr('step_1_title'), tr('step_1_desc'), '⌕'],
        [tr('step_2_title'), tr('step_2_desc'), '♡'],
        [tr('step_3_title'), tr('step_3_desc'), '✎'],
        [tr('step_4_title'), tr('step_4_desc'), '✿']
      ] as $i=>$step): ?>
        <article>
          <span class="step-number">0<?=$i+1?></span>
          <div class="step-icon"><?=e($step[2])?></div>
          <h3><?=e($step[0])?></h3>
          <p><?=e($step[1])?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="services section-pad" id="services">
  <div class="container">
    <div class="section-heading">
      <span class="eyebrow"><?=e(tr('services_eyebrow'))?></span>
      <h2><?=e(tr('services_heading'))?></h2>
      <p><?=e(tr('services_sub'))?></p>
    </div>
    <div class="service-grid">
      <?php foreach ($services as $service): ?>
        <article class="service-card">
          <span class="service-icon"><?=e($service['icon'])?></span>
          <span class="card-arrow">↗</span>
          <h3><?=e(tr_service_title($service['title']))?></h3>
          <p><?=e(tr_service_summary($service['title'], $service['summary']))?></p>
          <a href="#contact"><?=e(tr('explore_care'))?> <span>→</span></a>
        </article>
      <?php endforeach; ?>
    </div>
    <div class="center-action">
      <a class="button button-outline" href="#contact"><?=e(tr('see_how_help'))?> <span>→</span></a>
    </div>
  </div>
</section>

<section class="why section-pad" id="about">
  <div class="container about-intro-grid">
    <div class="why-image">
      <img src="/images/about_team.jpg" alt="<?=e(tr('people_first_support'))?>">
      <div class="experience-tag"><strong>♡</strong><small><?=e(tr('people_first_support'))?></small></div>
    </div>
    <div class="why-copy">
      <p class="about-tagline"><?=e(tr('elevated_care'))?></p>
      <span class="eyebrow"><?=e(tr('about_eyebrow'))?></span>
      <h2><?=e(tr('who_are_we'))?></h2>
      <?php foreach ($aboutContent['who_we_are'] as $paragraph): ?>
        <p><?=e($paragraph)?></p>
      <?php endforeach; ?>
      <h3 class="vision-title"><?=e(tr('mission_q'))?></h3>
      <p><?=e($aboutContent['mission'])?></p>
      <h3 class="vision-title"><?=e(tr('vision_q'))?></h3>
      <p><?=e($aboutContent['vision'])?></p>
    </div>
  </div>
  <div class="container values-block">
    <div class="section-heading">
      <span class="eyebrow"><?=e(tr('values_eyebrow'))?></span>
      <h2><?=e(tr('core_values'))?></h2>
    </div>
    <div class="core-values-grid">
      <?php foreach ($aboutContent['values'] as $index=>$value): ?>
        <article class="core-value-card">
          <span class="core-value-mark" aria-hidden="true">0<?=($index+1)?></span>
          <h3><?=e($value['name'])?></h3>
          <p><?=e($value['description'])?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="container core-team-callout">
    <div>
      <span class="eyebrow"><?=e(tr('core_team_eyebrow'))?></span>
      <h2><?=e(tr('core_team'))?></h2>
      <p><?=e(tr('core_team_desc'))?></p>
    </div>
    <a class="button" href="#contact"><?=e(tr('meet_team_btn'))?> <span>→</span></a>
  </div>
  <div class="container stat-strip">
    <div><strong><?=e(tr('stat_1_strong'))?></strong><small><?=e(tr('stat_1_small'))?></small></div>
    <div><strong><?=e(tr('stat_2_strong'))?></strong><small><?=e(tr('stat_2_small'))?></small></div>
    <div><strong><?=e(tr('stat_3_strong'))?></strong><small><?=e(tr('stat_3_small'))?></small></div>
    <div><strong><?=e(tr('stat_4_strong'))?></strong><small><?=e(tr('stat_4_small'))?></small></div>
  </div>
</section>

<section class="stories section-pad" id="testimonials">
  <div class="container">
    <div class="section-heading centered">
      <span class="eyebrow"><?=e(tr('stories_eyebrow'))?></span>
      <h2><?=e(tr('stories_heading'))?></h2>
      <p><?=e(tr('stories_sub'))?></p>
    </div>
    <div class="testimonial-grid">
      <?php foreach ($testimonials as $item): ?>
        <article class="quote-card">
          <div class="stars"><?=str_repeat('★', min(5,(int)$item['rating']))?></div>
          <blockquote>“<?=e(tr_testimonial($item['quote']))?>”</blockquote>
          <div class="quote-person">
            <span class="person-dot"><?=e(strtoupper(substr($item['customer_name'],0,1)))?></span>
            <div><strong><?=e($item['customer_name'])?></strong><small><?=e($item['location'])?></small></div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="locations section-pad" id="locations">
  <div class="container location-grid">
    <div>
      <span class="eyebrow"><?=e(tr('locations_eyebrow'))?></span>
      <h2><?=e(tr('locations_heading'))?></h2>
      <p><?=e(tr('locations_sub'))?></p>
      <form class="location-controls" method="get" action="/">
        <select name="state">
          <option value=""><?=e(tr('all_states'))?></option>
          <?php foreach (db()->query('SELECT DISTINCT state FROM locations WHERE active=1 ORDER BY state')->fetchAll() as $stateRow): ?>
            <option value="<?=e($stateRow['state'])?>" <?=($_GET['state']??'')===$stateRow['state']?'selected':''?>><?=e($stateRow['state'])?></option>
          <?php endforeach; ?>
        </select>
        <input name="location" value="<?=e($query)?>" placeholder="<?=e(tr('search_city_zip'))?>" aria-label="<?=e(tr('search_city_zip'))?>">
        <button class="button button-small" type="submit"><?=e(tr('search'))?></button>
      </form>
      <?php foreach ($locations as $office): ?>
        <div class="location-card">
          <span class="pin">⌖</span>
          <div>
            <small><?=e(tr_location_state($office['state']))?></small>
            <h3><?=e($office['city'])?>, <?=e(tr_location_state($office['state']))?></h3>
            <p><?=e($office['address'])?><br><?=e($office['city'])?>, <?=e(tr_location_state($office['state']))?> <?=e($office['zip_code'])?><br><?=e(tr_location_hours($office['hours']))?></p>
            <a href="tel:<?=e(preg_replace('/\D/','',$office['phone']))?>"><?=e($office['phone'])?> ↗</a>
          </div>
        </div>
      <?php endforeach; ?>
      <div class="location-card location-coming-soon">
        <span class="pin">⌖</span>
        <div><small><?=e(tr('coming_soon'))?></small><h3>Arizona</h3><p><?=e(tr('preparing_arizona'))?></p></div>
      </div>
      <?php if (!$locations): ?>
        <p><?=e(tr('no_office'))?> <a href="#contact"><?=e(tr('contact_area'))?></a></p>
      <?php endif; ?>
    </div>
    <div class="map-panel">
      <div class="map-label label-austin">✿ &nbsp; <?=e(tr('local_care'))?></div>
      <div class="map-label label-la">✿ &nbsp; <?=e(tr('near_home'))?></div>
      <div class="map-label label-miami">✿ &nbsp; <?=e(tr('here_for_you'))?></div>
      <div class="map-caption">
        <span>✿</span>
        <div><strong><?=e(tr('map_strong'))?></strong><small><?=e(tr('map_small'))?></small></div>
      </div>
    </div>
  </div>
</section>

<section class="resources section-pad" id="resources">
  <div class="container">
    <div class="section-heading">
      <span class="eyebrow"><?=e(tr('resources_eyebrow'))?></span>
      <h2><?=e(tr('resources_heading'))?></h2>
      <p><?=e(tr('resources_sub'))?></p>
    </div>
    <div class="resource-grid">
      <?php foreach ($resources as $index=>$item): ?>
        <article class="resource-card resource-feature resource-tone-<?=($index%3)+1?>">
          <header class="resource-feature-head">
            <span class="resource-feature-icon" aria-hidden="true"><?=e($item['icon'])?></span>
            <div>
              <div class="resource-meta">
                <span><?=e(tr_resource_category($item['category']))?></span>
                <?php if(trim((string)($item['read_time']??''))!==''): ?><span><?=e(tr_resource_read_time($item['read_time']))?></span><?php endif; ?>
              </div>
              <h3><?=e(tr_resource_title($item['title']))?></h3>
              <p><?=e(tr_resource_summary($item['title'], $item['summary']))?></p>
            </div>
          </header>
          <a class="button button-small resource-cta" href="/resource.php?id=<?=e($item['id'])?>"><?=e(tr('read_more'))?> <span>→</span></a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="careers section-pad" id="careers">
  <div class="container career-grid">
    <div class="career-copy">
      <span class="eyebrow"><?=e(tr('careers_eyebrow'))?></span>
      <h2><?=e(tr('careers_heading'))?></h2>
      <p><?=e(tr('careers_sub'))?></p>
      <div class="career-perks">
        <span>♡ &nbsp; <?=e(tr('perk_1'))?></span>
        <span>✳ &nbsp; <?=e(tr('perk_2'))?></span>
        <span>✿ &nbsp; <?=e(tr('perk_3'))?></span>
      </div>
    </div>
    <form class="career-form" method="post">
      <input type="hidden" name="action" value="application">
      <?=csrf_field()?>
      <label class="honeypot">Website<input name="website" tabindex="-1" autocomplete="off"></label>
      <h3><?=e(tr('start_app'))?></h3>
      <p><?=e(tr('start_app_sub'))?></p>
      <div class="form-grid">
        <label><?=e(tr('first_name'))?><input name="first_name" required maxlength="100" placeholder="Jane"></label>
        <label><?=e(tr('last_name'))?><input name="last_name" required maxlength="100" placeholder="Smith"></label>
        <label class="span-two"><?=e(tr('email'))?><input name="email" type="email" required maxlength="190" placeholder="jane@example.com"></label>
        <label class="span-two"><?=e(tr('interested_in'))?>
          <select name="role" required>
            <option value=""><?=e(tr('choose_role'))?></option>
            <option value="Home Health Aide"><?=e(tr_caregiver_role('Home Health Aide'))?></option>
            <option value="Companion Caregiver"><?=e(tr_caregiver_role('Companion Caregiver'))?></option>
            <option value="Certified Nursing Assistant"><?=e(tr_caregiver_role('Certified Nursing Assistant'))?></option>
            <option value="Memory Care Specialist"><?=e(tr_caregiver_role('Memory Care Specialist'))?></option>
            <option value="Care Coordinator"><?=e(tr_caregiver_role('Care Coordinator'))?></option>
          </select>
        </label>
      </div>
      <button class="button" type="submit"><?=e(tr('apply_btn'))?> <span>→</span></button>
      <small><?=e(tr('info_private'))?></small>
    </form>
  </div>
</section>

<section class="faq section-pad" id="faq">
  <div class="container faq-grid">
    <div class="faq-intro">
      <span class="eyebrow"><?=e(tr('faq_eyebrow'))?></span>
      <h2><?=e(tr('faq_heading'))?></h2>
      <p><?=e(tr('faq_sub'))?></p>
      <a class="button button-outline" href="tel:<?=e($phoneLink)?>"><?=e(tr('talk_specialist'))?> <span>↗</span></a>
    </div>
    <div class="faq-list">
      <?php foreach ($faqs as $index=>$faq): ?>
        <details <?=$index===0?'open':''?>>
          <summary><?=e(tr_faq_q($faq['question']))?><span>+</span></summary>
          <p><?=e(tr_faq_a($faq['question'], $faq['answer']))?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="final-cta">
  <div class="container final-cta-inner">
    <span class="cta-flower">✿</span>
    <div>
      <span class="eyebrow"><?=e(tr('cta_eyebrow'))?></span>
      <h2><?=e(tr('cta_heading'))?></h2>
      <p><?=e(tr('cta_sub'))?></p>
    </div>
    <div class="cta-actions">
      <a class="button button-light" href="#contact"><?=e(tr('request_free_assess'))?> <span>→</span></a>
      <a href="tel:<?=e($phoneLink)?>"><?=e(tr('or_call'))?> <?=e($phone)?></a>
    </div>
  </div>
</section>

<section class="contact section-pad" id="contact">
  <div class="container contact-grid">
    <div class="contact-copy">
      <span class="eyebrow"><?=e(tr('contact_eyebrow'))?></span>
      <h2><?=e(tr('contact_heading'))?></h2>
      <p><?=e(tr('contact_sub'))?></p>
      <div class="contact-detail">
        <span>◷</span>
        <div><small><?=e(tr('call_247'))?></small><a href="tel:<?=e($phoneLink)?>"><?=e($phone)?></a></div>
      </div>
      <div class="contact-detail">
        <span>✉</span>
        <div><small><?=e(tr('email_team'))?></small><a href="mailto:<?=e($email)?>"><?=e($email)?></a></div>
      </div>
      <div class="emergency-note">✳ &nbsp; <?=e(tr('emergency_note'))?></div>
    </div>
    <form class="contact-form" method="post">
      <input type="hidden" name="action" value="inquiry">
      <?=csrf_field()?>
      <label class="honeypot">Website<input name="website" tabindex="-1" autocomplete="off"></label>
      <h3><?=e(tr('assessment'))?></h3>
      <p><?=e(tr('no_obligation'))?></p>
      <div class="form-grid">
        <label><?=e(tr('first_name'))?><input name="first_name" required maxlength="100" placeholder="<?=e(tr('first_name'))?>"></label>
        <label><?=e(tr('last_name'))?><input name="last_name" required maxlength="100" placeholder="<?=e(tr('last_name'))?>"></label>
        <label><?=e(tr('phone'))?><input name="phone" type="tel" required maxlength="40" placeholder="(555) 000-0000"></label>
        <label><?=e(tr('email'))?><input name="email" type="email" required maxlength="190" placeholder="you@example.com"></label>
        <label><?=e(tr('zip_code'))?><input name="zip_code" required maxlength="20" inputmode="numeric" placeholder="<?=e(tr('zip_code'))?>"></label>
        <label><?=e(tr('care_type'))?>
          <select name="care_type" required>
            <option value=""><?=e(tr('select_need'))?></option>
            <?php foreach ($services as $service): ?>
              <option><?=e(tr_service_title($service['title']))?></option>
            <?php endforeach; ?>
            <option><?=e(tr('not_sure_yet'))?></option>
          </select>
        </label>
        <label class="span-two"><?=e(tr('details'))?>
          <textarea name="details" rows="3" maxlength="3000" placeholder="<?=e(tr('details_placeholder'))?>"></textarea>
        </label>
      </div>
      <button class="button" type="submit"><?=e(tr('send_request'))?> <span>→</span></button>
      <small>🔒 &nbsp; <?=e(tr('secure_note'))?></small>
    </form>
  </div>
</section>
</main>

<footer class="footer">
  <div class="container footer-main">
    <div class="footer-about">
      <a class="brand" href="#top"><?=$logo?></a>
      <p><?=e($aboutContent['mission'])?></p>
      <div class="accreditations">
        <span><?=e(tr('accreditations'))?></span>
        <span><?=e(tr('licensed_bonded'))?></span>
      </div>
    </div>
    <div>
      <h4><?=e(tr('care_services'))?></h4>
      <?php foreach ($services as $service): ?>
        <a href="#services"><?=e(tr_service_title($service['title']))?></a>
      <?php endforeach; ?>
    </div>
    <div>
      <h4><?=e(tr('brand_name'))?></h4>
      <a href="#about"><?=e(tr('about'))?></a>
      <a href="#testimonials"><?=e(tr('family_stories'))?></a>
      <a href="#careers"><?=e(tr('join_team'))?></a>
      <a href="#locations"><?=e(tr('find_location'))?></a>
    </div>
    <div>
      <h4><?=e(tr('here_to_help'))?></h4>
      <a href="#resources"><?=e(tr('resources'))?></a>
      <a href="#faq">FAQs</a>
      <a href="#contact"><?=e(tr('contact'))?></a>
      <a href="mailto:<?=e($email)?>"><?=e($email)?></a>
      <a href="tel:<?=e($phoneLink)?>"><?=e(tr('call'))?></a>
      <a href="<?=e($whatsappLink)?>" target="_blank" rel="noopener">WhatsApp</a>
      <a href="/admin/login.php"><?=e(tr('admin_login'))?></a>
      <a href="https://www.instagram.com/happyhomecare/" target="_blank" rel="noopener noreferrer">@happyhomecare</a>
    </div>
  </div>
  <div class="container footer-bottom">
    <span>© <?=date('Y')?> <?=e(tr('brand_name'))?>. <?=e(tr('all_rights'))?></span>
    <div><a href="#contact"><?=e(tr('contact'))?></a><a href="#top"><?=e(tr('back_to_top'))?></a></div>
  </div>
</footer>

<div class="floating-contact" aria-label="Quick contact">
  <a class="quick-contact quick-request" href="#contact" aria-label="<?=e(tr('request_care'))?>">
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
    <span><?=e(tr('request_care'))?></span>
  </a>
  <a class="quick-contact quick-whatsapp" href="<?=e($whatsappLink)?>" target="_blank" rel="noopener" aria-label="Message <?=e(tr('brand_name'))?> on WhatsApp">
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 11.7a8.4 8.4 0 0 1-12.4 7.4L3 20l.9-4.9a8.4 8.4 0 1 1 16.6-3.4Z"/><path d="M8.4 8.2c.3-.7.6-.7.9-.7h.5c.2 0 .4.1.5.4l.7 1.7c.1.2 0 .4-.1.6l-.5.6c-.2.2-.2.4 0 .6.5.8 1.1 1.4 1.9 1.8.2.1.4.1.6-.1l.7-.8c.2-.2.4-.2.6-.1l1.6.8c.2.1.3.3.3.5 0 .4-.2 1.1-.6 1.4-.4.4-1 .6-1.7.5-1.1-.2-2.4-.8-3.7-2-1.1-1-2-2.3-2.2-3.4-.2-.8.1-1.4.5-1.8Z"/></svg>
    <span>WhatsApp</span>
  </a>
  <a class="quick-contact quick-call" href="tel:<?=e($phoneLink)?>" aria-label="<?=e(tr('call'))?> <?=e($phone)?>">
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3h3l1.5 4.2-2 1.7a15 15 0 0 0 5.6 5.6l1.7-2L21 14v3c0 1.1-.9 2-2 2C10.2 19 5 13.8 5 5c0-1.1.9-2 2-2Z"/></svg>
    <span><?=e(tr('call'))?> <?=e($phone)?></span>
  </a>
</div>
</body>
</html>
