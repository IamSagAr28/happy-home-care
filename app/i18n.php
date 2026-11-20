<?php
declare(strict_types=1);

if (!function_exists('current_language')) {
function current_language(): string {
    $supported = ['en', 'pa', 'hi', 'es'];
    if (isset($_GET['lang']) && in_array((string)$_GET['lang'], $supported, true)) {
        $_SESSION['site_language'] = (string)$_GET['lang'];
    }
    $language = (string)($_SESSION['site_language'] ?? 'en');
    return in_array($language, $supported, true) ? $language : 'en';
}
}

if (!function_exists('tr')) {
function tr(string $key): string {
    static $messages = [
        'en' => [
            'brand_name' => 'HAPPY HOME CARE',
            'elevated_care' => 'Elevated Care. Right at Home.',
            'about' => 'About Us',
            'resources' => 'Resources',
            'services' => 'Services',
            'locations' => 'Locations',
            'login' => 'Login',
            'signup' => 'Sign up',
            'call' => 'Call',
            'request_care' => 'Request care',
            'contact' => 'Contact',
            'care_services' => 'Care services',
            'find_location' => 'Find a location',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'phone' => 'Phone number',
            'email' => 'Email address',
            'password' => 'Password',
            'confirm_password' => 'Confirm password',
            'sign_in' => 'Sign in',
            'create_account' => 'Create account',
            'admin_login' => 'Admin login',
            'google_signin' => 'Continue with Google',
            'facebook_signin' => 'Continue with Facebook',
            'or_email' => 'or continue with email',
            'logout' => 'Sign out',
            'language' => 'Choose language',
            'hero_eyebrow' => 'Here for every step of the care journey',
            'hero_first' => 'Care that feels',
            'hero_second' => 'like home.',
            'hero_intro' => 'Compassionate, professional in-home care for seniors and adults. We make it easier to live safely, comfortably, and happily at home.',
            'search_care' => 'Find care',
            'explore_services' => 'Explore services',
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
            'step_1_title' => 'Find your fit',
            'step_1_desc' => 'Explore our care services to find the right kind of support.',
            'step_2_title' => 'Meet your care team',
            'step_2_desc' => 'A friendly specialist listens, visits, and learns what matters to your family.',
            'step_3_title' => 'Make a plan',
            'step_3_desc' => 'Together, we create a thoughtful plan around your loved one\'s needs and routine.',
            'step_4_title' => 'Feel at home',
            'step_4_desc' => 'Your matched caregiver arrives, and our team stays close as care begins.',
            'services_eyebrow' => 'Support for every season',
            'services_heading' => 'Care that meets you where you are.',
            'services_sub' => 'From a helping hand with the day-to-day to specialized support, we\'re here to make home feel like home.',
            'explore_care' => 'Explore care',
            'see_how_help' => 'See how we can help',
            'about_eyebrow' => 'About Happy Home Care',
            'who_are_we' => 'Who are we?',
            'mission_q' => 'What is our mission?',
            'vision_q' => 'What is our vision?',
            'values_eyebrow' => 'What guides us',
            'core_values' => 'Core values',
            'core_team_eyebrow' => 'At your side',
            'core_team' => 'Core Team',
            'core_team_desc' => 'Our team is here to help families navigate care with dignity, understanding, and a personal touch.',
            'meet_team_btn' => 'Meet with our care team',
            'stat_1_strong' => 'One+',
            'stat_1_small' => 'family at a time',
            'stat_2_strong' => 'Care+',
            'stat_2_small' => 'with compassion',
            'stat_3_strong' => 'At+',
            'stat_3_small' => 'home, where it matters',
            'stat_4_strong' => 'You♡',
            'stat_4_small' => 'at the center of care',
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
            'local_care' => 'Local care',
            'near_home' => 'Near home',
            'here_for_you' => 'Here for you',
            'map_strong' => 'Local care. Happy homes.',
            'map_small' => 'Here for your family, wherever home is.',
            'resources_eyebrow' => 'A little know-how helps',
            'resources_heading' => 'Helpful reads for your journey.',
            'resources_sub' => 'Clear, compassionate guidance for every step of caring for someone you love.',
            'read_more' => 'Read more',
            'careers_eyebrow' => 'Make a difference every day',
            'careers_heading' => 'Put your caring heart to work.',
            'careers_sub' => 'Join a team that sees the person behind every care plan. Do meaningful work, feel supported, and help people live well at home.',
            'perk_1' => 'Flexible scheduling',
            'perk_2' => 'Great pay and benefits',
            'perk_3' => 'Free training and growth',
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
        ],
        'pa' => [
            'brand_name' => 'ਹੈਪੀ ਹੋਮ ਕੇਅਰ',
            'elevated_care' => 'ਉੱਚ ਪੱਧਰੀ ਦੇਖਭਾਲ। ਤੁਹਾਡੇ ਆਪਣੇ ਘਰ ਵਿੱਚ।',
            'about' => 'ਸਾਡੇ ਬਾਰੇ',
            'resources' => 'ਸਰੋਤ',
            'services' => 'ਸੇਵਾਵਾਂ',
            'locations' => 'ਸਥਾਨ',
            'login' => 'ਲਾਗ ਇਨ',
            'signup' => 'ਸਾਈਨ ਅੱਪ',
            'call' => 'ਕਾਲ ਕਰੋ',
            'request_care' => 'ਦੇਖਭਾਲ ਲਈ ਬੇਨਤੀ',
            'contact' => 'ਸੰਪਰਕ',
            'care_services' => 'ਦੇਖਭਾਲ ਸੇਵਾਵਾਂ',
            'find_location' => 'ਸਥਾਨ ਲੱਭੋ',
            'first_name' => 'ਪਹਿਲਾ ਨਾਮ',
            'last_name' => 'ਆਖਰੀ ਨਾਮ',
            'phone' => 'ਫ਼ੋਨ ਨੰਬਰ',
            'email' => 'ਈਮੇਲ ਪਤਾ',
            'password' => 'ਪਾਸਵਰਡ',
            'confirm_password' => 'ਪਾਸਵਰਡ ਦੀ ਪੁਸ਼ਟੀ ਕਰੋ',
            'sign_in' => 'ਸਾਈਨ ਇਨ',
            'create_account' => 'ਖਾਤਾ ਬਣਾਓ',
            'admin_login' => 'ਪ੍ਰਸ਼ਾਸਕ ਲਾਗ ਇਨ',
            'google_signin' => 'Google ਨਾਲ ਜਾਰੀ ਰੱਖੋ',
            'facebook_signin' => 'Facebook ਨਾਲ ਜਾਰੀ ਰੱਖੋ',
            'or_email' => 'ਜਾਂ ਈਮੇਲ ਨਾਲ',
            'logout' => 'ਲਾਗ ਆਉਟ',
            'language' => 'ਭਾਸ਼ਾ ਚੁਣੋ',
            'hero_eyebrow' => 'ਦੇਖਭਾਲ ਦੇ ਹਰ ਕਦਮ \'ਤੇ ਤੁਹਾਡੇ ਨਾਲ',
            'hero_first' => 'ਘਰ ਵਰਗੀ ਮਹਿਸੂਸ ਹੋਵੇ ਦੇਖਭਾਲ',
            'hero_second' => 'ਤੁਹਾਡੇ ਘਰ ਵਿੱਚ।',
            'hero_intro' => 'ਬਜ਼ੁਰਗਾਂ ਅਤੇ ਬਾਲਗਾਂ ਲਈ ਦਿਲੋਂ, ਪੇਸ਼ੇਵਰ ਘਰੇਲੂ ਦੇਖਭਾਲ। ਅਸੀਂ ਘਰ ਵਿੱਚ ਸੁਰੱਖਿਅਤ, ਸੁਖੀ ਅਤੇ ਖੁਸ਼ਹਾਲ ਰਹਿਣਾ ਆਸਾਨ ਬਣਾਉਂਦੇ ਹਾਂ।',
            'search_care' => 'ਦੇਖਭਾਲ ਲੱਭੋ',
            'explore_services' => 'ਸੇਵਾਵਾਂ ਵੇਖੋ',
            'zip_placeholder' => 'ਆਪਣਾ ਜ਼ਿਪ ਕੋਡ ਜਾਂ ਸ਼ਹਿਰ ਦਰਜ ਕਰੋ',
            'free_assessment' => 'ਮੁਫ਼ਤ ਮੁਲਾਂਕਣ ਪ੍ਰਾਪਤ ਕਰੋ',
            'care_shaped_family' => 'ਤੁਹਾਡੇ ਪਰਿਵਾਰ ਅਨੁਸਾਰ ਦੇਖਭਾਲ',
            'help_close_home' => 'ਘਰ ਦੇ ਨੇੜੇ ਨਿੱਜੀ ਮਦਦ',
            'care_your_way' => 'ਦੇਖਭਾਲ, ਤੁਹਾਡੇ ਤਰੀਕੇ ਨਾਲ',
            'made_around_family' => 'ਤੁਹਾਡੇ ਪਰਿਵਾਰ ਅਨੁਸਾਰ',
            'help_feels_home' => 'ਘਰ ਵਰਗਾ ਅਹਿਸਾਸ',
            'people_first_support' => 'ਲੋਕਾਂ ਨੂੰ ਪਹਿਲ ਦੇਣ ਵਾਲੀ ਮਦਦ',
            'thoughtful_matching' => 'ਸੋਚ-ਸਮਝ ਕੇ ਕੇਅਰਗਿਵਰ ਮਿਲਾਣ',
            'support_family_caregivers' => 'ਪਰਿਵਾਰਕ ਦੇਖਭਾਲ ਕਰਨ ਵਾਲਿਆਂ ਲਈ ਸਹਾਇਤਾ',
            'personalized_plans' => 'ਨਿੱਜੀ ਦੇਖਭਾਲ ਯੋਜਨਾਵਾਂ',
            'care_close_home' => 'ਘਰ ਦੇ ਨੇੜੇ ਦੇਖਭਾਲ',
            'process_eyebrow' => 'ਇੱਕ ਛੋਟੀ ਜਿਹੀ ਮਦਦ ਬਹੁਤ ਅੱਗੇ ਲੈ ਜਾਂਦੀ ਹੈ',
            'process_heading' => 'ਸ਼ੁਰੂ ਕਰਨਾ ਬਹੁਤ ਆਸਾਨ ਹੈ।',
            'process_sub' => 'ਪਹਿਲੀ ਗੱਲਬਾਤ ਤੋਂ ਲੈ ਕੇ ਤੁਹਾਡੇ ਪਿਆਰੇ ਦੀ ਪਹਿਲੀ ਮੁਲਾਕਾਤ ਤੱਕ, ਅਸੀਂ ਹਰ ਕਦਮ ਤੁਹਾਡੇ ਨਾਲ ਹਾਂ।',
            'step_1_title' => 'ਸਹੀ ਸੇਵਾ ਚੁਣੋ',
            'step_1_desc' => 'ਸਹੀ ਸਹਾਇਤਾ ਲੱਭਣ ਲਈ ਸਾਡੀਆਂ ਦੇਖਭਾਲ ਸੇਵਾਵਾਂ ਵੇਖੋ।',
            'step_2_title' => 'ਆਪਣੀ ਦੇਖਭਾਲ ਟੀਮ ਨੂੰ ਮਿਲੋ',
            'step_2_desc' => 'ਇੱਕ ਮਦਦਗਾਰ ਮਾਹਿਰ ਸੁਣਦਾ ਹੈ, ਮਿਲਦਾ ਹੈ ਅਤੇ ਤੁਹਾਡੇ ਪਰਿਵਾਰ ਦੀਆਂ ਲੋੜਾਂ ਸਮਝਦਾ ਹੈ।',
            'step_3_title' => 'ਇੱਕ ਯੋਜਨਾ ਬਣਾਓ',
            'step_3_desc' => 'ਮਿਲ ਕੇ, ਅਸੀਂ ਤੁਹਾਡੇ ਪਿਆਰੇ ਦੀਆਂ ਜ਼ਰੂਰਤਾਂ ਅਤੇ ਰੁਟੀਨ ਅਨੁਸਾਰ ਇੱਕ ਯੋਜਨਾ ਤਿਆਰ ਕਰਦੇ ਹਾਂ।',
            'step_4_title' => 'ਘਰ ਵਰਗਾ ਮਹਿਸੂਸ ਕਰੋ',
            'step_4_desc' => 'ਤੁਹਾਡਾ ਚੁਣਿਆ ਗਿਆ ਕੇਅਰਗਿਵਰ ਪਹੁੰਚਦਾ ਹੈ, ਅਤੇ ਸਾਡੀ ਟੀਮ ਹਰ ਪਲ ਨਾਲ ਰਹਿੰਦੀ ਹੈ।',
            'services_eyebrow' => 'ਹਰ ਮੌਸਮ ਵਿੱਚ ਸਹਾਇਤਾ',
            'services_heading' => 'ਤੁਹਾਡੀ ਲੋੜ ਅਨੁਸਾਰ ਦੇਖਭਾਲ।',
            'services_sub' => 'ਰੋਜ਼ਾਨਾ ਦੇ ਕੰਮਾਂ ਵਿੱਚ ਮਦਦ ਤੋਂ ਲੈ ਕੇ ਵਿਸ਼ੇਸ਼ ਦੇਖਭਾਲ ਤੱਕ, ਅਸੀਂ ਘਰ ਨੂੰ ਘਰ ਬਣਾਈ ਰੱਖਣ ਲਈ ਇੱਥੇ ਹਾਂ।',
            'explore_care' => 'ਦੇਖਭਾਲ ਜਾਣੋ',
            'see_how_help' => 'ਵੇਖੋ ਅਸੀਂ ਕਿਵੇਂ ਮਦਦ ਕਰ ਸਕਦੇ ਹਾਂ',
            'about_eyebrow' => 'ਹੈਪੀ ਹੋਮ ਕੇਅਰ ਬਾਰੇ',
            'who_are_we' => 'ਅਸੀਂ ਕੌਣ ਹਾਂ?',
            'mission_q' => 'ਸਾਡਾ ਮਿਸ਼ਨ ਕੀ ਹੈ?',
            'vision_q' => 'ਸਾਡਾ ਦ੍ਰਿਸ਼ਟੀਕੋਣ ਕੀ ਹੈ?',
            'values_eyebrow' => 'ਜੋ ਸਾਨੂੰ ਸੇਧ ਦਿੰਦਾ ਹੈ',
            'core_values' => 'ਮੁੱਖ ਕਦਰਾਂ-ਕੀਮਤਾਂ',
            'core_team_eyebrow' => 'ਤੁਹਾਡੇ ਨਾਲ',
            'core_team' => 'ਮੁੱਖ ਟੀਮ',
            'core_team_desc' => 'ਸਾਡੀ ਟੀਮ ਪਰਿਵਾਰਾਂ ਨੂੰ ਸਤਿਕਾਰ, ਸਮਝ ਅਤੇ ਨਿੱਜੀ ਅਪਣੱਤ ਨਾਲ ਦੇਖਭਾਲ ਪ੍ਰਦਾਨ ਕਰਨ ਲਈ ਸਮਰਪਿਤ ਹੈ।',
            'meet_team_btn' => 'ਸਾਡੀ ਦੇਖਭਾਲ ਟੀਮ ਨਾਲ ਮਿਲੋ',
            'stat_1_strong' => 'ਇੱਕ-ਇੱਕ+',
            'stat_1_small' => 'ਪਰਿਵਾਰ ਦੀ ਦੇਖਭਾਲ',
            'stat_2_strong' => 'ਦੇਖਭਾਲ+',
            'stat_2_small' => 'ਦਿਲੋਂ ਹਮਦਰਦੀ ਨਾਲ',
            'stat_3_strong' => 'ਘਰ ਵਿੱਚ+',
            'stat_3_small' => 'ਜਿੱਥੇ ਸਭ ਤੋਂ ਵੱਧ ਮਹੱਤਵ ਹੈ',
            'stat_4_strong' => 'ਤੁਸੀਂ♡',
            'stat_4_small' => 'ਸਾਡੇ ਧਿਆਨ ਦੇ ਕੇਂਦਰ ਵਿੱਚ',
            'stories_eyebrow' => 'ਦਿਲੋਂ ਨਿੱਘੇ ਸ਼ਬਦ',
            'stories_heading' => 'ਪਰਿਵਾਰ ਫ਼ਰਕ ਮਹਿਸੂਸ ਕਰਦੇ ਹਨ।',
            'stories_sub' => 'ਹਰ ਪਰਿਵਾਰ ਦੀ ਆਪਣੀ ਕਹਾਣੀ ਹੁੰਦੀ ਹੈ। ਇਹ ਕੁਝ ਕਹਾਣੀਆਂ ਹਨ ਜਿਨ੍ਹਾਂ ਦਾ ਹਿੱਸਾ ਬਣਨ \'ਤੇ ਸਾਨੂੰ ਮਾਣ ਹੈ।',
            'caregivers_eyebrow' => 'ਸ਼ਾਨਦਾਰ ਲੋਕ, ਸ਼ਾਨਦਾਰ ਦੇਖਭਾਲ',
            'caregivers_heading' => 'ਸਾਡੇ ਕੁਝ ਕੇਅਰਗਿਵਰਾਂ ਨੂੰ ਮਿਲੋ।',
            'caregivers_sub' => 'ਹਰੇਕ ਦੇਖਭਾਲਕਰਤਾ ਨੂੰ ਉਨ੍ਹਾਂ ਦੀ ਹਮਦਰਦੀ, ਹੁਨਰ ਅਤੇ ਸਮਰਪਣ ਲਈ ਚੁਣਿਆ ਜਾਂਦਾ ਹੈ।',
            'locations_eyebrow' => 'ਘਰ ਦੇ ਨੇੜੇ',
            'locations_heading' => 'ਤੁਹਾਡੇ ਨੇੜੇ ਹੀ ਦੇਖਭਾਲ।',
            'locations_sub' => 'ਸਾਡੀਆਂ ਸਥਾਨਕ ਟੀਮਾਂ ਆਪਣੇ ਭਾਈਚਾਰੇ ਨੂੰ ਜਾਣਦੀਆਂ ਹਨ ਅਤੇ ਤੁਹਾਡੇ ਪਰਿਵਾਰ ਨੂੰ ਨੇੜੇ ਦੇਖਭਾਲ ਲੱਭਣ ਵਿੱਚ ਮਦਦ ਕਰਨ ਲਈ ਤਿਆਰ ਹਨ।',
            'all_states' => 'ਸਾਰੇ ਰਾਜ',
            'search_city_zip' => 'ਸ਼ਹਿਰ ਜਾਂ ਜ਼ਿਪ ਕੋਡ ਖੋਜੋ',
            'search' => 'ਖੋਜੋ',
            'coming_soon' => 'ਜਲਦੀ ਆ ਰਿਹਾ ਹੈ',
            'preparing_arizona' => 'ਅਸੀਂ ਐਰੀਜ਼ੋਨਾ ਵਿੱਚ ਪਰਿਵਾਰਾਂ ਦੀ ਸੇਵਾ ਕਰਨ ਦੀ ਤਿਆਰੀ ਕਰ ਰਹੇ ਹਾਂ।',
            'no_office' => 'ਇਸ ਖੋਜ ਨਾਲ ਕੋਈ ਦਫ਼ਤਰ ਨਹੀਂ ਮਿਲਿਆ।',
            'contact_area' => 'ਆਪਣੇ ਖੇਤਰ ਬਾਰੇ ਸਾਡੇ ਨਾਲ ਸੰਪਰਕ ਕਰੋ।',
            'local_care' => 'ਸਥਾਨਕ ਦੇਖਭਾਲ',
            'near_home' => 'ਘਰ ਦੇ ਨੇੜੇ',
            'here_for_you' => 'ਤੁਹਾਡੇ ਲਈ ਇੱਥੇ ਹਾਂ',
            'map_strong' => 'ਸਥਾਨਕ ਦੇਖਭਾਲ। ਖੁਸ਼ਹਾਲ ਘਰ।',
            'map_small' => 'ਤੁਹਾਡੇ ਪਰਿਵਾਰ ਲਈ, ਜਿੱਥੇ ਵੀ ਤੁਹਾਡਾ ਘਰ ਹੈ।',
            'resources_eyebrow' => 'ਜਾਣਕਾਰੀ ਮਦਦਗਾਰ ਹੁੰਦੀ ਹੈ',
            'resources_heading' => 'ਤੁਹਾਡੇ ਸਫ਼ਰ ਲਈ ਮਦਦਗਾਰ ਲੇਖ।',
            'resources_sub' => 'ਤੁਹਾਡੇ ਪਿਆਰੇ ਦੀ ਦੇਖਭਾਲ ਦੇ ਹਰ ਕਦਮ ਲਈ ਸਪਸ਼ਟ ਅਤੇ ਹਮਦਰਦੀ ਭਰਪੂਰ ਮਾਰਗਦਰਸ਼ਨ।',
            'read_more' => 'ਹੋਰ ਪੜ੍ਹੋ',
            'careers_eyebrow' => 'ਹਰ ਰੋਜ਼ ਇੱਕ ਬਦਲਾਅ ਲਿਆਓ',
            'careers_heading' => 'ਆਪਣੇ ਦੇਖਭਾਲ ਕਰਨ ਵਾਲੇ ਦਿਲ ਨੂੰ ਕੰਮ \'ਤੇ ਲਗਾਓ।',
            'careers_sub' => 'ਇੱਕ ਅਜਿਹੀ ਟੀਮ ਵਿੱਚ ਸ਼ਾਮਲ ਹੋਵੋ ਜੋ ਹਰ ਦੇਖਭਾਲ ਯੋਜਨਾ ਪਿੱਛੇ ਇਨਸਾਨ ਨੂੰ ਵੇਖਦੀ ਹੈ। ਅਰਥਪੂਰਨ ਕੰਮ ਕਰੋ ਅਤੇ ਸਹਾਇਤਾ ਪ੍ਰਾਪਤ ਕਰੋ।',
            'perk_1' => 'ਲਚਕਦਾਰ ਸਮਾਂ-ਸੂਚੀ',
            'perk_2' => 'ਵਧੀਆ ਤਨਖਾਹ ਅਤੇ ਲਾਭ',
            'perk_3' => 'ਮੁਫ਼ਤ ਸਿਖਲਾਈ ਅਤੇ ਤਰੱਕੀ',
            'start_app' => 'ਆਪਣੀ ਅਰਜ਼ੀ ਸ਼ੁਰੂ ਕਰੋ',
            'start_app_sub' => 'ਸਾਨੂੰ ਆਪਣੇ ਬਾਰੇ ਥੋੜ੍ਹਾ ਦੱਸੋ। ਇਸ ਵਿੱਚ ਸਿਰਫ਼ ਕੁਝ ਪਲ ਲੱਗਦੇ ਹਨ।',
            'interested_in' => 'ਮੇਰੀ ਦਿਲਚਸਪੀ ਹੈ',
            'choose_role' => 'ਇੱਕ ਭੂਮਿਕਾ ਚੁਣੋ',
            'apply_btn' => 'ਸਾਡੀ ਟੀਮ ਵਿੱਚ ਸ਼ਾਮਲ ਹੋਵੋ',
            'info_private' => 'ਅਸੀਂ ਜਲਦੀ ਸੰਪਰਕ ਕਰਾਂਗੇ। ਤੁਹਾਡੀ ਜਾਣਕਾਰੀ ਨਿੱਜੀ ਰਹਿੰਦੀ ਹੈ।',
            'faq_eyebrow' => 'ਜ਼ਰੂਰੀ ਸਵਾਲ',
            'faq_heading' => 'ਜਦੋਂ ਵੀ ਤੁਹਾਡੇ ਮਨ ਵਿੱਚ ਸਵਾਲ ਹੋਵੇ।',
            'faq_sub' => 'ਕੀ ਅਜੇ ਵੀ ਸਭ ਕੁਝ ਸਮਝਣ ਦੀ ਕੋਸ਼ਿਸ਼ ਕਰ ਰਹੇ ਹੋ? ਕੋਈ ਗੱਲ ਨਹੀਂ। ਅਸੀਂ ਹਮੇਸ਼ਾ ਗੱਲਬਾਤ ਲਈ ਤਿਆਰ ਹਾਂ।',
            'talk_specialist' => 'ਦੇਖਭਾਲ ਮਾਹਿਰ ਨਾਲ ਗੱਲ ਕਰੋ',
            'cta_eyebrow' => 'ਇੱਕ ਖੁਸ਼ਹਾਲ ਘਰ ਇੱਥੋਂ ਸ਼ੁਰੂ ਹੁੰਦਾ ਹੈ',
            'cta_heading' => 'ਆਓ ਘਰ ਨੂੰ ਫਿਰ ਤੋਂ ਸੁਖਾਵਾਂ ਬਣਾਈਏ।',
            'cta_sub' => 'ਇੱਕ ਮੁਫ਼ਤ ਅਤੇ ਬਿਨਾਂ ਦਬਾਅ ਵਾਲੀ ਗੱਲਬਾਤ ਨਾਲ ਸ਼ੁਰੂਆਤ ਕਰੋ। ਸਾਡੀ ਟੀਮ ਦਿਨ-ਰਾਤ ਤੁਹਾਡੇ ਲਈ ਮੌਜੂਦ ਹੈ।',
            'request_free_assess' => 'ਮੁਫ਼ਤ ਮੁਲਾਂਕਣ ਦੀ ਬੇਨਤੀ ਕਰੋ',
            'or_call' => 'ਜਾਂ ਸਾਨੂੰ ਕਾਲ ਕਰੋ:',
            'contact_eyebrow' => 'ਆਓ ਦੇਖਭਾਲ ਬਾਰੇ ਗੱਲ ਕਰੀਏ',
            'contact_heading' => 'ਤੁਹਾਡੇ ਪਰਿਵਾਰ ਲਈ ਅਸੀਂ ਹਾਜ਼ਰ ਹਾਂ।',
            'contact_sub' => 'ਦੱਸੋ ਤੁਹਾਨੂੰ ਕੀ ਚਾਹੀਦਾ ਹੈ। ਕੰਮ ਦੇ ਘੰਟਿਆਂ ਦੌਰਾਨ ਦੋ ਘੰਟਿਆਂ ਦੇ ਅੰਦਰ ਇੱਕ ਕੇਅਰ ਸਪੈਸ਼ਲਿਸਟ ਤੁਹਾਡੇ ਨਾਲ ਸੰਪਰਕ ਕਰੇਗਾ।',
            'call_247' => '24/7 ਕਾਲ ਕਰੋ',
            'email_team' => 'ਸਾਡੀ ਟੀਮ ਨੂੰ ਈਮੇਲ ਕਰੋ',
            'emergency_note' => 'ਕੀ ਅੱਜ ਦੇਖਭਾਲ ਦੀ ਲੋੜ ਹੈ? ਤੁਰੰਤ ਮਦਦ ਲਈ ਸਾਨੂੰ ਕਾਲ ਕਰੋ।',
            'assessment' => 'ਮੁਫ਼ਤ ਮੁਲਾਂਕਣ ਦੀ ਬੇਨਤੀ',
            'no_obligation' => 'ਕੋਈ ਜ਼ਿੰਮੇਵਾਰੀ ਨਹੀਂ। ਸਿਰਫ਼ ਇੱਕ ਦੋਸਤਾਨਾ ਗੱਲਬਾਤ।',
            'care_type' => 'ਦੇਖਭਾਲ ਦੀ ਕਿਸਮ',
            'select_need' => 'ਆਪਣੀ ਲੋੜ ਚੁਣੋ',
            'not_sure_yet' => 'ਅਜੇ ਯਕੀਨ ਨਹੀਂ ਹੈ',
            'zip_code' => 'ਜ਼ਿਪ ਕੋਡ',
            'details' => 'ਕੀ ਤੁਸੀਂ ਹੋਰ ਕੁਝ ਦੱਸਣਾ ਚਾਹੋਗੇ?',
            'details_placeholder' => 'ਸਾਨੂੰ ਆਪਣੀ ਸਥਿਤੀ ਬਾਰੇ ਥੋੜ੍ਹਾ ਦੱਸੋ (ਵਿਕਲਪਿਕ)',
            'send_request' => 'ਮੁਫ਼ਤ ਮੁਲਾਂਕਣ ਦੀ ਬੇਨਤੀ ਕਰੋ',
            'secure_note' => 'ਤੁਹਾਡੀ ਜਾਣਕਾਰੀ ਫਾਲੋ-ਅਪ ਲਈ ਸੁਰੱਖਿਅਤ ਰੱਖੀ ਜਾਂਦੀ ਹੈ।',
            'accreditations' => 'ACHC ਮਾਨਤਾ ਪ੍ਰਾਪਤ',
            'licensed_bonded' => 'ਲਾਇਸੰਸਸ਼ੁਦਾ ਅਤੇ ਬਾਂਡੇਡ',
            'family_stories' => 'ਪਰਿਵਾਰਕ ਕਹਾਣੀਆਂ',
            'join_team' => 'ਸਾਡੀ ਟੀਮ ਨਾਲ ਜੁੜੋ',
            'here_to_help' => 'ਮਦਦ ਲਈ ਇੱਥੇ ਹਾਂ',
            'all_rights' => 'ਸਾਰੇ ਅਧਿਕਾਰ ਰਾਖਵੇਂ ਹਨ।',
            'back_to_top' => 'ਸਿਖਰ \'ਤੇ ਵਾਪਸ ਜਾਓ ↑',
        ],
        'hi' => [
            'brand_name' => 'हैप्पी होम केयर',
            'elevated_care' => 'बेहतर देखभाल। आपके अपने घर पर।',
            'about' => 'हमारे बारे में',
            'resources' => 'संसाधन',
            'services' => 'सेवाएँ',
            'locations' => 'स्थान',
            'login' => 'लॉग इन',
            'signup' => 'साइन अप',
            'call' => 'कॉल करें',
            'request_care' => 'देखभाल का अनुरोध करें',
            'contact' => 'संपर्क',
            'care_services' => 'देखभाल सेवाएँ',
            'find_location' => 'स्थान खोजें',
            'first_name' => 'पहला नाम',
            'last_name' => 'अंतिम नाम',
            'phone' => 'फ़ोन नंबर',
            'email' => 'ईमेल पता',
            'password' => 'पासवर्ड',
            'confirm_password' => 'पासवर्ड की पुष्टि करें',
            'sign_in' => 'साइन इन',
            'create_account' => 'खाता बनाएँ',
            'admin_login' => 'प्रशासक लॉग इन',
            'google_signin' => 'Google से जारी रखें',
            'facebook_signin' => 'Facebook से जारी रखें',
            'or_email' => 'या ईमेल से',
            'logout' => 'लॉग आउट',
            'language' => 'भाषा चुनें',
            'hero_eyebrow' => 'देखभाल के हर कदम पर आपके साथ',
            'hero_first' => 'घर जैसा महसूस हो ऐसी देखभाल',
            'hero_second' => 'आपके अपने घर में।',
            'hero_intro' => 'बुजुर्गों और वयस्कों के लिए आत्मीय, पेशेवर घरेलू देखभाल। हम घर पर सुरक्षित, सहज और खुशहाल रहना आसान बनाते हैं।',
            'search_care' => 'देखभाल खोजें',
            'explore_services' => 'सेवाएँ देखें',
            'zip_placeholder' => 'अपना पिन कोड या शहर दर्ज करें',
            'free_assessment' => 'निःशुल्क मूल्यांकन प्राप्त करें',
            'care_shaped_family' => 'आपके परिवार के अनुसार देखभाल',
            'help_close_home' => 'घर के पास व्यक्तिगत सहायता',
            'care_your_way' => 'देखभाल, आपके तरीके से',
            'made_around_family' => 'आपके परिवार के अनुकूल',
            'help_feels_home' => 'घर जैसा सुकून देने वाली मदद',
            'people_first_support' => 'इंसानियत को प्राथमिकता देने वाली सहायता',
            'thoughtful_matching' => 'विचारशील देखभालकर्ता मिलान',
            'support_family_caregivers' => 'पारिवारिक देखभालकर्ताओं के लिए सहायता',
            'personalized_plans' => 'व्यक्तिगत देखभाल योजनाएँ',
            'care_close_home' => 'घर के पास देखभाल',
            'process_eyebrow' => 'एक छोटी सी मदद बहुत बड़ा सहारा बनती है',
            'process_heading' => 'शुरुआत करना बेहद आसान है।',
            'process_sub' => 'पहली बातचीत से लेकर आपके प्रियजन की पहली मुलाकात तक, हम हर कदम पर आपके साथ हैं।',
            'step_1_title' => 'सही सेवा चुनें',
            'step_1_desc' => 'उचित सहायता खोजने के लिए हमारी देखभाल सेवाओं को देखें।',
            'step_2_title' => 'अपनी देखभाल टीम से मिलें',
            'step_2_desc' => 'एक संवेदनशील विशेषज्ञ आपकी बात सुनता है, मिलता है और आपकी ज़रूरतों को समझता है।',
            'step_3_title' => 'एक योजना बनाएँ',
            'step_3_desc' => 'मिलकर, हम आपके प्रियजन की दिनचर्या और ज़रूरतों के अनुसार एक योजना तैयार करते हैं।',
            'step_4_title' => 'घर जैसा महसूस करें',
            'step_4_desc' => 'आपका उपयुक्त देखभालकर्ता पहुँचता है, और हमारी टीम निरंतर आपके साथ रहती है।',
            'services_eyebrow' => 'हर मौसम में सहारा',
            'services_heading' => 'आपकी ज़रूरत के अनुसार देखभाल।',
            'services_sub' => 'दैनिक कार्यों में मदद से लेकर विशेष देखभाल तक, हम घर को घर बनाए रखने के लिए यहाँ हैं।',
            'explore_care' => 'देखभाल जानें',
            'see_how_help' => 'देखें हम कैसे मदद कर सकते हैं',
            'about_eyebrow' => 'हैप्पी होम केयर के बारे में',
            'who_are_we' => 'हम कौन हैं?',
            'mission_q' => 'हमारा मिशन क्या है?',
            'vision_q' => 'हमारा दृष्टिकोण क्या है?',
            'values_eyebrow' => 'जो हमें राह दिखाता है',
            'core_values' => 'मूल सिद्धांत',
            'core_team_eyebrow' => 'आपके साथ',
            'core_team' => 'मुख्य टीम',
            'core_team_desc' => 'हमारी टीम परिवारों को सम्मान, समझ और व्यक्तिगत अपनेपन के साथ देखभाल प्रदान करने के लिए समर्पित है।',
            'meet_team_btn' => 'हमारी देखभाल टीम से मिलें',
            'stat_1_strong' => 'एक-एक+',
            'stat_1_small' => 'परिवार की सेवा',
            'stat_2_strong' => 'देखभाल+',
            'stat_2_small' => 'सहानुभूति के साथ',
            'stat_3_strong' => 'घर पर+',
            'stat_3_small' => 'जहाँ सबसे ज़्यादा सुकून है',
            'stat_4_strong' => 'आप♡',
            'stat_4_small' => 'हमारी प्राथमिकता के केंद्र में',
            'stories_eyebrow' => 'दिलों से निकले शब्द',
            'stories_heading' => 'परिवार फ़र्क महसूस करते हैं।',
            'stories_sub' => 'हर परिवार की अपनी कहानी होती है। ये कुछ कहानियाँ हैं जिनका हिस्सा बनने पर हमें गर्व है।',
            'caregivers_eyebrow' => 'अद्भुत लोग, अद्भुत देखभाल',
            'caregivers_heading' => 'हमारे देखभालकर्ताओं से मिलें।',
            'caregivers_sub' => 'प्रत्येक देखभालकर्ता को उनकी करुणा, कौशल और समर्पण के आधार पर चुना जाता है।',
            'locations_eyebrow' => 'घर के पास',
            'locations_heading' => 'आपके पास ही देखभाल।',
            'locations_sub' => 'हमारी स्थानीय टीमें अपने समुदाय को जानती हैं और आपके परिवार को नज़दीकी देखभाल खोजने में मदद करती हैं।',
            'all_states' => 'सभी राज्य',
            'search_city_zip' => 'शहर या पिन कोड खोजें',
            'search' => 'खोजें',
            'coming_soon' => 'शीघ्र आ रहा है',
            'preparing_arizona' => 'हम एरिज़ोना में परिवारों की सेवा करने की तैयारी कर रहे हैं।',
            'no_office' => 'इस खोज से कोई कार्यालय नहीं मिला।',
            'contact_area' => 'अपने क्षेत्र के बारे में हमसे संपर्क करें।',
            'local_care' => 'स्थानीय देखभाल',
            'near_home' => 'घर के पास',
            'here_for_you' => 'आपके लिए यहाँ हैं',
            'map_strong' => 'स्थानीय देखभाल। खुशहाल घर।',
            'map_small' => 'आपके परिवार के लिए, जहाँ भी आपका घर हो।',
            'resources_eyebrow' => 'जानकारी से मदद मिलती है',
            'resources_heading' => 'आपकी यात्रा के लिए उपयोगी लेख।',
            'resources_sub' => 'अपने प्रियजन की देखभाल के हर चरण के लिए स्पष्ट और संवेदनशील मार्गदर्शन।',
            'read_more' => 'और पढ़ें',
            'careers_eyebrow' => 'हर दिन एक बदलाव लाएँ',
            'careers_heading' => 'अपने देखभाल करने वाले दिल को काम पर लगाएँ।',
            'careers_sub' => 'एक ऐसी टीम से जुड़ें जो हर देखभाल योजना के पीछे इंसान को देखती है। सार्थक काम करें और पूरा सहयोग पाएँ।',
            'perk_1' => 'लचीला समय',
            'perk_2' => 'उत्कृष्ट वेतन और लाभ',
            'perk_3' => 'मुफ़्त प्रशिक्षण और विकास',
            'start_app' => 'अपना आवेदन शुरू करें',
            'start_app_sub' => 'हमें अपने बारे में थोड़ा बताएँ। इसमें केवल कुछ पल लगते हैं।',
            'interested_in' => 'मेरी रुचि है',
            'choose_role' => 'एक भूमिका चुनें',
            'apply_btn' => 'हमारी टीम में शामिल हों',
            'info_private' => 'हम जल्द ही संपर्क करेंगे। आपकी जानकारी सुरक्षित रहती है।',
            'faq_eyebrow' => 'ज़रूरी सवाल',
            'faq_heading' => 'जब भी आपके मन में सवाल हो।',
            'faq_sub' => 'क्या अभी भी सब समझने की कोशिश कर रहे हैं? कोई बात नहीं। हम हमेशा बात करने के लिए तैयार हैं।',
            'talk_specialist' => 'देखभाल विशेषज्ञ से बात करें',
            'cta_eyebrow' => 'एक खुशहाल घर यहाँ से शुरू होता है',
            'cta_heading' => 'आइए घर को फिर से सुखद बनाएँ।',
            'cta_sub' => 'एक निःशुल्क और तनावमुक्त बातचीत से शुरुआत करें। हमारी टीम दिन-रात आपके लिए उपलब्ध है।',
            'request_free_assess' => 'निःशुल्क मूल्यांकन का अनुरोध करें',
            'or_call' => 'या हमें कॉल करें:',
            'contact_eyebrow' => 'आइए देखभाल के बारे में बात करें',
            'contact_heading' => 'आपके परिवार के लिए हम उपस्थित हैं।',
            'contact_sub' => 'बताएँ आपको किस चीज़ की ज़रूरत है। कार्य समय के दौरान दो घंटे के भीतर देखभाल विशेषज्ञ संपर्क करेगा।',
            'call_247' => '24/7 कॉल करें',
            'email_team' => 'हमारी टीम को ईमेल करें',
            'emergency_note' => 'क्या आज ही देखभाल चाहिए? तत्काल सहायता के लिए कॉल करें।',
            'assessment' => 'निःशुल्क मूल्यांकन का अनुरोध',
            'no_obligation' => 'कोई दायित्व नहीं। बस एक आत्मीय बातचीत।',
            'care_type' => 'देखभाल का प्रकार',
            'select_need' => 'अपनी ज़रूरत चुनें',
            'not_sure_yet' => 'अभी सुनिश्चित नहीं',
            'zip_code' => 'पिन कोड',
            'details' => 'क्या कुछ और बताना चाहते हैं?',
            'details_placeholder' => 'हमें अपनी स्थिति के बारे में थोड़ा बताएँ (वैकल्पिक)',
            'send_request' => 'निःशुल्क मूल्यांकन का अनुरोध करें',
            'secure_note' => 'आपकी जानकारी सुरक्षित रखी जाती है।',
            'accreditations' => 'ACHC मान्यता प्राप्त',
            'licensed_bonded' => 'लाइसेंस प्राप्त और बीमित',
            'family_stories' => 'पारिवारिक कहानियाँ',
            'join_team' => 'हमारी टीम से जुड़ें',
            'here_to_help' => 'मदद के लिए तैयार',
            'all_rights' => 'सर्वाधिकार सुरक्षित।',
            'back_to_top' => 'शीर्ष पर जाएँ ↑',
        ],
        'es' => [
            'brand_name' => 'HAPPY HOME CARE',
            'elevated_care' => 'Atención Superior. En Su Hogar.',
            'about' => 'Sobre nosotros',
            'resources' => 'Recursos',
            'services' => 'Servicios',
            'locations' => 'Ubicaciones',
            'login' => 'Iniciar sesión',
            'signup' => 'Registrarse',
            'call' => 'Llamar',
            'request_care' => 'Solicitar atención',
            'contact' => 'Contacto',
            'care_services' => 'Servicios de atención',
            'find_location' => 'Buscar ubicación',
            'first_name' => 'Nombre',
            'last_name' => 'Apellido',
            'phone' => 'Número de teléfono',
            'email' => 'Correo electrónico',
            'password' => 'Contraseña',
            'confirm_password' => 'Confirmar contraseña',
            'sign_in' => 'Iniciar sesión',
            'create_account' => 'Crear cuenta',
            'admin_login' => 'Acceso de administrador',
            'google_signin' => 'Continuar con Google',
            'facebook_signin' => 'Continuar con Facebook',
            'or_email' => 'o continuar con correo',
            'logout' => 'Cerrar sesión',
            'language' => 'Elegir idioma',
            'hero_eyebrow' => 'Aquí en cada paso del camino de atención',
            'hero_first' => 'Cuidado que se siente',
            'hero_second' => 'como en casa.',
            'hero_intro' => 'Atención compasiva y profesional en el hogar para personas mayores y adultos. Facilitamos vivir de manera segura, cómoda y feliz en casa.',
            'search_care' => 'Buscar atención',
            'explore_services' => 'Explorar servicios',
            'zip_placeholder' => 'Ingrese su código postal o ciudad',
            'free_assessment' => 'Obtener una evaluación gratuita',
            'care_shaped_family' => 'Cuidado diseñado para su familia',
            'help_close_home' => 'Ayuda personalizada cerca de casa',
            'care_your_way' => 'Cuidado a su manera',
            'made_around_family' => 'Diseñado para su familia',
            'help_feels_home' => 'Ayuda que se siente como en casa',
            'people_first_support' => 'Apoyo centrado en las personas',
            'thoughtful_matching' => 'Asignación cuidadosa de cuidadores',
            'support_family_caregivers' => 'Apoyo a cuidadores familiares',
            'personalized_plans' => 'Planes de atención personalizados',
            'care_close_home' => 'Cuidado cerca de casa',
            'process_eyebrow' => 'Una pequeña ayuda marca una gran diferencia',
            'process_heading' => 'Comenzar es muy sencillo.',
            'process_sub' => 'Desde la primera conversación hasta la primera visita de su ser querido, estamos a su lado.',
            'step_1_title' => 'Encuentre su opción',
            'step_1_desc' => 'Explore nuestros servicios de atención para encontrar el apoyo adecuado.',
            'step_2_title' => 'Conozca a su equipo de atención',
            'step_2_desc' => 'Un especialista amable escucha, visita y comprende lo que más le importa a su familia.',
            'step_3_title' => 'Diseñe un plan',
            'step_3_desc' => 'Juntos creamos un plan personalizado según las necesidades y rutina de su ser querido.',
            'step_4_title' => 'Siéntase como en casa',
            'step_4_desc' => 'Su cuidador asignado llega, y nuestro equipo permanece atento en todo momento.',
            'services_eyebrow' => 'Apoyo para cada etapa',
            'services_heading' => 'Atención que se adapta a su vida.',
            'services_sub' => 'Desde una mano amiga en el día a día hasta atención especializada, estamos aquí para que su hogar siga siendo su hogar.',
            'explore_care' => 'Explorar atención',
            'see_how_help' => 'Vea cómo podemos ayudar',
            'about_eyebrow' => 'Sobre Happy Home Care',
            'who_are_we' => '¿Quiénes somos?',
            'mission_q' => '¿Cuál es nuestra misión?',
            'vision_q' => '¿Cuál es nuestra visión?',
            'values_eyebrow' => 'Lo que nos guía',
            'core_values' => 'Valores fundamentales',
            'core_team_eyebrow' => 'A su lado',
            'core_team' => 'Equipo Principal',
            'core_team_desc' => 'Nuestro equipo está aquí para ayudar a las familias con dignidad, comprensión y un toque personal.',
            'meet_team_btn' => 'Conozca a nuestro equipo de atención',
            'stat_1_strong' => 'Uno+',
            'stat_1_small' => 'familia a la vez',
            'stat_2_strong' => 'Cuidado+',
            'stat_2_small' => 'con compasión',
            'stat_3_strong' => 'En+',
            'stat_3_small' => 'el hogar, donde más importa',
            'stat_4_strong' => 'Usted♡',
            'stat_4_small' => 'en el centro de la atención',
            'stories_eyebrow' => 'Palabras sinceras, desde el corazón',
            'stories_heading' => 'Las familias sienten la diferencia.',
            'stories_sub' => 'Cada familia tiene su propia historia. Estas son algunas de las que nos honra formar parte.',
            'caregivers_eyebrow' => 'Personas maravillosas, atención excepcional',
            'caregivers_heading' => 'Conozca a algunos de nuestros cuidadores.',
            'caregivers_sub' => 'Cada cuidador es seleccionado rigurosamente por su compasión, habilidad y dedicación.',
            'locations_eyebrow' => 'Cerca del hogar',
            'locations_heading' => 'Atención a la vuelta de la esquina.',
            'locations_sub' => 'Nuestros equipos locales conocen sus comunidades y están listos para ayudarle a encontrar atención cercana.',
            'all_states' => 'Todos los estados',
            'search_city_zip' => 'Buscar ciudad o código postal',
            'search' => 'Buscar',
            'coming_soon' => 'Próximamente',
            'preparing_arizona' => 'Nos estamos preparando para atender a familias en Arizona.',
            'no_office' => 'Ninguna oficina coincide con esa búsqueda.',
            'contact_area' => 'Contáctenos sobre su zona.',
            'local_care' => 'Cuidado local',
            'near_home' => 'Cerca de casa',
            'here_for_you' => 'Aquí para usted',
            'map_strong' => 'Atención local. Hogares felices.',
            'map_small' => 'Para su familia, dondequiera que esté su hogar.',
            'resources_eyebrow' => 'El conocimiento ayuda',
            'resources_heading' => 'Lecturas útiles para su camino.',
            'resources_sub' => 'Orientación clara y compasiva para cada etapa del cuidado de un ser querido.',
            'read_more' => 'Leer más',
            'careers_eyebrow' => 'Marque la diferencia cada día',
            'careers_heading' => 'Ponga su corazón bondadoso a trabajar.',
            'careers_sub' => 'Únase a un equipo que ve a la persona detrás de cada plan de atención. Realice un trabajo significativo con apoyo continuo.',
            'perk_1' => 'Horarios flexibles',
            'perk_2' => 'Excelente salario y beneficios',
            'perk_3' => 'Capacitación gratuita y crecimiento',
            'start_app' => 'Comenzar su solicitud',
            'start_app_sub' => 'Cuéntenos un poco sobre usted. Solo toma un momento.',
            'interested_in' => 'Me interesa',
            'choose_role' => 'Elija un puesto',
            'apply_btn' => 'Postularse a nuestro equipo',
            'info_private' => 'Nos pondremos en contacto pronto. Su información permanece privada.',
            'faq_eyebrow' => 'Preguntas frecuentes',
            'faq_heading' => 'Aquí cuando tenga dudas.',
            'faq_sub' => '¿Aún lo está pensando? No se preocupe. Con gusto conversamos con usted.',
            'talk_specialist' => 'Hable con un especialista en atención',
            'cta_eyebrow' => 'Un hogar más feliz comienza aquí',
            'cta_heading' => 'Hagamos que el hogar se sienta acogedor de nuevo.',
            'cta_sub' => 'Comience con una consulta gratuita y sin compromiso. Nuestro equipo está a su servicio día y noche.',
            'request_free_assess' => 'Solicitar evaluación gratuita',
            'or_call' => 'O llámenos:',
            'contact_eyebrow' => 'Hablemos de atención',
            'contact_heading' => 'Aquí para su familia, ahora mismo.',
            'contact_sub' => 'Comparta lo que necesita. Un especialista se comunicará en un plazo de dos horas en horario laboral.',
            'call_247' => 'LLÁMENOS 24/7',
            'email_team' => 'ESCRIBA A NUESTRO EQUIPO',
            'emergency_note' => '¿Necesita atención hoy? Llámenos para asistencia urgente.',
            'assessment' => 'Solicitar evaluación gratuita',
            'no_obligation' => 'Sin compromiso alguno. Solo una conversación cordial.',
            'care_type' => 'Tipo de atención',
            'select_need' => 'Seleccione lo que necesita',
            'not_sure_yet' => 'Aún no estoy seguro',
            'zip_code' => 'Código postal',
            'details' => '¿Algo más que debamos saber?',
            'details_placeholder' => 'Cuéntenos un poco sobre su situación (opcional)',
            'send_request' => 'Solicitar mi evaluación gratuita',
            'secure_note' => 'Su información se guarda de forma segura.',
            'accreditations' => 'Acreditado por ACHC',
            'licensed_bonded' => 'Con licencia y fianza',
            'family_stories' => 'Historias familiares',
            'join_team' => 'Únase a nuestro equipo',
            'here_to_help' => 'Aquí para ayudar',
            'all_rights' => 'Todos los derechos reservados.',
            'back_to_top' => 'Volver arriba ↑',
        ],
    ];
    $lang = current_language();
    return $messages[$lang][$key] ?? ($messages['en'][$key] ?? $key);
}
}

