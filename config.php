<?php
 
//Include Google Client Library for PHP autoload file
require_once 'google_login/google-api/vendor/autoload.php';
 
//Make object of Google API Client for call Google API
$google_client = new Google_Client();
 
//Set the OAuth 2.0 Client ID
$google_client->setClientId('624168443480-alor55af0q15l98l07c7u0rsc5fkep7t.apps.googleusercontent.com');
 
//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');
 
//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/db_project/');
 
//
$google_client->addScope('email');
 
$google_client->addScope('profile');
 
//start session on web page
session_start();
 
?>