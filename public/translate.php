<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/app/bootstrap.php';
require_once dirname(__DIR__) . '/app/i18n.php';
require_once dirname(__DIR__) . '/app/about_content.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function translation_reply(int $status, array $body): never {
    http_response_code($status);
    echo json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    translation_reply(405, ['error' => 'POST required']);
}

$origin = (string)($_SERVER['HTTP_ORIGIN'] ?? '');
$host = strtolower((string)($_SERVER['HTTP_HOST'] ?? ''));
if ($origin !== '') {
    $originHost = strtolower((string)parse_url($origin, PHP_URL_HOST));
    if ($originHost === '' || $originHost !== preg_replace('/:\d+$/', '', $host)) {
        translation_reply(403, ['error' => 'Cross-origin requests are not allowed']);
    }
}

$input = json_decode((string)file_get_contents('php://input'), true);
$target = (string)($input['target'] ?? '');
$texts = $input['texts'] ?? null;

if (!in_array($target, ['en', 'pa', 'hi', 'es'], true) || !is_array($texts) || count($texts) < 1 || count($texts) > 256) {
    translation_reply(422, ['error' => 'Unsupported language or text batch']);
}

$clean = [];
$total = 0;
foreach ($texts as $text) {
    if (!is_string($text)) translation_reply(422, ['error' => 'Text item is invalid']);
    $characters = preg_match_all('/./us', $text, $unused);
    if ($characters === false || $characters > 5000) translation_reply(422, ['error' => 'Text item is too long']);
    $total += $characters;
    if ($total > 35000) translation_reply(413, ['error' => 'Text batch is too large']);
    $clean[] = $text;
}

// Check session rate limiting
$now = time();
$recent = array_values(array_filter($_SESSION['translate_requests'] ?? [], static fn(int $stamp): bool => $stamp > $now - 60));
if (count($recent) >= 60) translation_reply(429, ['error' => 'Please wait a minute before translating more pages.']);
$recent[] = $now;
$_SESSION['translate_requests'] = $recent;