if (!function_exists('dynamic_translate')) {
function dynamic_translate(string $text, string $target): string {
    $clean = trim($text);
    if ($clean === '' || $target === 'en' || !in_array($target, ['es', 'pa', 'hi'], true)) {
        return $text;
    }

    // Guard: Never translate brand names or slogans
    $noTranslate = [
        'happy home care',
        'elevated care. right at home.',
        'elevated care. right at home'
    ];
    if (in_array(mb_strtolower($clean, 'UTF-8'), $noTranslate, true)) {
        return $text;
    }

    static $memCache = [];
    $cacheKey = $target . ':' . md5($clean);
    if (isset($memCache[$cacheKey])) {
        return $memCache[$cacheKey];
    }

    $root = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__);
    $cacheFile = $root . '/database/translations_cache.json';
    static $diskCache = null;
    if ($diskCache === null) {
        $diskCache = [];
        if (file_exists($cacheFile)) {
            $raw = @file_get_contents($cacheFile);
            if ($raw) {
                $decoded = json_decode($raw, true);
                if (is_array($decoded)) {
                    $diskCache = $decoded;
                }
            }
        }
    }

    if (isset($diskCache[$cacheKey]) && is_string($diskCache[$cacheKey]) && $diskCache[$cacheKey] !== '') {
        $memCache[$cacheKey] = $diskCache[$cacheKey];
        return $diskCache[$cacheKey];
    }

    $translated = null;

    // 1. Primary: Google Translate clients5 API (fast, reliable, unblocked)
    $c5Url = 'https://clients5.google.com/translate_a/t?client=dict-chrome-ex&sl=en&tl=' . rawurlencode($target) . '&q=' . rawurlencode($clean);
    $response = false;
    if (function_exists('curl_init')) {
        $ch = curl_init($c5Url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 3,
            CURLOPT_CONNECTTIMEOUT => 2,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($code < 200 || $code >= 400) {
            $response = false;
        }
    }
    if ($response === false) {
        $ctx = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n",
                'timeout' => 3,
                'ignore_errors' => true,
            ]
        ]);
        $response = @file_get_contents($c5Url, false, $ctx);
    }
    if ($response !== false) {
        $data = json_decode((string)$response, true);
        if (is_array($data) && isset($data[0]) && is_string($data[0]) && trim($data[0]) !== '') {
            $translated = trim($data[0]);
        }
    }

    // 2. Secondary fallback: MyMemory Translation API
    if ($translated === null || trim($translated) === '') {
        $myMemoryUrl = 'https://api.mymemory.translated.net/get?q=' . rawurlencode($clean) . '&langpair=en|' . rawurlencode($target) . '&de=admin@happyhomecare.com';
        $resp2 = false;
        if (function_exists('curl_init')) {
            $ch = curl_init($myMemoryUrl);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 4,
                CURLOPT_CONNECTTIMEOUT => 2,
                CURLOPT_USERAGENT => 'Mozilla/5.0',
                CURLOPT_SSL_VERIFYPEER => false,
            ]);
            $resp2 = curl_exec($ch);
            curl_close($ch);
        }
        if ($resp2 === false) {
            $resp2 = @file_get_contents($myMemoryUrl);
        }
        if ($resp2 !== false) {
            $data2 = json_decode((string)$resp2, true);
            if (isset($data2['responseData']['translatedText']) && is_string($data2['responseData']['translatedText'])) {
                $txt = trim($data2['responseData']['translatedText']);
                if ($txt !== '' && stripos($txt, 'MYMEMORY WARNING') === false) {
                    $translated = html_entity_decode($txt, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                }
            }
        }
    }

    if ($translated !== null && trim($translated) !== '') {
        $memCache[$cacheKey] = $translated;
        $diskCache[$cacheKey] = $translated;
        @file_put_contents($cacheFile, json_encode($diskCache, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), LOCK_EX);
        return $translated;
    }

    return $text;
}
}

