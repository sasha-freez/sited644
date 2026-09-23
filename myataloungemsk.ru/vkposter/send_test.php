<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__.'/Config.php';
require_once __DIR__.'/class/FacebookWrapper.php';
require_once __DIR__.'/class/VkWrapper.php';
require_once __DIR__.'/class/Poster.php';
$appId = Config::FACEBOOK_APP_ID;
$appSecret = Config::FACEBOOK_APP_SECRET;

$groupId = Config::FACEBOOK_PAGE_ID;
$token = Config::FACEBOOK_PAGE_TOKEN;

$vkWrapper = new VkWrapper(Config::VK_PAGE_ID, Config::VK_APP_SECRET);

$fb = new Facebook\Facebook([
    'app_id'  => $appId,
    'app_secret' => $appSecret,
    'default_graph_version' => 'v2.4',
]);
$file = __DIR__.'/parsed.json';
//$a = file_get_contents($file);
//$a= unserialize($a);
//array_shift($a);
//file_put_contents($file,serialize($a));exit;
$facebookWrapper = new FacebookWrapper($fb, $token, $groupId);

$poster = new Poster($vkWrapper, $facebookWrapper,$file);
$poster->sendToFacebook();

//$wr->sendPost('as','https://filmix.me/uploads/posters/thumbs/w220/ochen-strannye-dela-2016_109539_0.jpg');