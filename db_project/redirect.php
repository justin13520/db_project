<?php
require_once 'google_login/google-api/vendor/autoload.php';
require('connect_db.php');
require('function_db.php');
// init configuration
$clientID = '624168443480-alor55af0q15l98l07c7u0rsc5fkep7t.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/FOOD/';
   
// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

session_start();

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  if(isset($token['access_token']))
    $client->setAccessToken($token['access_token']);
   
  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();

  $email =  $google_account_info->email;
  $name =  $google_account_info->name;
  $google_id = $google_account_info->id;
  $profile_pic = $google_account_info->picture;

  addUser($name,$email,$google_id,$profile_pic);
  // now you can use this profile info to create account in your website and make user logged in.
} else {
  echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
}
?>