if (!function_exists('tr_service_title')) {
function tr_service_title(string $title): string {
    $lang = current_language();
    if ($lang === 'en') return $title;
    $map = [
        'Personal care' => [
            'pa' => 'ਨਿੱਜੀ ਦੇਖਭਾਲ',
            'hi' => 'व्यक्तिगत देखभाल',
            'es' => 'Cuidado personal',
        ],
        'Companion care' => [
            'pa' => 'ਸਾਥੀ ਦੇਖਭਾਲ',
            'hi' => 'साथी देखभाल',
            'es' => 'Cuidado de compañía',
        ],
        'Memory care' => [
            'pa' => 'ਯਾਦਦਾਸ਼ਤ ਦੇਖਭਾਲ',
            'hi' => 'स्मृति देखभाल',
            'es' => 'Cuidado de la memoria',
        ],
        'Respite care' => [
            'pa' => 'ਰਿਸਪਾਈਟ (ਆਰਾਮ) ਦੇਖਭਾਲ',
            'hi' => 'रेस्पाइट (विश्राम) देखभाल',
            'es' => 'Cuidado de relevo',
        ],
        'Recovery at home' => [
            'pa' => 'ਘਰ ਵਿੱਚ ਸਿਹਤਯਾਬੀ',
            'hi' => 'घर पर स्वास्थ्य सुधार',
            'es' => 'Recuperación en el hogar',
        ],
        '24-hour care' => [
            'pa' => '24-ਘੰਟੇ ਦੇਖਭਾਲ',
            'hi' => '24-घंटे देखभाल',
            'es' => 'Atención las 24 horas',
        ],
    ];
    return $map[$title][$lang] ?? dynamic_translate($title, $lang);
}
}

