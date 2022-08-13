<?php
// This inserts token to the 'google_oauth' table in the database
// 'google_oauth' table is the storage of the Google Token for the GMail API

require_once 'config.php';

try {
    $adapter->authenticate();
    $token = $adapter->getAccessToken();
    $db = new DB();
    $db->update_access_token(json_encode($token));
    echo "Access token inserted successfully.";
}
catch( Exception $e ){
    echo $e->getMessage() ;
}
?>