<?php
declare(strict_types=1);

function current_language(): string {
    $supported = ['en', 'pa', 'hi', 'es'];
    if (isset($_GET['lang']) && in_array((string)$_GET['lang'], $supported, true)) {
        $_SESSION['site_language'] = (string)$_GET['lang'];
    }
    $language = (string)($_SESSION['site_language'] ?? 'en');
    return in_array($language, $supported, true) ? $language : 'en';
}

function tr(string $key): string {
    static $messages = [
        'en' => [
            'about'=>'About Us','resources'=>'Resources','services'=>'Services','locations'=>'Locations',
            'login'=>'Login','signup'=>'Sign up','call'=>'Call','request_care'=>'Request care',
            'contact'=>'Contact','care_services'=>'Care services','find_location'=>'Find a location',
            'first_name'=>'First name','last_name'=>'Last name','phone'=>'Phone number','email'=>'Email address',
            'password'=>'Password','confirm_password'=>'Confirm password','sign_in'=>'Sign in',
            'create_account'=>'Create account','admin_login'=>'Admin login','google_signin'=>'Continue with Google',
            'facebook_signin'=>'Continue with Facebook','or_email'=>'or continue with email','logout'=>'Sign out',
            'elevated_care'=>'Elevated Care. Right at Home.','language'=>'Choose language',
            'hero_first'=>'Care that feels','hero_second'=>'like home.','search_care'=>'Find care','explore_services'=>'Explore services',
            'about_heading'=>'Care you can trust. Comfort you deserve.','services_heading'=>'Care that meets you where you are.',
            'locations_heading'=>'Care, right around the corner.','contact_heading'=>'Here for your family, right now.',
            'assessment'=>'Request a free assessment','care_type'=>'Type of care','zip_code'=>'ZIP code','details'=>'Anything else we should know?',
            'send_request'=>'Request my free assessment','search'=>'Search','contact_team'=>'Contact our care team',
        ],
        'pa' => [
            'about' => 'ਸਾਡੇ ਬਾਰੇ', 'resources' => 'ਸਰੋਤ', 'services' => 'ਸੇਵਾਵਾਂ', 'locations' => 'ਸਥਾਨ',
            'login' => 'ਲਾਗ ਇਨ', 'signup' => 'ਸਾਈਨ ਅੱਪ', 'call' => 'ਕਾਲ ਕਰੋ', 'request_care' => 'ਦੇਖਭਾਲ ਲਈ ਬੇਨਤੀ',
            'contact' => 'ਸੰਪਰਕ', 'care_services' => 'ਦੇਖਭਾਲ ਸੇਵਾਵਾਂ', 'find_location' => 'ਸਥਾਨ ਲੱਭੋ',
            'first_name' => 'ਪਹਿਲਾ ਨਾਮ', 'last_name' => 'ਆਖਰੀ ਨਾਮ', 'phone' => 'ਫ਼ੋਨ ਨੰਬਰ', 'email' => 'ਈਮੇਲ ਪਤਾ',
            'password' => 'ਪਾਸਵਰਡ', 'confirm_password' => 'ਪਾਸਵਰਡ ਦੀ ਪੁਸ਼ਟੀ ਕਰੋ', 'sign_in' => 'ਸਾਈਨ ਇਨ',
            'create_account' => 'ਖਾਤਾ ਬਣਾਓ', 'admin_login' => 'ਪ੍ਰਸ਼ਾਸਕ ਲਾਗ ਇਨ', 'google_signin' => 'Google ਨਾਲ ਜਾਰੀ ਰੱਖੋ',
            'facebook_signin' => 'Facebook ਨਾਲ ਜਾਰੀ ਰੱਖੋ', 'or_email' => 'ਜਾਂ ਈਮੇਲ ਨਾਲ', 'logout' => 'ਲਾਗ ਆਉਟ',
            'elevated_care' => 'ਉੱਚ ਪੱਧਰੀ ਦੇਖਭਾਲ। ਤੁਹਾਡੇ ਆਪਣੇ ਘਰ ਵਿੱਚ।', 'language' => 'ਭਾਸ਼ਾ ਚੁਣੋ',
            'hero_first'=>'ਘਰ ਵਰਗੀ ਮਹਿਸੂਸ ਹੋਵੇ ਦੇਖਭਾਲ','hero_second'=>'ਤੁਹਾਡੇ ਘਰ ਵਿੱਚ।','search_care'=>'ਦੇਖਭਾਲ ਲੱਭੋ','explore_services'=>'ਸੇਵਾਵਾਂ ਵੇਖੋ',
            'about_heading'=>'ਭਰੋਸੇਯੋਗ ਦੇਖਭਾਲ। ਘਰ ਦਾ ਸੁਖ।','services_heading'=>'ਤੁਹਾਡੀ ਲੋੜ ਅਨੁਸਾਰ ਦੇਖਭਾਲ।',
            'locations_heading'=>'ਤੁਹਾਡੇ ਨੇੜੇ ਦੇਖਭਾਲ।','contact_heading'=>'ਤੁਹਾਡੇ ਪਰਿਵਾਰ ਲਈ ਅਸੀਂ ਇੱਥੇ ਹਾਂ।',
            'assessment'=>'ਮੁਫ਼ਤ ਮੁਲਾਂਕਣ ਦੀ ਬੇਨਤੀ','care_type'=>'ਦੇਖਭਾਲ ਦੀ ਕਿਸਮ','zip_code'=>'ਜ਼ਿਪ ਕੋਡ','details'=>'ਕੀ ਤੁਸੀਂ ਹੋਰ ਕੁਝ ਦੱਸਣਾ ਚਾਹੋਗੇ?',
            'send_request'=>'ਮੁਫ਼ਤ ਮੁਲਾਂਕਣ ਦੀ ਬੇਨਤੀ ਕਰੋ','search'=>'ਖੋਜੋ','contact_team'=>'ਸਾਡੀ ਦੇਖਭਾਲ ਟੀਮ ਨਾਲ ਸੰਪਰਕ ਕਰੋ',
        ],
        'hi' => [
            'about' => 'हमारे बारे में', 'resources' => 'संसाधन', 'services' => 'सेवाएँ', 'locations' => 'स्थान',
            'login' => 'लॉग इन', 'signup' => 'साइन अप', 'call' => 'कॉल करें', 'request_care' => 'देखभाल का अनुरोध करें',
            'contact' => 'संपर्क', 'care_services' => 'देखभाल सेवाएँ', 'find_location' => 'स्थान खोजें',
            'first_name' => 'पहला नाम', 'last_name' => 'अंतिम नाम', 'phone' => 'फ़ोन नंबर', 'email' => 'ईमेल पता',
            'password' => 'पासवर्ड', 'confirm_password' => 'पासवर्ड की पुष्टि करें', 'sign_in' => 'साइन इन',
            'create_account' => 'खाता बनाएँ', 'admin_login' => 'प्रशासक लॉग इन', 'google_signin' => 'Google से जारी रखें',
            'facebook_signin' => 'Facebook से जारी रखें', 'or_email' => 'या ईमेल से', 'logout' => 'लॉग आउट',
            'elevated_care' => 'बेहतर देखभाल। आपके अपने घर पर।', 'language' => 'भाषा चुनें',
            'hero_first'=>'घर जैसा महसूस हो ऐसी देखभाल','hero_second'=>'आपके अपने घर में।','search_care'=>'देखभाल खोजें','explore_services'=>'सेवाएँ देखें',
            'about_heading'=>'भरोसेमंद देखभाल। घर का सुकून।','services_heading'=>'आपकी ज़रूरत के अनुसार देखभाल।',
            'locations_heading'=>'आपके पास ही देखभाल।','contact_heading'=>'आपके परिवार के लिए हम यहाँ हैं।',
            'assessment'=>'निःशुल्क मूल्यांकन का अनुरोध करें','care_type'=>'देखभाल का प्रकार','zip_code'=>'ज़िप कोड','details'=>'क्या आप कुछ और बताना चाहेंगे?',
            'send_request'=>'मेरा निःशुल्क मूल्यांकन अनुरोध करें','search'=>'खोजें','contact_team'=>'हमारी देखभाल टीम से संपर्क करें',
        ],
        'es' => [
            'about' => 'Acerca de nosotros', 'resources' => 'Recursos', 'services' => 'Servicios', 'locations' => 'Ubicaciones',
            'login' => 'Iniciar sesión', 'signup' => 'Crear cuenta', 'call' => 'Llamar', 'request_care' => 'Solicitar atención',
            'contact' => 'Contacto', 'care_services' => 'Servicios de atención', 'find_location' => 'Buscar ubicación',
            'first_name' => 'Nombre', 'last_name' => 'Apellido', 'phone' => 'Teléfono', 'email' => 'Correo electrónico',
            'password' => 'Contraseña', 'confirm_password' => 'Confirmar contraseña', 'sign_in' => 'Iniciar sesión',
            'create_account' => 'Crear cuenta', 'admin_login' => 'Acceso de administrador', 'google_signin' => 'Continuar con Google',
            'facebook_signin' => 'Continuar con Facebook', 'or_email' => 'o con correo electrónico', 'logout' => 'Cerrar sesión',
            'elevated_care' => 'Atención superior. En la comodidad de su hogar.', 'language' => 'Elegir idioma',
            'hero_first'=>'Atención que se siente','hero_second'=>'como en casa.','search_care'=>'Buscar atención','explore_services'=>'Ver servicios',
            'about_heading'=>'Atención de confianza. Comodidad en casa.','services_heading'=>'Atención que se adapta a sus necesidades.',
            'locations_heading'=>'Atención cerca de usted.','contact_heading'=>'Estamos aquí para su familia.',
            'assessment'=>'Solicitar una evaluación gratuita','care_type'=>'Tipo de atención','zip_code'=>'Código postal','details'=>'¿Hay algo más que debamos saber?',
            'send_request'=>'Solicitar mi evaluación gratuita','search'=>'Buscar','contact_team'=>'Contacte con nuestro equipo de atención',
        ],
    ];
    $language = current_language();
    return $messages[$language][$key] ?? $messages['en'][$key] ?? $key;
}