if (!function_exists('tr_service_summary')) {
function tr_service_summary(string $title, string $summary): string {
    $lang = current_language();
    if ($lang === 'en') return $summary;
    $map = [
        'Personal care' => [
            'pa' => 'ਸਤਿਕਾਰ ਨਾਲ ਇਸ਼ਨਾਨ, ਕੱਪੜੇ ਪਹਿਨਣਾ ਅਤੇ ਸਫ਼ਾਈ। ਰੋਜ਼ਾਨਾ ਦੇ ਕੰਮਾਂ ਵਿੱਚ ਪਿਆਰ ਭਰੀ ਮਦਦ ਤਾਂ ਜੋ ਤੁਹਾਡਾ ਪਿਆਰਾ ਤਰੋਤਾਜ਼ਾ ਅਤੇ ਆਤਮ-ਵਿਸ਼ਵਾਸੀ ਮਹਿਸੂਸ ਕਰੇ।',
            'hi' => 'गरिमा के साथ स्नान, वस्त्र पहनना और व्यक्तिगत स्वच्छता। दैनिक दिनचर्या में संवेदनशील सहायता ताकि आपका प्रियजन सहज महसूस करे।',
            'es' => 'Baño, vestido e higiene personal con dignidad y respeto. Asistencia compasiva con las rutinas diarias para sentirse seguro e independiente.',
        ],
        'Companion care' => [
            'pa' => 'ਨਿੱਘਾ ਸਾਥ, ਸਾਂਝੇ ਸ਼ੌਕ ਅਤੇ ਹਲਕਾ ਭੋਜਨ। ਦੋਸਤਾਨਾ ਗੱਲਬਾਤ, ਸੈਰ ਅਤੇ ਮਨਪਸੰਦ ਗਤੀਵਿਧੀਆਂ ਜੋ ਦਿਨ ਨੂੰ ਖੁਸ਼ਹਾਲ ਬਣਾਉਂਦੀਆਂ ਹਨ।',
            'hi' => 'आत्मीय संगति, रुचियाँ साझा करना और पौष्टिक भोजन। मित्रतापूर्ण बातचीत, सैर और ऐसे पल जो हर दिन को सुंदर बनाते हैं।',
            'es' => 'Compañía cálida, pasatiempos compartidos y comidas ligeras. Conversaciones amenas, paseos y momentos compartidos que alegran el día.',
        ],
        'Memory care' => [
            'pa' => 'ਧੀਰਜ, ਨਿਯਮਿਤ ਰੁਟੀਨ ਅਤੇ ਜਾਣੇ-ਪਛਾਣੇ ਚਿਹਰੇ। ਸ਼ਾਂਤ ਮਾਹੌਲ, ਸੁਰੱਖਿਅਤ ਦੇਖਭਾਲ ਅਤੇ ਯਾਦਦਾਸ਼ਤ ਨੂੰ ਉਤਸ਼ਾਹਿਤ ਕਰਨ ਵਾਲੀਆਂ ਗਤੀਵਿਧੀਆਂ।',
            'hi' => 'धैर्य, नियमित दिनचर्या और जाने-पहचाने चेहरे। शांत वातावरण, सुरक्षित देखभाल और स्मृति को सक्रिय रखने वाली विशेष गतिविधियाँ।',
            'es' => 'Paciencia, rutinas estructuradas y rostros familiares. Apoyo especializado con rutinas consistentes, entorno seguro y actividades estimulantes.',
        ],
        'Respite care' => [
            'pa' => 'ਤੁਸੀਂ ਆਰਾਮ ਕਰ ਸਕਦੇ ਹੋ, ਅਸੀਂ ਸੰਭਾਲਾਂਗੇ। ਪਰਿਵਾਰਕ ਕੇਅਰਗਿਵਰਾਂ ਨੂੰ ਛੁੱਟੀ ਦੀ ਲੋੜ ਹੁੰਦੀ ਹੈ। ਕੁਝ ਘੰਟਿਆਂ ਤੋਂ ਲੈ ਕੇ ਕੁਝ ਹਫ਼ਤਿਆਂ ਤੱਕ ਭਰੋਸੇਮੰਦ ਦੇਖਭਾਲ।',
            'hi' => 'आप विश्राम कर सकते हैं, हम देखभाल करेंगे। देखभालकर्ता के रूप में विश्राम लेना आवश्यक है। कुछ घंटों से लेकर हफ़्तों तक का विश्वसनीय सहारा।',
            'es' => 'Usted puede descansar; nosotros cuidamos de ellos. El cuidado de relevo le permite recargar energías sabiendo que su ser querido está en buenas manos.',
        ],
        'Recovery at home' => [
            'pa' => 'ਹਸਪਤਾਲ ਤੋਂ ਬਾਅਦ ਘਰ ਵਿੱਚ ਸੁਰੱਖਿਅਤ ਸਿਹਤਯਾਬੀ। ਦਵਾਈਆਂ ਦੇ ਸਮੇਂ ਦੀ ਯਾਦ, ਸੰਤੁਲਿਤ ਭੋਜਨ ਅਤੇ ਸੁਰੱਖਿਅਤ ਹਿਲਜੁਲ ਵਿੱਚ ਪੂਰੀ ਮਦਦ।',
            'hi' => 'अस्पताल के बाद घर पर सुरक्षित सुधार। दवाइयों के समय की याद, पौष्टिक आहार और सुरक्षित आवागमन में संपूर्ण सहायता।',
            'es' => 'Recuperación segura y cómoda en casa después de una estancia hospitalaria o cirugía, con recordatorio de medicamentos, nutrición y movilidad.',
        ],
        '24-hour care' => [
            'pa' => '24 ਘੰਟੇ ਪੇਸ਼ੇਵਰ ਕੇਅਰਗਿਵਰ ਹਮੇਸ਼ਾ ਮੌਜੂਦ! ਰਾਤ ਵੇਲੇ ਦੀ ਸਹਾਇਤਾ, ਲਾਈਵ-ਇਨ ਵਿਕਲਪ ਅਤੇ ਨਿਰੰਤਰ ਸੁਰੱਖਿਆ ਨਿਗਰਾਨੀ।',
            'hi' => '24 घंटे पेशेवर देखभालकर्ता सदैव उपस्थित! रात की सहायता, लिव-इन विकल्प और निरंतर सुरक्षा निगरानी।',
            'es' => 'Atención profesional disponible las 24 horas. Cuidado continuo durante el día y la noche, opciones de residencia y supervisión permanente.',
        ],
    ];
    return $map[$title][$lang] ?? dynamic_translate($summary, $lang);
}
}

