<?php
declare(strict_types=1);
require_once __DIR__ . '/i18n.php';

function member_login(array $member): never {
    session_regenerate_id(true);
    $_SESSION['member_id'] = (int)$member['id'];
    $_SESSION['member_name'] = (string)$member['name'];
    $_SESSION['member_email'] = (string)$member['email'];
    redirect('/account.php');
}

function provider_configured(string $provider): bool {
    return match ($provider) {
        'google' => envv('GOOGLE_CLIENT_ID') !== '' && envv('GOOGLE_CLIENT_SECRET') !== '',
        'facebook' => envv('FACEBOOK_APP_ID') !== '' && envv('FACEBOOK_APP_SECRET') !== '',
        default => false,
    };
}

function oauth_request(string $url, ?array $post = null, array $headers = []): array {
    if (!function_exists('curl_init')) throw new RuntimeException('PHP cURL is required for social sign-in.');
    $curl = curl_init($url);
    curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER=>true, CURLOPT_TIMEOUT=>15, CURLOPT_CONNECTTIMEOUT=>8, CURLOPT_SSL_VERIFYPEER=>true, CURLOPT_SSL_VERIFYHOST=>2]);
    if ($post !== null) { curl_setopt($curl, CURLOPT_POST, true); curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post)); }
    if ($headers) curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $body = curl_exec($curl); $status = (int)curl_getinfo($curl, CURLINFO_RESPONSE_CODE); $error = curl_error($curl); curl_close($curl);
    if (!is_string($body) || $status < 200 || $status >= 300) throw new RuntimeException('The identity provider could not complete sign-in.' . ($error ? ' ' . $error : ''));
    $data = json_decode($body, true);
    if (!is_array($data)) throw new RuntimeException('The identity provider returned an invalid response.');
    return $data;
}

function social_identity(string $provider, string $code): array {
    $redirectUri = rtrim(APP_URL, '/') . '/auth/social.php?provider=' . rawurlencode($provider);
    if ($provider === 'google') {
        $token = oauth_request('https://oauth2.googleapis.com/token', ['code'=>$code,'client_id'=>envv('GOOGLE_CLIENT_ID'),'client_secret'=>envv('GOOGLE_CLIENT_SECRET'),'redirect_uri'=>$redirectUri,'grant_type'=>'authorization_code']);
        if (empty($token['access_token'])) throw new RuntimeException('Google did not return a sign-in token.');
        $profile = oauth_request('https://openidconnect.googleapis.com/v1/userinfo', null, ['Authorization: Bearer ' . $token['access_token']]);
        if (empty($profile['sub']) || empty($profile['email']) || empty($profile['email_verified'])) throw new RuntimeException('Google must provide a verified email address to create your account.');
        return ['provider'=>'google','subject'=>(string)$profile['sub'],'email'=>strtolower((string)$profile['email']),'name'=>(string)($profile['name'] ?? $profile['email'])];
    }
    $version = preg_replace('/[^v0-9.]/', '', envv('FACEBOOK_GRAPH_VERSION', 'v25.0')) ?: 'v25.0';
    $token = oauth_request('https://graph.facebook.com/' . $version . '/oauth/access_token?' . http_build_query(['client_id'=>envv('FACEBOOK_APP_ID'),'client_secret'=>envv('FACEBOOK_APP_SECRET'),'redirect_uri'=>$redirectUri,'code'=>$code]));
    if (empty($token['access_token'])) throw new RuntimeException('Facebook did not return a sign-in token.');
    $profile = oauth_request('https://graph.facebook.com/' . $version . '/me?fields=id%2Cname%2Cemail', null, ['Authorization: Bearer ' . $token['access_token']]);
    if (empty($profile['id']) || empty($profile['email'])) throw new RuntimeException('Facebook did not provide an email address. Use email and password sign-in instead.');
    return ['provider'=>'facebook','subject'=>(string)$profile['id'],'email'=>strtolower((string)$profile['email']),'name'=>(string)($profile['name'] ?? $profile['email'])];
}

function member_from_social(array $identity): array {
    $column = $identity['provider'] . '_id';
    $stmt = db()->prepare("SELECT * FROM members WHERE `$column`=?"); $stmt->execute([$identity['subject']]); $member = $stmt->fetch();
    if ($member) return $member;
    $stmt = db()->prepare('SELECT * FROM members WHERE email=?'); $stmt->execute([$identity['email']]); $member = $stmt->fetch();
    if ($member) {
        $stmt = db()->prepare("UPDATE members SET `$column`=? WHERE id=?"); $stmt->execute([$identity['subject'], $member['id']]);
        $member[$column] = $identity['subject']; return $member;
    }
    $stmt = db()->prepare("INSERT INTO members (name,email,`$column`) VALUES (?,?,?)");
    $stmt->execute([$identity['name'],$identity['email'],$identity['subject']]);
    return ['id'=>(int)db()->lastInsertId(),'name'=>$identity['name'],'email'=>$identity['email']];
}
