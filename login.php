<?php
require_once 'loader.php';

use app\components\session\SessionManager as SessionManager;
use app\helpers\UtilsHelper as UtilsHelper;
use app\models\LoginForm as LoginForm;

$session = new SessionManager();

/**
 * @todo Maybe some other validations and wrapper for error management.
 * @todo Error validations in model ? hmm ?
 */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $session->set('form-errors', 'Please submit the form.');
    UtilsHelper::goHome();
}

if (empty($_POST['form-username']) || empty($_POST['form-password'])) {
    $session->set('form-errors', 'Username and Password fields are required.');
    UtilsHelper::goHome();
}

$model = new LoginForm($_POST['form-username'], $_POST['form-password']);

// if login was successful redirect user to the protected page
if ($user = $model->login()) {
    $session->set('userId', $user->id);
    $session->set('username', $user->username);
    UtilsHelper::goToMembersHome();
}

// login was not successful, redirect the user to home page (login in our case)
UtilsHelper::goHome();