if (!function_exists('tr_faq_q')) {
function tr_faq_q(string $q): string {
    $lang = current_language();
    if ($lang === 'en') return $q;
    $map = [
        'Are caregivers screened and insured?' => [
            'pa' => 'ਕੀ ਕੇਅਰਗਿਵਰਾਂ ਦੀ ਪਿਛੋਕੜ ਜਾਂਚ ਹੁੰਦੀ ਹੈ ਅਤੇ ਉਹ ਬੀਮਾਯੁਕਤ ਹਨ?',
            'hi' => 'क्या देखभालकर्ताओं की पृष्ठभूमि जाँची जाती है और वे बीमित हैं?',
            'es' => '¿Los cuidadores pasan por verificación de antecedentes y tienen seguro?',
        ],
        'Can we change the care plan later?' => [
            'pa' => 'ਕੀ ਅਸੀਂ ਬਾਅਦ ਵਿੱਚ ਦੇਖਭਾਲ ਯੋਜਨਾ ਬਦਲ ਸਕਦੇ ਹਾਂ?',
            'hi' => 'क्या हम बाद में देखभाल योजना बदल सकते हैं?',
            'es' => '¿Podemos modificar el plan de atención más adelante?',
        ],
        'How much does home care cost?' => [
            'pa' => 'ਘਰੇਲੂ ਦੇਖਭਾਲ ਦਾ ਖ਼ਰਚ ਕਿੰਨਾ ਹੁੰਦਾ ਹੈ?',
            'hi' => 'घरेलू देखभाल का खर्च कितना होता है?',
            'es' => '¿Cuánto cuesta el cuidado en el hogar?',
        ],
        'How soon can care begin?' => [
            'pa' => 'ਦੇਖਭਾਲ ਕਿੰਨੀ ਜਲਦੀ ਸ਼ੁਰੂ ਹੋ ਸਕਦੀ ਹੈ?',
            'hi' => 'देखभाल कितनी जल्दी शुरू हो सकती है?',
            'es' => '¿Qué tan pronto puede comenzar la atención?',
        ],
        'What kinds of in-home care do you offer?' => [
            'pa' => 'ਤੁਸੀਂ ਕਿਸ ਤਰ੍ਹਾਂ ਦੀ ਘਰੇਲੂ ਦੇਖਭਾਲ ਦੀ ਪੇਸ਼ਕਸ਼ ਕਰਦੇ ਹੋ?',
            'hi' => 'आप किस प्रकार की इन-होम देखभाल सेवाएँ प्रदान करते हैं?',
            'es' => '¿Qué tipos de cuidado en el hogar ofrecen?',
        ],
    ];
    return $map[$q][$lang] ?? dynamic_translate($q, $lang);
}
}