// If Google Translate API Key is configured and cURL is available, try Google Translate API first
$key = envv('GOOGLE_TRANSLATE_API_KEY');
if ($key !== '' && function_exists('curl_init')) {
    $curl = curl_init('https://translation.googleapis.com/language/translate/v2?key=' . rawurlencode($key));
    curl_setopt_array($curl, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode(['q' => $clean, 'target' => $target, 'format' => 'text'], JSON_UNESCAPED_UNICODE),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=utf-8'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 6,
        CURLOPT_TIMEOUT => 15,
    ]);
    $response = curl_exec($curl);
    $status = (int)curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    curl_close($curl);

    if ($response !== false && $status >= 200 && $status < 300) {
        $decoded = json_decode($response, true);
        $translated = $decoded['data']['translations'] ?? null;
        if (is_array($translated) && count($translated) === count($clean)) {
            translation_reply(200, [
                'translations' => array_map(
                    static fn(array $item): string => html_entity_decode((string)($item['translatedText'] ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                    $translated
                )
            ]);
        }
    }
}

// Built-in dictionary fallback
// Build comprehensive translation dictionary
function get_translation_dictionary(string $target): array {
    static $dictionaries = [];
    if (isset($dictionaries[$target])) return $dictionaries[$target];

    $dict = [];
    $populate = function(string $en, string $targetText) use (&$dict) {
        $enClean = trim($en);
        if ($enClean === '') return;
        $dict[$enClean] = $targetText;
        $dict[mb_strtolower($enClean, 'UTF-8')] = $targetText;
    };

    // Brand and logo translations
    $logos = [
        'HAPPY HOME CARE' => ['pa' => 'ਹੈਪੀ ਹੋਮ ਕੇਅਰ', 'hi' => 'हैप्पी होम केयर', 'es' => 'HAPPY HOME CARE'],
        'Elevated Care. Right at Home.' => ['pa' => 'ਉੱਚ ਪੱਧਰੀ ਦੇਖਭਾਲ। ਤੁਹਾਡੇ ਆਪਣੇ ਘਰ ਵਿੱਚ।', 'hi' => 'बेहतर देखभाल। आपके अपने घर पर।', 'es' => 'Atención Superior. En Su Hogar.'],
        'ELEVATED CARE. RIGHT AT HOME.' => ['pa' => 'ਉੱਚ ਪੱਧਰੀ ਦੇਖਭਾਲ। ਤੁਹਾਡੇ ਆਪਣੇ ਘਰ ਵਿੱਚ।', 'hi' => 'बेहतर देखभाल। आपके अपने घर पर।', 'es' => 'ATENCIÓN SUPERIOR. EN SU HOGAR.'],
        'Happy Home Care' => ['pa' => 'ਹੈਪੀ ਹੋਮ ਕੇਅਰ', 'hi' => 'हैप्पी होम केयर', 'es' => 'Happy Home Care'],
        'Happy Home Care - Elevated Care. Right At Home.' => [
            'pa' => 'ਹੈਪੀ ਹੋਮ ਕੇਅਰ - ਉੱਚ ਪੱਧਰੀ ਦੇਖਭਾਲ। ਤੁਹਾਡੇ ਆਪਣੇ ਘਰ ਵਿੱਚ।',
            'hi' => 'हैप्पी होम केयर - बेहतर देखभाल। आपके अपने घर पर।',
            'es' => 'Happy Home Care - Atención Superior. En Su Hogar.'
        ],
    ];
    foreach ($logos as $en => $langs) {
        $populate($en, $langs[$target] ?? $en);
    }

    // Load from UI messages
    // We can simulate current_language() or read messages
    $enKeys = [
        'about' => 'About Us', 'resources' => 'Resources', 'services' => 'Services', 'locations' => 'Locations',
        'login' => 'Login', 'signup' => 'Sign up', 'call' => 'Call', 'request_care' => 'Request care',
        'contact' => 'Contact', 'care_services' => 'Care services', 'find_location' => 'Find a location',
        'first_name' => 'First name', 'last_name' => 'Last name', 'phone' => 'Phone number', 'email' => 'Email address',
        'password' => 'Password', 'confirm_password' => 'Confirm password', 'sign_in' => 'Sign in',
        'create_account' => 'Create account', 'admin_login' => 'Admin login', 'google_signin' => 'Continue with Google',
        'facebook_signin' => 'Continue with Facebook', 'or_email' => 'or continue with email', 'logout' => 'Sign out',
        'language' => 'Choose language',
        'hero_eyebrow' => 'Here for every step of the care journey',
        'hero_first' => 'Care that feels', 'hero_second' => 'like home.',
        'hero_intro' => 'Compassionate, professional in-home care for seniors and adults. We make it easier to live safely, comfortably, and happily at home.',
        'search_care' => 'Find care', 'explore_services' => 'Explore services',
        'zip_placeholder' => 'Enter your ZIP code or city',
        'free_assessment' => 'Get a free assessment',
        'care_shaped_family' => 'Care shaped around your family',
        'help_close_home' => 'Personalized help, close to home',
        'care_your_way' => 'Care, your way',
        'made_around_family' => 'Made around your family',
        'help_feels_home' => 'Help that feels like home',
        'people_first_support' => 'People-first support',
        'thoughtful_matching' => 'Thoughtful caregiver matching',
        'support_family_caregivers' => 'Support for family caregivers',
        'personalized_plans' => 'Personalized care plans',
        'care_close_home' => 'Care close to home',
        'process_eyebrow' => 'A little help goes a long way',
        'process_heading' => 'Getting started is simple.',
        'process_sub' => 'From the first conversation to your loved one\'s first visit, we\'re right here with you.',
        'step_1_title' => 'Find your fit', 'step_1_desc' => 'Explore our care services to find the right kind of support.',
        'step_2_title' => 'Meet your care team', 'step_2_desc' => 'A friendly specialist listens, visits, and learns what matters to your family.',
        'step_3_title' => 'Make a plan', 'step_3_desc' => 'Together, we create a thoughtful plan around your loved one\'s needs and routine.',
        'step_4_title' => 'Feel at home', 'step_4_desc' => 'Your matched caregiver arrives, and our team stays close as care begins.',
        'services_eyebrow' => 'Support for every season',
        'services_heading' => 'Care that meets you where you are.',
        'services_sub' => 'From a helping hand with the day-to-day to specialized support, we\'re here to make home feel like home.',
        'explore_care' => 'Explore care', 'see_how_help' => 'See how we can help',
        'about_eyebrow' => 'About Happy Home Care', 'who_are_we' => 'Who are we?',
        'mission_q' => 'What is our mission?', 'vision_q' => 'What is our vision?',
        'values_eyebrow' => 'What guides us', 'core_values' => 'Core values',
        'core_team_eyebrow' => 'At your side', 'core_team' => 'Core Team',
        'core_team_desc' => 'Our team is here to help families navigate care with dignity, understanding, and a personal touch.',
        'meet_team_btn' => 'Meet with our care team',
        'stat_1_strong' => 'One+', 'stat_1_small' => 'family at a time',
        'stat_2_strong' => 'Care+', 'stat_2_small' => 'with compassion',
        'stat_3_strong' => 'At+', 'stat_3_small' => 'home, where it matters',
        'stat_4_strong' => 'You♡', 'stat_4_small' => 'at the center of care',
        'stories_eyebrow' => 'Kind words, from the heart',
        'stories_heading' => 'Families feel the difference.',
        'stories_sub' => 'Every family has their own story. Here are a few we\'re honored to be part of.',
        'caregivers_eyebrow' => 'Wonderful people, wonderful care',
        'caregivers_heading' => 'Meet a few of our caregivers.',
        'caregivers_sub' => 'Every caregiver is handpicked for their compassion, skill, and dedication.',
        'locations_eyebrow' => 'Close to home',
        'locations_heading' => 'Care, right around the corner.',
        'locations_sub' => 'Our local teams know their communities and are ready to help your family find care nearby.',
        'all_states' => 'All states',
        'search_city_zip' => 'Search city or ZIP code',
        'search' => 'Search',
        'coming_soon' => 'Coming soon',
        'preparing_arizona' => 'We are preparing to serve families in Arizona.',
        'no_office' => 'No office matched that search.',
        'contact_area' => 'Contact us about your area.',
        'local_care' => 'Local care', 'near_home' => 'Near home', 'here_for_you' => 'Here for you',
        'map_strong' => 'Local care. Happy homes.',
        'map_small' => 'Here for your family, wherever home is.',
        'resources_eyebrow' => 'A little know-how helps',
        'resources_heading' => 'Helpful reads for your journey.',
        'resources_sub' => 'Clear, compassionate guidance for every step of caring for someone you love.',
        'read_more' => 'Read more',
        'careers_eyebrow' => 'Make a difference every day',
        'careers_heading' => 'Put your caring heart to work.',
        'careers_sub' => 'Join a team that sees the person behind every care plan. Do meaningful work, feel supported, and help people live well at home.',
        'perk_1' => 'Flexible scheduling', 'perk_2' => 'Great pay and benefits', 'perk_3' => 'Free training and growth',
        'start_app' => 'Start your application',
        'start_app_sub' => 'Tell us a little about yourself. It only takes a moment.',
        'interested_in' => 'I\'m interested in',
        'choose_role' => 'Choose a role',
        'apply_btn' => 'Apply to our team',
        'info_private' => 'We\'ll be in touch soon. Your information stays private.',
        'faq_eyebrow' => 'Good questions',
        'faq_heading' => 'Here when you wonder.',
        'faq_sub' => 'Still figuring it all out? That’s okay. We’re always happy to talk things through.',
        'talk_specialist' => 'Talk to a care specialist',
        'cta_eyebrow' => 'A happier home starts here',
        'cta_heading' => 'Let\'s make home feel good again.',
        'cta_sub' => 'Start with a free, no-pressure conversation. Our care team is here for you, day or night.',
        'request_free_assess' => 'Request free assessment',
        'or_call' => 'Or call us:',
        'contact_eyebrow' => 'Let\'s talk about care',
        'contact_heading' => 'Here for your family, right now.',
        'contact_sub' => 'Share a little about what you need. A care specialist will reach out within two hours during business hours.',
        'call_247' => 'CALL US 24/7',
        'email_team' => 'EMAIL OUR TEAM',
        'emergency_note' => 'Need care today? Call us for urgent placement support.',
        'assessment' => 'Request a free assessment',
        'no_obligation' => 'There\'s no obligation. Just a friendly conversation.',
        'care_type' => 'Type of care',
        'select_need' => 'Select what you need',
        'not_sure_yet' => 'Not sure yet',
        'zip_code' => 'ZIP code',
        'details' => 'Anything else we should know?',
        'details_placeholder' => 'Tell us a little about your situation (optional)',
        'send_request' => 'Request my free assessment',
        'secure_note' => 'Your information is stored securely for follow-up.',
        'accreditations' => 'ACHC Accredited',
        'licensed_bonded' => 'Licensed & bonded',
        'family_stories' => 'Family stories',
        'join_team' => 'Join our team',
        'here_to_help' => 'Here to help',
        'all_rights' => 'All rights reserved.',
        'back_to_top' => 'Back to top ↑',
    ];

    // Read translated messages
    $oldSession = $_SESSION['site_language'] ?? null;
    $_SESSION['site_language'] = $target;
    foreach ($enKeys as $k => $enVal) {
        $transVal = tr($k);
        $populate($enVal, $transVal);
    }

    // Services
    $serviceList = [
        'Personal care', 'Companion care', 'Memory care', 'Respite care', 'Recovery at home', '24-hour care'
    ];
    foreach ($serviceList as $s) {
        $populate($s, tr_service_title($s));
    }

    // FAQs
    $faqList = [
        'Are caregivers screened and insured?',
        'Can we change the care plan later?',
        'How much does home care cost?',
        'How soon can care begin?',
        'What kinds of in-home care do you offer?'
    ];
    foreach ($faqList as $q) {
        $populate($q, tr_faq_q($q));
    }

    // Testimonials
    $testList = [
        "We finally sleep at night knowing Mom is in good hands. Her caregiver is patient, warm, and thoughtful.",
        "The personal touch makes all the difference. They really listened and found someone who loves gardening just like Dad.",
        "Respite care let my husband and me take our first trip in years. We were able to truly relax."
    ];
    foreach ($testList as $t) {
        $populate($t, tr_testimonial($t));
    }

    // Roles
    $roles = [
        'Senior Care Specialist', 'Home Health Aide', 'Certified Nursing Assistant', 'Companion Caregiver', 'Memory Care Specialist', 'Care Coordinator'
    ];
    foreach ($roles as $r) {
        $populate($r, tr_caregiver_role($r));
    }

    // Resources
    $resourceTitles = [
        "What Medicare won't cover, and what to do about it",
        "What Medicare won’t cover, and what to do about it",
        "Health care decisions",
        "Caring for your parents shouldn't mean losing yourself",
        "Caring for your parents shouldn’t mean losing yourself",
    ];
    foreach ($resourceTitles as $rt) {
        $populate($rt, tr_resource_title($rt));
    }

    $resourceCats = ['Family guide', 'Health care decisions', 'Caregiver wellness'];
    foreach ($resourceCats as $rc) {
        $populate($rc, tr_resource_category($rc));
    }

    $resourceTimes = ['2 min read', '4 min read', 'Self-care guide'];
    foreach ($resourceTimes as $rm) {
        $populate($rm, tr_resource_read_time($rm));
    }

    $resourceBtns = ['How to start?', 'Talk to us'];
    foreach ($resourceBtns as $rb) {
        $populate($rb, tr_resource_btn($rb));
    }

    $resourceSums = [
        "Understand the difference between skilled care Medicare may cover and long-term personal care, plus options families can explore." => "What Medicare won't cover, and what to do about it",
        "Plan ahead for who can speak with a parent's bank or doctor if they cannot make decisions themselves." => "Health care decisions",
        "Plan ahead for who can speak with a parent’s bank or doctor if they cannot make decisions themselves." => "Health care decisions",
        "Caring for someone you love can take over your day. These ideas can help you make room for your own needs too." => "Caring for your parents shouldn't mean losing yourself",
    ];
    foreach ($resourceSums as $sum => $tKey) {
        $populate($sum, tr_resource_summary($tKey, $sum));
    }

    // Locations and hours
    $locationHours = ['Every day — 24/7 support', 'Every day • 24/7 support'];
    foreach ($locationHours as $lh) {
        $populate($lh, tr_location_hours($lh));
    }

    $states = ['Indiana', 'Arizona'];
    foreach ($states as $st) {
        $populate($st, tr_location_state($st));
    }

    $locs = ['Austin, TX', 'Phoenix, AZ', 'Seattle, WA'];
    foreach ($locs as $lc) {
        $populate($lc, tr_testimonial_location($lc));
    }

    // Restore session language
    if ($oldSession !== null) {
        $_SESSION['site_language'] = $oldSession;
    } else {
        unset($_SESSION['site_language']);
    }

    $dictionaries[$target] = $dict;
    return $dict;
}

$dictionary = get_translation_dictionary($target);

$results = [];
foreach ($clean as $str) {
    $trimmed = trim($str);
    if ($trimmed === '' || $target === 'en') {
        $results[] = $str;
        continue;
    }

    // Direct match
    if (isset($dictionary[$trimmed])) {
        $results[] = $dictionary[$trimmed];
        continue;
    }

    // Case-insensitive match
    $lower = mb_strtolower($trimmed, 'UTF-8');
    if (isset($dictionary[$lower])) {
        $results[] = $dictionary[$lower];
        continue;
    }

    // Check without punctuation
    $stripped = trim($trimmed, " \t\n\r\0\x0B.,!?:;\"'“”‘’");
    if (isset($dictionary[$stripped])) {
        $results[] = $dictionary[$stripped];
        continue;
    }

    // Fallback to original text safely without failing
    $results[] = $str;
}

translation_reply(200, ['translations' => $results]);
