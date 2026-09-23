<?
session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__.'/Config.php';
header('Content-Type: text/html; charset=utf-8');

$app_id = Config::FACEBOOK_APP_ID;
$app_secret = Config::FACEBOOK_APP_SECRET;

$callback = Config::FACEBOOK_CALLBACK;

$fb = new Facebook\Facebook([
    'app_id'  => $app_id,
    'app_secret' => $app_secret,
    'default_graph_version' => 'v2.4',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['publish_actions','manage_pages','publish_pages'];
$loginUrl = $helper->getLoginUrl($callback, $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Авторизация</a>';