if (!function_exists('tr_faq_a')) {
function tr_faq_a(string $q, string $a): string {
    $lang = current_language();
    if ($lang === 'en') return $a;
    $map = [
        'Are caregivers screened and insured?' => [
            'pa' => 'ਹਾਂ, ਬਿਲਕੁਲ। ਸਾਡੇ ਸਾਰੇ ਕੇਅਰਗਿਵਰਾਂ ਦੀ ਪੂਰੀ ਪੁਲਿਸ ਵੈਰੀਫਿਕੇਸ਼ਨ, ਪਿਛੋਕੜ ਜਾਂਚ ਹੁੰਦੀ ਹੈ ਅਤੇ ਉਹ ਪੂਰੀ ਤਰ੍ਹਾਂ ਲਾਇਸੰਸਸ਼ੁਦਾ ਤੇ ਬੀਮਾਯੁਕਤ ਹਨ।',
            'hi' => 'हाँ, बिल्कुल। हमारे सभी देखभालकर्ताओं की विस्तृत पृष्ठभूमि जाँच, पुलिस सत्यापन किया जाता है और वे पूरी तरह बीमित एवं प्रशिक्षित हैं।',
            'es' => 'Sí, absolutamente. Todos nuestros cuidadores pasan por rigurosas verificaciones de antecedentes, están debidamente capacitados y cuentan con seguro.',
        ],
        'Can we change the care plan later?' => [
            'pa' => 'ਹਾਂ, ਜ਼ਰੂਰ। ਤੁਹਾਡੀਆਂ ਲੋੜਾਂ ਬਦਲਣ ਦੇ ਨਾਲ-ਨਾਲ ਤੁਸੀਂ ਕਿਸੇ ਵੀ ਸਮੇਂ ਦੇਖਭਾਲ ਦਾ ਸਮਾਂ ਜਾਂ ਯੋਜਨਾ ਬਦਲ ਸਕਦੇ ਹੋ।',
            'hi' => 'हाँ, बिल्कुल। जैसे-जैसे आपकी ज़रूरतें बदलती हैं, आप किसी भी समय देखभाल योजना या समय में बदलाव कर सकते हैं।',
            'es' => 'Sí, por supuesto. A medida que las necesidades de su ser querido cambien, adaptamos el plan y los horarios en cualquier momento.',
        ],
        'How much does home care cost?' => [
            'pa' => 'ਖ਼ਰਚ ਲੋੜੀਂਦੀ ਦੇਖਭਾਲ ਦੀ ਕਿਸਮ ਅਤੇ ਘੰਟਿਆਂ \'ਤੇ ਨਿਰਭਰ ਕਰਦਾ ਹੈ। ਅਸੀਂ ਮੁਫ਼ਤ ਮੁਲਾਂਕਣ ਦੌਰਾਨ ਸਪਸ਼ਟ ਅਤੇ ਪਾਰਦਰਸ਼ੀ ਦਰਾਂ ਪ੍ਰਦਾਨ ਕਰਦੇ ਹਾਂ।',
            'hi' => 'खर्च आवश्यक देखभाल के प्रकार और घंटों पर निर्भर करता है। हम निःशुल्क मूल्यांकन के दौरान स्पष्ट और पारदर्शी दरें प्रदान करते हैं।',
            'es' => 'El costo varía según las necesidades específicas y las horas requeridas. Ofrecemos cotizaciones transparentes durante nuestra evaluación gratuita.',
        ],
        'How soon can care begin?' => [
            'pa' => 'ਅਕਸਰ 24 ਤੋਂ 48 ਘੰਟਿਆਂ ਦੇ ਅੰਦਰ, ਅਤੇ ਜ਼ਰੂਰੀ ਸਥਿਤੀਆਂ ਵਿੱਚ ਉਸੇ ਦਿਨ ਵੀ ਦੇਖਭਾਲ ਸ਼ੁਰੂ ਕੀਤੀ ਜਾ ਸਕਦੀ ਹੈ।',
            'hi' => 'आमतौर पर 24 से 48 घंटों के भीतर, और आपातकालीन परिस्थितियों में उसी दिन भी देखभाल शुरू की जा सकती है।',
            'es' => 'Por lo general, dentro de las 24 a 48 horas posteriores a la evaluación inicial, e incluso el mismo día para casos urgentes.',
        ],
        'What kinds of in-home care do you offer?' => [
            'pa' => 'ਅਸੀਂ ਨਿੱਜੀ ਦੇਖਭਾਲ, ਸਾਥੀ ਦੇਖਭਾਲ, ਮੈਮੋਰੀ ਕੇਅਰ, ਰਿਸਪਾਈਟ ਕੇਅਰ, ਰਿਕਵਰੀ ਸਹਾਇਤਾ ਅਤੇ 24-ਘੰਟੇ ਲਾਈਵ-ਇਨ ਦੇਖਭਾਲ ਪ੍ਰਦਾਨ ਕਰਦੇ ਹਾਂ।',
            'hi' => 'हम व्यक्तिगत देखभाल, साथी देखभाल, मेमोरी केयर, रेस्पाइट केयर, रिकवरी सहायता और 24 घंटे लिव-इन देखभाल प्रदान करते हैं।',
            'es' => 'Ofrecemos cuidado personal, de compañía, cuidado de la memoria, cuidado de relevo, apoyo postoperatorio y atención continua de 24 horas.',
        ],
    ];
    return $map[$q][$lang] ?? dynamic_translate($a, $lang);
}
}

if (!function_exists('tr_testimonial')) {
function tr_testimonial(string $quote): string {
    $lang = current_language();
    if ($lang === 'en') return $quote;
    $map = [
        'We finally sleep at night knowing Mom is in good hands. Her caregiver is patient, warm, and thoughtful.' => [
            'pa' => 'ਸਾਨੂੰ ਰਾਤ ਨੂੰ ਚੰਗੀ ਨੀਂਦ ਆਉਂਦੀ ਹੈ ਇਹ ਜਾਣ ਕੇ ਕਿ ਮਾਂ ਚੰਗੇ ਹੱਥਾਂ ਵਿੱਚ ਹੈ। ਉਸਦੀ ਕੇਅਰਗਿਵਰ ਬਹੁਤ ਧੀਰਜਵਾਨ, ਨਿੱਘੀ ਅਤੇ ਵਿਚਾਰਸ਼ੀਲ ਹੈ।',
            'hi' => 'हम अब रात को चैन से सोते हैं यह जानकर कि माँ अच्छे हाथों में हैं। उनकी देखभालकर्ता बहुत धैर्यवान, संवेदनशील और आत्मीय हैं।',
            'es' => 'Por fin dormimos tranquilos sabiendo que mamá está en buenas manos. Su cuidadora es paciente, afectuosa y muy dedicada.',
        ],
        'The personal touch makes all the difference. They really listened and found someone who loves gardening just like Dad.' => [
            'pa' => 'ਨਿੱਜੀ ਅਪਣੱਤ ਸਭ ਤੋਂ ਵੱਡਾ ਫ਼ਰਕ ਪਾਉਂਦੀ ਹੈ। ਉਨ੍ਹਾਂ ਨੇ ਧਿਆਨ ਨਾਲ ਸੁਣਿਆ ਅਤੇ ਕਿਸੇ ਅਜਿਹੇ ਵਿਅਕਤੀ ਨੂੰ ਲੱਭਿਆ ਜੋ ਪਿਤਾ ਜੀ ਵਾਂਗ ਬਾਗਬਾਨੀ ਪਸੰਦ ਕਰਦਾ ਹੈ।',
            'hi' => 'व्यक्तिगत आत्मीयता बहुत बड़ा बदलाव लाती है। उन्होंने ध्यान से सुना और ऐसे साथी को चुना जो पिताजी की तरह ही बागवानी पसंद करता है।',
            'es' => 'El toque personal marca toda la diferencia. Nos escucharon con atención y encontraron a alguien que ama la jardinería igual que papá.',
        ],
        'Respite care let my husband and me take our first trip in years. We were able to truly relax.' => [
            'pa' => 'ਰਿਸਪਾਈਟ ਕੇਅਰ ਨੇ ਮੈਨੂੰ ਅਤੇ ਮੇਰੇ ਪਤੀ ਨੂੰ ਸਾਲਾਂ ਬਾਅਦ ਸਾਡੀ ਪਹਿਲੀ ਯਾਤਰਾ ਕਰਨ ਦਾ ਮੌਕਾ ਦਿੱਤਾ। ਅਸੀਂ ਪੂਰੀ ਤਰ੍ਹਾਂ ਤਣਾਅਮੁਕਤ ਹੋ ਸਕੇ।',
            'hi' => 'रेस्पाइट केयर ने मुझे और मेरे पति को वर्षों बाद पहली यात्रा पर जाने का अवसर दिया। हम वास्तव में तनावमुक्त हो सके।',
            'es' => 'El cuidado de relevo nos permitió a mi esposo y a mí hacer nuestro primer viaje en años. Pudimos relajarnos de verdad.',
        ],
    ];
    return $map[$quote][$lang] ?? dynamic_translate($quote, $lang);
}
}

if (!function_exists('tr_testimonial_location')) {
function tr_testimonial_location(string $loc): string {
    $lang = current_language();
    if ($lang === 'en') return $loc;
    $map = [
        'Austin, TX' => ['pa' => 'ਆਸਟਿਨ, ਟੈਕਸਾਸ', 'hi' => 'ऑस्टिन, टेक्सास', 'es' => 'Austin, TX'],
        'Phoenix, AZ' => ['pa' => 'ਫੀਨਿਕਸ, ਐਰੀਜ਼ੋਨਾ', 'hi' => 'फीनिक्स, एरिज़ोना', 'es' => 'Phoenix, AZ'],
        'Seattle, WA' => ['pa' => 'ਸਿਆਟਲ, ਵਾਸ਼ਿੰਗਟਨ', 'hi' => 'सिएटल, वाशिंगटन', 'es' => 'Seattle, WA'],
    ];
    return $map[$loc][$lang] ?? dynamic_translate($loc, $lang);
}
}

if (!function_exists('tr_caregiver_role')) {
function tr_caregiver_role(string $role): string {
    $lang = current_language();
    if ($lang === 'en') return $role;
    $map = [
        'Senior Care Specialist' => [
            'pa' => 'ਸੀਨੀਅਰ ਕੇਅਰ ਸਪੈਸ਼ਲਿਸਟ',
            'hi' => 'वरिष्ठ देखभाल विशेषज्ञ',
            'es' => 'Especialista en atención a personas mayores',
        ],
        'Home Health Aide' => [
            'pa' => 'ਹੋਮ ਹੈਲਥ ਏਡ',
            'hi' => 'घरेलू स्वास्थ्य सहायक',
            'es' => 'Asistente de salud en el hogar',
        ],
        'Certified Nursing Assistant' => [
            'pa' => 'ਸਰਟੀਫਾਈਡ ਨਰਸਿੰਗ ਅਸਿਸਟੈਂਟ',
            'hi' => 'प्रमाणित नर्सिंग सहायक',
            'es' => 'Asistente de enfermería certificado',
        ],
        'Companion Caregiver' => [
            'pa' => 'ਸਾਥੀ ਦੇਖਭਾਲਕਰਤਾ',
            'hi' => 'साथी देखभालकर्ता',
            'es' => 'Cuidador de compañía',
        ],
        'Memory Care Specialist' => [
            'pa' => 'ਮੈਮੋਰੀ ਕੇਅਰ ਮਾਹਿਰ',
            'hi' => 'स्मृति देखभाल विशेषज्ञ',
            'es' => 'Especialista en cuidado de la memoria',
        ],
        'Care Coordinator' => [
            'pa' => 'ਦੇਖਭਾਲ ਕੋਆਰਡੀਨੇਟਰ',
            'hi' => 'देखभाल समन्वयक',
            'es' => 'Coordinador de atención',
        ],
    ];
    return $map[$role][$lang] ?? dynamic_translate($role, $lang);
}
}

if (!function_exists('tr_resource_category')) {
function tr_resource_category(string $cat): string {
    $lang = current_language();
    if ($lang === 'en') return $cat;
    $map = [
        'Family guide' => [
            'pa' => 'ਪਰਿਵਾਰਕ ਗਾਈਡ',
            'hi' => 'पारिवारिक मार्गदर्शिका',
            'es' => 'Guía para la familia',
        ],
        'Health care decisions' => [
            'pa' => 'ਸਿਹਤ ਸੰਭਾਲ ਸੰਬੰਧੀ ਫ਼ੈਸਲੇ',
            'hi' => 'स्वास्थ्य देखभाल निर्णय',
            'es' => 'Decisiones de atención médica',
        ],
        'Caregiver wellness' => [
            'pa' => 'ਦੇਖਭਾਲਕਰਤਾ ਦੀ ਤੰਦਰੁਸਤੀ',
            'hi' => 'देखभालकर्ता का स्वास्थ्य एवं कल्याण',
            'es' => 'Bienestar del cuidador',
        ],
    ];
    return $map[$cat][$lang] ?? dynamic_translate($cat, $lang);
}
}

if (!function_exists('tr_resource_read_time')) {
function tr_resource_read_time(string $time): string {
    $lang = current_language();
    if ($lang === 'en') return $time;
    $map = [
        '2 min read' => [
            'pa' => '2 ਮਿੰਟ ਦਾ ਪੜ੍ਹਨ ਸਮਾਂ',
            'hi' => '2 मिनट का पठन',
            'es' => 'Lectura de 2 min',
        ],
        '4 min read' => [
            'pa' => '4 ਮਿੰਟ ਦਾ ਪੜ੍ਹਨ ਸਮਾਂ',
            'hi' => '4 मिनट का पठन',
            'es' => 'Lectura de 4 min',
        ],
        'Self-care guide' => [
            'pa' => 'ਸਵੈ-ਸੰਭਾਲ ਗਾਈਡ',
            'hi' => 'स्व-देखभाल मार्गदर्शिका',
            'es' => 'Guía de autocuidado',
        ],
    ];
    return $map[$time][$lang] ?? dynamic_translate($time, $lang);
}
}

if (!function_exists('tr_resource_title')) {
function tr_resource_title(string $title): string {
    $lang = current_language();
    if ($lang === 'en') return $title;
    $map = [
        'What Medicare won\'t cover, and what to do about it' => [
            'pa' => 'ਮੈਡੀਕੇਅਰ ਕੀ ਕਵਰ ਨਹੀਂ ਕਰਦਾ, ਅਤੇ ਇਸ ਬਾਰੇ ਕੀ ਕਰਨਾ ਹੈ',
            'hi' => 'मेडिकेयर क्या कवर नहीं करता, और इसके बारे में क्या करें',
            'es' => 'Lo que Medicare no cubre y qué hacer al respecto',
        ],
        'What Medicare won’t cover, and what to do about it' => [
            'pa' => 'ਮੈਡੀਕੇਅਰ ਕੀ ਕਵਰ ਨਹੀਂ ਕਰਦਾ, ਅਤੇ ਇਸ ਬਾਰੇ ਕੀ ਕਰਨਾ ਹੈ',
            'hi' => 'मेडिकेयर क्या कवर नहीं करता, और इसके बारे में क्या करें',
            'es' => 'Lo que Medicare no cubre y qué hacer al respecto',
        ],
        'Health care decisions' => [
            'pa' => 'ਸਿਹਤ ਸੰਭਾਲ ਸੰਬੰਧੀ ਫ਼ੈਸਲੇ',
            'hi' => 'स्वास्थ्य देखभाल संबंधी निर्णय',
            'es' => 'Decisiones sobre la atención médica',
        ],
        'Caring for your parents shouldn\'t mean losing yourself' => [
            'pa' => 'ਆਪਣੇ ਮਾਪਿਆਂ ਦੀ ਦੇਖਭਾਲ ਕਰਨ ਦਾ ਮਤਲਬ ਆਪਣੇ ਆਪ ਨੂੰ ਗੁਆਉਣਾ ਨਹੀਂ ਹੋਣਾ ਚਾਹੀਦਾ',
            'hi' => 'अपने माता-पिता की देखभाल का मतलब खुद को खोना नहीं होना चाहिए',
            'es' => 'Cuidar a sus padres no debería significar descuidarse a sí mismo',
        ],
        'Caring for your parents shouldn’t mean losing yourself' => [
            'pa' => 'ਆਪਣੇ ਮਾਪਿਆਂ ਦੀ ਦੇਖਭਾਲ ਕਰਨ ਦਾ ਮਤਲਬ ਆਪਣੇ ਆਪ ਨੂੰ ਗੁਆਉਣਾ ਨਹੀਂ ਹੋਣਾ ਚਾਹੀਦਾ',
            'hi' => 'अपने माता-पिता की देखभाल का मतलब खुद को खोना नहीं होना चाहिए',
            'es' => 'Cuidar a sus padres no debería significar descuidarse a sí mismo',
        ],
    ];
    return $map[$title][$lang] ?? dynamic_translate($title, $lang);
}
}

