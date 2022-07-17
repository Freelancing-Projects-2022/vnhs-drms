<?php
require_once 'vendor/autoload.php';
require_once 'class-db.php';
  
define('GOOGLE_CLIENT_ID', '938596916632-3ppseq9jf54jj37nc5daofmvmorq0f07.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
  
$config = [
    'callback' => 'https://ad7a-49-145-102-251.jp.ngrok.io/vnhs-drms/callback.php',
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
  
$adapter = new Hybridauth\Provider\Google( $config );

?>