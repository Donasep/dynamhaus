<?php
namespace App\Lib\ExternalApi\GoogleOAuth;
class GoogleOAuth {
public function googleConnect(string $method) {
    $googleOAuthClientId = $_ENV['GOOGLE_OAUTH_CLIENT_ID'];
    $googleOAuthClientSecret = $_ENV['GOOGLE_OAUTH_CLIENT_SECRET'];
    $googleOAuthRedirectUri = $_ENV['DYNAMHAUS_URL']."/$method";
    $googleOAuthVersion = 'v3';
if (isset($_GET['code']) && !empty($_GET['code'])) {
    // Execute cURL request to retrieve the access token
    $params = [
        'code' => $_GET['code'],
        'client_id' => $googleOAuthClientId,
        'client_secret' => $googleOAuthClientSecret,
        'redirect_uri' => $googleOAuthRedirectUri,
        'grant_type' => 'authorization_code'
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response, true);
    if (isset($response['access_token']) && !empty($response['access_token'])) {
        // Execute cURL request to retrieve the user info associated with the Google account
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/' . $googleOAuthVersion . '/userinfo');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $response['access_token']]);
        $response = curl_exec($ch);
        curl_close($ch);
        $profile = json_decode($response, true);
        // Make sure the profile data exists
        if (isset($profile['email'])) {
            $firstName = isset($profile['given_name']) ? preg_replace('/[^a-zA-Z0-9]/s', '', $profile['given_name']) : '';
            $lastName = isset($profile['family_name']) ? preg_replace('/[^a-zA-Z0-9]/s', '', $profile['family_name']) : '';
            $avatarUrl=isset($profile['picture']) ? $profile['picture'] : '';
            return ["email"=>$profile['email'],"firstName"=>$firstName,"lastName"=>$lastName,"avatarUrl"=>$avatarUrl];
        } else {
            exit('Could not retrieve profile information! Please try again later!');
        }
    } else {
        exit('Invalid access token! Please try again later!');
    }
} else {
    // Define params and redirect to Google Authentication page
    $params = [
        'response_type' => 'code',
        'client_id' => $googleOAuthClientId,
        'redirect_uri' => $googleOAuthRedirectUri,
        'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
        'access_type' => 'offline',
        'prompt' => 'consent'
    ];
    header('Location: https://accounts.google.com/o/oauth2/auth?' . http_build_query($params));
    exit;
}
}
}