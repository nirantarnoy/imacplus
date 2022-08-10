<?php
ob_start();
session_start();
require_once __DIR__ . '/vendor/php-graph-sdk-5.x/src/Facebook/autoload.php';
$fb = new \Facebook\Facebook([
    'app_id' => '828260794001696',
    'app_secret' => '5dd3b30d1b7da7738bf8f6f38a440da2',
    'default_graph_version' => 'v2.10',
    'default_access_token' => 'EAALxTH5oaSABACSTjEkKoHWG9MmngRUNZAtCAjHzq9UH0AlWWXyDTePgWOKtcYvopbfy0wLQfVx6aFy5HGOdWNFZBfovguf1Fs0aFwje7ZBfyxZBQj41hKoJzGx6V20VIIZB816rAj0zlxo7Xc76IUSReFelpMIAl9MpOZCakXBIjj2H0uFqdQnhp9taWRm5h68RmX9dj1zbMZBCVzszuQdbsZC1bnQH3ZAebjcE8txpZA1BHkCo9hatnh', // optional
]);

// Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
//   $helper = $fb->getRedirectLoginHelper();
//   $helper = $fb->getJavaScriptHelper();
//   $helper = $fb->getCanvasHelper();
//   $helper = $fb->getPageTabHelper();
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes']; // optional
$loginUrl = $helper->getLoginUrl('http://localhost/imacplus/login-callback.php',$permissions);
echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';

?>