if (!function_exists('tr_resource_summary')) {
function tr_resource_summary(string $title, string $summary): string {
    $lang = current_language();
    if ($lang === 'en') return $summary;
    $map = [
        'What Medicare won\'t cover, and what to do about it' => [
            'pa' => 'ਮੈਡੀਕੇਅਰ ਦੁਆਰਾ ਕਵਰ ਕੀਤੀ ਜਾਣ ਵਾਲੀ ਮਾਹਿਰ ਦੇਖਭਾਲ ਅਤੇ ਲੰਬੇ ਸਮੇਂ ਦੀ ਨਿੱਜੀ ਦੇਖਭਾਲ ਵਿਚਕਾਰ ਅੰਤਰ ਨੂੰ ਸਮਝੋ, ਅਤੇ ਹੋਰ ਵਿਕਲਪਾਂ ਬਾਰੇ ਜਾਣੋ।',
            'hi' => 'मेडिकेयर द्वारा कवर की जाने वाली कुशल देखभाल और दीर्घकालिक व्यक्तिगत देखभाल के बीच का अंतर समझें, साथ ही परिवार के लिए उपलब्ध विकल्प जानें।',
            'es' => 'Comprenda la diferencia entre la atención especializada que cubre Medicare y el cuidado personal a largo plazo, además de las opciones que las familias pueden explorar.',
        ],
        'What Medicare won’t cover, and what to do about it' => [
            'pa' => 'ਮੈਡੀਕੇਅਰ ਦੁਆਰਾ ਕਵਰ ਕੀਤੀ ਜਾਣ ਵਾਲੀ ਮਾਹਿਰ ਦੇਖਭਾਲ ਅਤੇ ਲੰਬੇ ਸਮੇਂ ਦੀ ਨਿੱਜੀ ਦੇਖਭਾਲ ਵਿਚਕਾਰ ਅੰਤਰ ਨੂੰ ਸਮਝੋ, ਅਤੇ ਹੋਰ ਵਿਕਲਪਾਂ ਬਾਰੇ ਜਾਣੋ।',
            'hi' => 'मेडिकेयर द्वारा कवर की जाने वाली कुशल देखभाल और दीर्घकालिक व्यक्तिगत देखभाल के बीच का अंतर समझें, साथ ही परिवार के लिए उपलब्ध विकल्प जानें।',
            'es' => 'Comprenda la diferencia entre la atención especializada que cubre Medicare y el cuidado personal a largo plazo, además de las opciones que las familias pueden explorar.',
        ],
        'Health care decisions' => [
            'pa' => 'ਪਹਿਲਾਂ ਤੋਂ ਯੋਜਨਾ ਬਣਾਓ ਕਿ ਜੇਕਰ ਮਾਤਾ-ਪਿਤਾ ਖੁਦ ਫ਼ੈਸਲਾ ਨਾ ਲੈ ਸਕਣ ਤਾਂ ਉਨ੍ਹਾਂ ਦੇ ਬੈਂਕ ਜਾਂ ਡਾਕਟਰ ਨਾਲ ਕੌਣ ਗੱਲ ਕਰ ਸਕਦਾ ਹੈ।',
            'hi' => 'पहले से योजना बनाएँ कि यदि माता-पिता स्वयं निर्णय लेने में असमर्थ हों, तो उनके बैंक या डॉक्टर से कौन बात कर सकता है।',
            'es' => 'Planifique con anticipación quién puede comunicarse con el banco o médico de sus padres si ellos no pueden tomar decisiones por sí mismos.',
        ],
        'Caring for your parents shouldn\'t mean losing yourself' => [
            'pa' => 'ਕਿਸੇ ਪਿਆਰੇ ਦੀ ਦੇਖਭਾਲ ਤੁਹਾਡਾ ਪੂਰਾ ਦਿਨ ਲੈ ਸਕਦੀ ਹੈ। ਇਹ ਸੁਝਾਅ ਤੁਹਾਡੀਆਂ ਆਪਣੀਆਂ ਲੋੜਾਂ ਲਈ ਸਮਾਂ ਕੱਢਣ ਵਿੱਚ ਮਦਦ ਕਰਨਗੇ।',
            'hi' => 'किसी प्रियजन की देखभाल आपका पूरा दिन ले सकती है। ये विचार आपकी अपनी ज़रूरतों के लिए भी समय निकालने में मदद करेंगे।',
            'es' => 'Cuidar a un ser querido puede ocupar todo su día. Estas ideas le ayudarán a encontrar espacio para sus propias necesidades.',
        ],
        'Caring for your parents shouldn’t mean losing yourself' => [
            'pa' => 'ਕਿਸੇ ਪਿਆਰੇ ਦੀ ਦੇਖਭਾਲ ਤੁਹਾਡਾ ਪੂਰਾ ਦਿਨ ਲੈ ਸਕਦੀ ਹੈ। ਇਹ ਸੁਝਾਅ ਤੁਹਾਡੀਆਂ ਆਪਣੀਆਂ ਲੋੜਾਂ ਲਈ ਸਮਾਂ ਕੱਢਣ ਵਿੱਚ ਮਦਦ ਕਰਨਗੇ।',
            'hi' => 'किसी प्रियजन की देखभाल आपका पूरा दिन ले सकती है। ये विचार आपकी अपनी ज़रूरतों के लिए भी समय निकालने में मदद करेंगे।',
            'es' => 'Cuidar a un ser querido puede ocupar todo su día. Estas ideas le ayudarán a encontrar espacio para sus propias necesidades.',
        ],
    ];
    return $map[$title][$lang] ?? dynamic_translate($summary, $lang);
}
}

if (!function_exists('tr_resource_btn')) {
function tr_resource_btn(string $btn): string {
    $lang = current_language();
    if ($lang === 'en') return $btn;
    $map = [
        'How to start?' => [
            'pa' => 'ਕਿਵੇਂ ਸ਼ੁਰੂ ਕਰਨਾ ਹੈ?',
            'hi' => 'कैसे शुरुआत करें?',
            'es' => '¿Cómo empezar?',
        ],
        'Talk to us' => [
            'pa' => 'ਸਾਡੇ ਨਾਲ ਗੱਲ ਕਰੋ',
            'hi' => 'हमसे बात करें',
            'es' => 'Hable con nosotros',
        ],
    ];
    return $map[$btn][$lang] ?? dynamic_translate($btn, $lang);
}
}

