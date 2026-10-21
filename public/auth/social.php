<?php
declare(strict_types=1);
require dirname(__DIR__,2) . '/app/bootstrap.php';
require dirname(__DIR__,2) . '/app/member_auth.php';
$provider = (string)($_GET['provider'] ?? '');
if (!in_array($provider,['google','facebook'],true)) { http_response_code(404); exit('Unknown sign-in provider.'); }
try {
    if (isset($_GET['error'])) throw new RuntimeException('Sign-in was cancelled or rejected by the provider. Please try another sign-in method.');
    if (!provider_configured($provider)) throw new RuntimeException(ucfirst($provider) . ' sign-in is not configured yet. Add the provider credentials to the private .env file.');
    $redirectUri = rtrim(APP_URL, '/') . '/auth/social.php?provider=' . rawurlencode($provider);
    if (!isset($_GET['code'])) {
        $state = bin2hex(random_bytes(32)); $_SESSION['oauth_state'][$provider] = $state;
        if ($provider === 'google') $url='https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query(['client_id'=>envv('GOOGLE_CLIENT_ID'),'redirect_uri'=>$redirectUri,'response_type'=>'code','scope'=>'openid email profile','state'=>$state,'prompt'=>'select_account']);
        else { $version=preg_replace('/[^v0-9.]/','',envv('FACEBOOK_GRAPH_VERSION','v25.0')) ?: 'v25.0'; $url='https://www.facebook.com/' . $version . '/dialog/oauth?' . http_build_query(['client_id'=>envv('FACEBOOK_APP_ID'),'redirect_uri'=>$redirectUri,'response_type'=>'code','scope'=>'email,public_profile','state'=>$state]); }
        header('Location: ' . $url, true, 302); exit;
    }
    $expected=(string)($_SESSION['oauth_state'][$provider]??''); unset($_SESSION['oauth_state'][$provider]);
    if ($expected==='' || !hash_equals($expected,(string)($_GET['state']??''))) throw new RuntimeException('The sign-in session expired or could not be verified. Please try again.');
    $identity=social_identity($provider,(string)$_GET['code']);
    member_login(member_from_social($identity));
} catch (Throwable $error) {
    error_log('Social login failed: ' . $error->getMessage());
    flash($error->getMessage(),'error');
    redirect('/login.php');
}
