<?php
namespace app\models;

require_once __DIR__.'/../loader.php';

use app\components\session\SessionManager as SessionManager;

/**
 * RegistrationForm model. 
 */
class RegistrationForm
{
    private $_username;
    private $_email;
    private $_password;

    function __construct($username, $email, $password)
    {
        $this->_username = $username;
        $this->_email = $email;
        $this->_password = $password;
    }

    /**
     * Verifies that username and password are matching.
     * 
     * @return integer|boolean the user id or false if registration was not successful.
     */
    public function register()
    {
        $userId = $this->saveUser();

        if (!$userId) {
            $session = new SessionManager();
            $session->set('form-errors', 'We could not create your account. Please contact us.');
            return false;
        }

        return $userId;
    }

    /**
     * Helper method responsible for finding user.
     * 
     * @return object The found User object.
     */
    private function saveUser()
    {
        return (new User())->saveUser($this->_username, $this->_email, $this->_password);   
    }
}