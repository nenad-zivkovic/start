<?php
require_once __DIR__.'/../../loader.php';

use app\components\session\SessionManager as SessionManager;
use app\components\auth\AuthManager as AuthManager;
use app\components\web\UrlManager as UrlManager;

$auth = new AuthManager();
$auth->protectPage();

$session = new SessionManager;
$session->open();
$session->destroy();

UrlManager::goHome();