<?php
// Configuration of Google OAuth 

require_once 'vendor/autoload.php';
require_once 'class-db.php';
  
// These are constants. Replace the values accordingly.
define('GOOGLE_CLIENT_ID', '938596916632-3ppseq9jf54jj37nc5daofmvmorq0f07.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_EMAIL_DISPLAY_NAME', 'VNHS DRMS');
define('GOOGLE_EMAIL_ACCOUNT', 'vnhs.drms@gmail.com');
define('CALLBACK_LINK', 'https://38ee-210-23-163-72.ap.ngrok.io/vnhs-drms/callback.php');
define('GET_OAUTH_TOKEN_LINK', 'https://38ee-210-23-163-72.ap.ngrok.io/vnhs-drms/get_oauth_token.php');

// Don't change anything here.
$config = [
    'callback' => CALLBACK_LINK,
    'keys'     => [
                    'id' => GOOGLE_CLIENT_ID,
                    'secret' => GOOGLE_CLIENT_SECRET
                ],
    'scope'    => 'https://mail.google.com',
    'authorize_url_parameters' => [
            'approval_prompt' => 'force', // to pass only when you need to acquire a new refresh token.
            'access_type' => 'offline'
    ]
];
  
// Creating a Google Adapter.
$adapter = new Hybridauth\Provider\Google( $config );

?>