if (!function_exists('tr_resource_body')) {
function tr_resource_body(int $id, string $defaultBody): string {
    $lang = current_language();
    if ($lang === 'en') return $defaultBody;
    $map = [
        1 => [
            'pa' => '“ਮਾਂ ਡਿੱਗ ਪਈ ਸੀ; ਕੀ ਮੈਂ ਉਸ ਲਈ ਕਿਸੇ ਨੂੰ ਬੁਲਾ ਸਕਦਾ ਹਾਂ?”

“ਮੇਰੇ ਪਿਤਾ ਜੀ ਬਾਰੇ ਕੀ? ਕੀ ਉਨ੍ਹਾਂ ਨੂੰ ਕੱਪੜੇ ਪਾਉਣ ਵਿੱਚ ਮਦਦ ਮਿਲ ਸਕਦੀ ਹੈ?”

ਅਸੀਂ ਜਾਣਦੇ ਹਾਂ ਕਿ ਪਰਿਵਾਰ ਉਮੀਦ ਕਰਦੇ ਹਨ ਕਿ ਮੈਡੀਕੇਅਰ ਇਹਨਾਂ ਸੇਵਾਵਾਂ ਨੂੰ ਕਵਰ ਕਰੇਗਾ। ਇੱਥੇ ਅਸੀਂ ਦੱਸ ਰਹੇ ਹਾਂ ਕਿ ਕੀ ਕਵਰ ਨਹੀਂ ਕੀਤਾ ਜਾਂਦਾ ਅਤੇ ਇਸ ਸਥਿਤੀ ਵਿੱਚ ਕੀ ਵਿਕਲਪ ਹਨ।

ਮੈਡੀਕੇਅਰ ਘਰ ਵਿੱਚ ਮਾਹਿਰ ਡਾਕਟਰੀ ਦੇਖਭਾਲ ਜਿਵੇਂ ਕਿ ਨਰਸਿੰਗ ਜਾਂ ਥੈਰੇਪੀ ਨੂੰ ਕਵਰ ਕਰ ਸਕਦਾ ਹੈ ਜਦੋਂ ਡਾਕਟਰ ਬਿਮਾਰੀ ਜਾਂ ਹਸਪਤਾਲ ਤੋਂ ਬਾਅਦ ਇਸਦੀ ਸਿਫ਼ਾਰਸ਼ ਕਰਦਾ ਹੈ।

ਮੈਡੀਕੇਅਰ ਲੰਬੇ ਸਮੇਂ ਦੀ ਨਿੱਜੀ ਦੇਖਭਾਲ (ਜਿਵੇਂ ਇਸ਼ਨਾਨ, ਕੱਪੜੇ ਪਹਿਨਣ ਜਾਂ ਖਾਣਾ ਬਣਾਉਣ ਵਿੱਚ ਮਦਦ) ਨੂੰ ਕਵਰ ਨਹੀਂ ਕਰਦਾ। ਅਤੇ ਪਰਿਵਾਰਾਂ ਨੂੰ ਰੋਜ਼ਾਨਾ ਇਸੇ ਮਦਦ ਦੀ ਲੋੜ ਹੁੰਦੀ ਹੈ।

ਤੁਹਾਡੇ ਵਿਕਲਪ ਕੀ ਹਨ?

- ਮੈਡੀਕੇਡ: ਜੇਕਰ ਉਹ ਰਾਜ ਦੀਆਂ ਯੋਗਤਾ ਸ਼ਰਤਾਂ ਪੂਰੀਆਂ ਕਰਦੇ ਹਨ
- ਲੰਬੀ ਮਿਆਦ ਦੀ ਦੇਖਭਾਲ ਬੀਮਾ: ਜੇਕਰ ਤੁਹਾਡੇ ਮਾਪਿਆਂ ਕੋਲ ਪਾਲਿਸੀ ਹੈ
- ਵੈਟਰਨਜ਼ ਲਾਭ (VA): ਯੋਗ ਸਾਬਕਾ ਸੈਨਿਕਾਂ ਲਈ
- ਨਿੱਜੀ ਭੁਗਤਾਨ (ਪ੍ਰਾਈਵੇਟ ਪੇਅ)',
            'hi' => '“माँ गिर गई थीं; क्या मैं उनके लिए किसी की मदद ले सकता हूँ?”

“मेरे पिताजी का क्या? क्या उन्हें कपड़े पहनने में मदद मिल सकती है?”

अक्सर परिवार यह उम्मीद करते हैं कि मेडिकेयर इन सेवाओं का खर्च उठाएगा। यहाँ हम बता रहे हैं कि मेडिकेयर क्या कवर नहीं करता और आपके पास क्या विकल्प हैं।

मेडिकेयर घर पर कुशल चिकित्सकीय देखभाल (जैसे पार्ट-टाइम नर्सिंग या थेरेपी) को कवर कर सकता है जब डॉक्टर बीमारी या अस्पताल के बाद इसकी सलाह देते हैं।

मेडिकेयर लंबी अवधि की व्यक्तिगत देखभाल (जैसे स्नान, वस्त्र पहनना या भोजन में सहायता) को कवर नहीं करता। और परिवारों को प्रतिदिन इसी सहायता की आवश्यकता होती है।

आपके पास क्या विकल्प हैं?

- मेडिकेड: यदि वे अपने राज्य के पात्रता मानदंडों को पूरा करते हैं
- दीर्घकालिक देखभाल बीमा: यदि आपके माता-पिता के पास पॉलिसी है
- वेटरन्स लाभ (VA): पात्र दिग्गजों के लिए
- निजी भुगतान (प्राइवेट पे)',
            'es' => '“Mamá se cayó; ¿puedo llamar a alguien para que la ayude?”

“¿Y qué pasa con mi papá? ¿Puede recibir ayuda para vestirse?”

Sabemos que muchas familias esperan que Medicare cubra estos servicios. Es una de las dudas más frecuentes. A continuación, explicamos qué no está cubierto y qué alternativas existen.

Medicare puede cubrir atención médica especializada en el hogar, como enfermería a tiempo parcial o terapia, cuando un médico lo prescribe tras una enfermedad, lesión o estadía en el hospital.

Medicare no cubre el cuidado personal continuo a largo plazo, como la asistencia para bañarse, vestirse o preparar alimentos, cuando esa es la única ayuda que se requiere. Y esa es precisamente la ayuda que las familias necesitan a diario.

¿Cuáles son sus opciones?

- Medicaid: Si cumplen con los requisitos de elegibilidad de su estado
- Seguro de cuidados a largo plazo: Si sus padres cuentan con una póliza
- Beneficios para veteranos (VA): Para veteranos elegibles
- Pago privado o recursos propios.',
        ],
        2 => [
            'pa' => 'ਜੇਕਰ ਮਾਂ ਕੱਲ੍ਹ ਨੂੰ ਫ਼ੈਸਲੇ ਲੈਣ ਦੇ ਯੋਗ ਨਾ ਰਹੇ, ਤਾਂ ਉਸਦੇ ਬੈਂਕ ਜਾਂ ਡਾਕਟਰ ਨਾਲ ਕੌਣ ਗੱਲ ਕਰੇਗਾ?

ਜ਼ਿਆਦਾਤਰ ਪਰਿਵਾਰ ਇਸ ਬਾਰੇ ਉਦੋਂ ਤੱਕ ਨਹੀਂ ਸੋਚਦੇ ਜਦੋਂ ਤੱਕ ਜ਼ਰੂਰਤ ਨਾ ਪਵੇ। ਪਾਵਰ ਆਫ਼ ਅਟਾਰਨੀ (POA) ਰਾਹੀਂ ਤੁਸੀਂ ਸਮੇਂ ਸਿਰ ਇਹ ਫ਼ੈਸਲਾ ਕਰ ਸਕਦੇ ਹੋ।

ਪਾਵਰ ਆਫ਼ ਅਟਾਰਨੀ ਕੀ ਹੈ?

ਇਹ ਇੱਕ ਕਾਨੂੰਨੀ ਦਸਤਾਵੇਜ਼ ਹੈ ਜਿਸ ਵਿੱਚ ਮਾਤਾ-ਪਿਤਾ ਆਪਣੇ ਭਰੋਸੇਯੋਗ ਵਿਅਕਤੀ ਨੂੰ ਆਪਣੇ ਵੱਲੋਂ ਫ਼ੈਸਲੇ ਲੈਣ ਦਾ ਅਧਿਕਾਰ ਦਿੰਦੇ ਹਨ।

ਦੋ ਮੁੱਖ ਕਿਸਮਾਂ:

ਵਿੱਤੀ ਪਾਵਰ ਆਫ਼ ਅਟਾਰਨੀ: ਇਹ ਬਿੱਲ ਭਰਨ, ਬੈਂਕ ਖਾਤੇ ਚਲਾਉਣ ਅਤੇ ਜਾਇਦਾਦ ਸੰਬੰਧੀ ਕੰਮਾਂ ਲਈ ਅਧਿਕਾਰ ਦਿੰਦਾ ਹੈ।

ਸਿਹਤ ਸੰਭਾਲ ਫ਼ੈਸਲੇ: ਇਹ ਮੈਡੀਕਲ ਡਾਇਰੈਕਟਿਵ ਰਾਹੀਂ ਹੁੰਦਾ ਹੈ, ਜਿਸ ਵਿੱਚ ਚੁਣਿਆ ਗਿਆ ਵਿਅਕਤੀ ਮੈਡੀਕਲ ਐਮਰਜੈਂਸੀ ਦੌਰਾਨ ਫ਼ੈਸਲੇ ਲੈਂਦਾ ਹੈ।',
            'hi' => 'यदि माँ कल निर्णय लेने में असमर्थ हो जाएँ, तो उनके बैंक या डॉक्टर से कौन बात करेगा?

अधिकांश परिवार इस प्रश्न पर तब तक विचार नहीं करते जब तक मजबूरी न आ जाए। पावर ऑफ अटॉर्नी (POA) के माध्यम से आप समय रहते इसका समाधान कर सकते हैं।

पावर ऑफ अटॉर्नी क्या है?

यह एक कानूनी दस्तावेज़ है जिसमें माता-पिता अपने किसी विश्वसनीय व्यक्ति को अपनी ओर से कार्य करने का अधिकार देते हैं।

दो प्रमुख प्रकार:

वित्तीय पावर ऑफ अटॉर्नी: यह प्रतिनिधि को बिल भुगतान, बैंक खाते संचालित करने और संपत्ति से जुड़े काम करने की अनुमति देता है।

स्वास्थ्य देखभाल निर्णय: यह मेडिकल डायरेक्टिव के माध्यम से होता है, जिसमें अधिकृत व्यक्ति तब निर्णय लेता है जब माता-पिता स्वयं निर्णय लेने में असमर्थ हों।',
            'es' => 'Si su madre no pudiera tomar decisiones mañana, ¿quién podría hablar con su banco o con su médico?

La mayoría de las familias nunca se hacen esta pregunta hasta que se vuelve urgente. Un Poder Notarial (Power of Attorney) permite resolverlo con anticipación, y es más sencillo de lo que parece.

¿Qué es un Poder Notarial?

Es un documento legal en el que uno de sus padres (el “titular”) designa a una persona de confianza (el “representante”) para actuar en su nombre. Piense en ello como decir: “Si yo no puedo ocuparme de esto, deseo que tú lo hagas…”

Dos conceptos que las familias suelen confundir:

Poder notarial financiero: Permite al representante gestionar asuntos económicos como pagar facturas, administrar cuentas bancarias y tramitar propiedades.

Decisiones sobre atención médica: Se gestionan mediante una directiva médica anticipada donde se designa a un representante de atención médica. Esta es la persona autorizada para tomar decisiones médicas cuando su ser querido no pueda hacerlo por sí mismo.',
        ],
        3 => [
            'pa' => 'ਆਖਰੀ ਵਾਰ ਕਦੋਂ ਕਿਸੇ ਨੇ ਤੁਹਾਡਾ ਹਾਲ ਪੁੱਛਿਆ ਸੀ?

ਕਿਸੇ ਪਿਆਰੇ ਦੀ ਦੇਖਭਾਲ ਤੁਹਾਡੀ ਪੂਰੀ ਜ਼ਿੰਦਗੀ ਨੂੰ ਘੇਰ ਸਕਦੀ ਹੈ, ਅਤੇ ਆਪਣੇ ਲਈ ਥੋੜ੍ਹਾ ਸਮਾਂ ਕੱਢਣਾ ਖੁਦਗਰਜ਼ੀ ਨਹੀਂ ਹੈ। ਇਹ ਤੁਹਾਡੀ ਤਾਕਤ ਬਣਾਈ ਰੱਖਣ ਲਈ ਬਹੁਤ ਜ਼ਰੂਰੀ ਹੈ।

ਇਹ ਕਿਉਂ ਮਹੱਤਵਪੂਰਨ ਹੈ:

ਜੇਕਰ ਤੁਸੀਂ ਥੱਕੇ ਹੋਏ ਹੋ, ਤਾਂ ਤੁਸੀਂ ਅਸਫਲ ਨਹੀਂ ਹੋ। ਤੁਸੀਂ ਇਨਸਾਨ ਹੋ। ਆਪਣੀ ਦੇਖਭਾਲ ਕਰਨਾ ਪਿੱਛੇ ਹਟਣਾ ਨਹੀਂ ਹੈ, ਸਗੋਂ ਆਪਣੇ ਪਿਆਰੇ ਲਈ ਲੰਬੇ ਸਮੇਂ ਤੱਕ ਖੜ੍ਹੇ ਰਹਿਣ ਦਾ ਤਰੀਕਾ ਹੈ।

ਆਪਣਾ ਸੰਤੁਲਨ ਬਣਾਉਣ ਦੇ ਤਰੀਕੇ:

- ਸਪਸ਼ਟ ਮਦਦ ਮੰਗੋ: ਪਰਿਵਾਰ ਦੇ ਮੈਂਬਰਾਂ ਜਾਂ ਦੋਸਤਾਂ ਨੂੰ ਖਾਸ ਜ਼ਿੰਮੇਵਾਰੀ ਸੌਂਪੋ।
- ਆਪਣਾ ਸਮਾਂ ਬਚਾਓ: ਰੋਜ਼ਾਨਾ 20 ਮਿੰਟ ਸੈਰ ਜਾਂ ਸ਼ਾਂਤੀ ਲਈ ਕੱਢੋ।
- ਆਪਣੀ ਸਿਹਤ ਦਾ ਧਿਆਨ ਰੱਖੋ: ਡਾਕਟਰੀ ਜਾਂਚ ਅਤੇ ਨੀਂਦ ਨੂੰ ਅਣਗੌਲਿਆ ਨਾ ਕਰੋ।
- ਪੇਸ਼ੇਵਰ ਮਦਦ ਲਓ: ਕੇਅਰਗਿਵਰ ਦੀ ਮਦਦ ਲੈਣਾ ਤੁਹਾਨੂੰ ਦੁਬਾਰਾ ਧੀ ਜਾਂ ਪੁੱਤਰ ਬਣਨ ਦਾ ਸਮਾਂ ਦਿੰਦਾ ਹੈ।',
            'hi' => 'आखिरी बार आपसे किसी ने कब पूछा था कि आप कैसे हैं?

किसी प्रियजन की देखभाल में आपका पूरा दिन बीत सकता है, और अपने लिए थोड़ा समय निकालना स्वार्थ नहीं है। यह आपकी ऊर्जा और सामर्थ्य को बनाए रखने के लिए अनिवार्य है।

यह क्यों महत्वपूर्ण है:

यदि आप थका हुआ महसूस करते हैं, तो आप असफल नहीं हैं। आप इंसान हैं। खुद का ख्याल रखना पीछे हटना नहीं है, बल्कि अपने प्रियजन के लिए लंबे समय तक पूरी निष्ठा से खड़े रहने का उपाय है।

संतुलन बनाने के छोटे कदम:

- स्पष्ट मदद माँगें: परिजनों या मित्रों से संकोच न करें और उन्हें कोई निश्चित कार्य सौंपें।
- अपने लिए समय सुरक्षित करें: दिन में 20 मिनट टहलना, संगीत सुनना या शांत बैठना भी बहुत राहत देता है।
- अपनी सेहत का ध्यान रखें: नियमित स्वास्थ्य जाँच और पर्याप्त नींद आवश्यक हैं।
- पेशेवर सहायता लें: देखभालकर्ता की मदद लेना आपको केवल एक केयरगिवर नहीं, बल्कि फिर से बेटा या बेटी बनने का अवसर देता है।',
            'es' => '¿Cuándo fue la última vez que alguien le preguntó cómo está usted?

Cuidar a un ser querido puede consumir silenciosamente todo su tiempo, y reservar un momento para usted no es egoísta. Es la clave para continuar cuidándolo de manera sostenible.

Por qué esto es importante

Si se siente cansado, no está fallando. Es humano. Cuidar a quien ama requiere una energía enorme. Cuidar de sí mismo no significa retroceder; es lo que le permite seguir presente con amor y paciencia.

Pequeños pasos para encontrar su propio ritmo:

- Pida ayuda concreta y específica: Decir “¿Podrías llevar a mamá a su cita el jueves?” obtiene mejores resultados que un mensaje vago como “Avísame si puedes ayudar”.
- Comparta la responsabilidad: Hermanos, familiares y amigos con frecuencia desean colaborar pero no saben cómo. Asígneles una tarea clara.
- Proteja su tiempo personal: Incluso 20 minutos para dar un paseo, llamar a una amistad o tomar un café en silencio marcan una gran diferencia.
- Atienda su propia salud: Sus chequeos médicos y su descanso son indispensables, aun cuando parezca no haber tiempo suficiente.
- Permita que otros le apoyen: Recibir apoyo profesional no es rendirse; es la mejor manera de sostener el bienestar familiar y le devuelve el espacio para ser hijo o hija, no solamente cuidador.

Un recordatorio cariñoso

Si se siente agotado o abrumado durante varios días, consulte con su médico. Usted también merece atención y respaldo.

¿Necesita apoyo? Hable con nuestro equipo. Le ayudaremos a diseñar el acompañamiento ideal para su familia.',
        ],
    ];
    return $map[$id][$lang] ?? dynamic_translate($defaultBody, $lang);
}
}

if (!function_exists('tr_location_hours')) {
function tr_location_hours(string $hours): string {
    $lang = current_language();
    if ($lang === 'en') return $hours;
    $map = [
        'Every day — 24/7 support' => [
            'pa' => 'ਹਰ ਰੋਜ਼ — 24/7 ਸਹਾਇਤਾ',
            'hi' => 'प्रतिदिन — 24/7 सहायता',
            'es' => 'Todos los días — Soporte 24/7',
        ],
        'Every day • 24/7 support' => [
            'pa' => 'ਹਰ ਰੋਜ਼ — 24/7 ਸਹਾਇਤਾ',
            'hi' => 'प्रतिदिन — 24/7 सहायता',
            'es' => 'Todos los días — Soporte 24/7',
        ],
    ];
    return $map[$hours][$lang] ?? dynamic_translate($hours, $lang);
}
}

if (!function_exists('tr_location_state')) {
function tr_location_state(string $state): string {
    $lang = current_language();
    if ($lang === 'en') return $state;
    $map = [
        'Indiana' => ['pa' => 'ਇੰਡੀਆਨਾ', 'hi' => 'इंडियाना', 'es' => 'Indiana'],
        'Arizona' => ['pa' => 'ਐਰੀਜ਼ੋਨਾ', 'hi' => 'एरिज़ोना', 'es' => 'Arizona'],
    ];
    return $map[$state][$lang] ?? dynamic_translate($state, $lang);
}
}
