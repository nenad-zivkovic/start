<?php
require_once 'loader.php';

use app\components\session\SessionManager as SessionManager;
use app\helpers\UtilsHelper as UtilsHelper;
use app\models\RegistrationForm as RegistrationForm;

$session = new SessionManager();

/**
 * @todo Maybe some other validations and wrapper for error management.
 * @todo Error validations in model ? hmm ?
 */

$errors = [];

// not a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $errors[] = 'please submit the form.';
}

// all field are empty
if (empty($_POST['form-username']) || empty($_POST['form-email']) || empty($_POST['form-password'])) {
    $errors[] = 'all fields are required.';
}

// username is not in valid format
if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST['form-username'])) {
    $errors[] = 'username - only letters and digits are allowed';
}

// email is not in valid format
if (!filter_var($_POST['form-email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'email - invalid email format.';
}

// password is not in valid format
if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST['form-password'])) {
    $errors[] = 'password - only letters and digits are allowed';
}

// return user back to registration form to fix errors
if (!empty($errors)) {
    $session->set('form-errors', $errors);
    UtilsHelper::goToRegistrationForm();
}

$model = new RegistrationForm($_POST['form-username'], $_POST['form-email'], $_POST['form-password']);

// if login was successful redirect user to the protected page
if ($userId = $model->register()) {
    $session->set('userId', $userId);
    $session->set('username', $_POST['form-username']);
    UtilsHelper::goToMembersHome();
}

// login was not successful, redirect the user to login page (home in our case)
UtilsHelper::goHome();