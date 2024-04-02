<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';


$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'tuniflix.contact.tn@gmail.com';
$mail->Password = 'tuniflix123';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port = 465;

use League\OAuth2\Client\Provider\Google;
use PHPMailer\PHPMailer\OAuth;

$provider = new Google([
    'clientId' => '1050220961964-tnm400nnrn5n1tqvua0ctkbbsbor0lkg.apps.googleusercontent.com',
    'clientSecret' => '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',
    'redirectUri' => 'https://example.com/callback-url',
    'accessType' => 'offline',
]);


if (!empty($_GET['error'])) {
    // Got an error, probably user denied access
    exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));
} elseif (empty($_GET['code'])) {
    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl([
        'scope' => [
            'https://mail.google.com/'
        ]
    ]);
    header('Location: ' . $authUrl);
    exit;
} else {
    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);
    // Use this to get a new access token if the old one expires
    $refreshToken = $token->getRefreshToken();
}


$mail->setOAuth(
    new OAuth(
        [
            'provider' => $provider,
            'clientId' => '1050220961964-tnm400nnrn5n1tqvua0ctkbbsbor0lkg.apps.googleusercontent.com',
            'clientSecret' => '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',
            'refreshToken' => $refreshToken,
            'userName' => 'tuniflix.contact.tn@gmail.com',
        ]
    )
);

?>