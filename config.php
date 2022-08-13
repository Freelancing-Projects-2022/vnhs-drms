<?php
// Configuration of Google OAuth 

require_once 'vendor/autoload.php';
require_once 'class-db.php';
  
// These are constants. Replace the values accordingly.
define('GOOGLE_CLIENT_ID', '1042376393196-sumbpvth0r4ej89c78iqcb33do9krccs.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_EMAIL_DISPLAY_NAME', 'VNHS DRMS');
define('GOOGLE_EMAIL_ACCOUNT', 'vnhsdrmsnew@gmail.com');
define('CALLBACK_LINK', 'http://localhost/vnhsdrms/get_oauth_token.php');
define('GET_OAUTH_TOKEN_LINK', 'http://localhost/vnhsdrms/callback.php');

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