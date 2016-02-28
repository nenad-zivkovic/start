<?php
namespace app\models;

require_once __DIR__.'/../loader.php';

use app\components\session\SessionManager as SessionManager;

/**
 * LoginForm model. 
 */
class LoginForm
{
    private $_username;
    private $_password;

    private $_user = false;

    function __construct($username, $password)
    {
        $this->_username = $username;
        $this->_password = $password;
    }

    /**
     * Verifies that username and password are matching.
     * 
     * @return User|false
     */
    public function login()
    {
        $user = $this->getUser();

        if (!$user || !$user->validatePassword($user->password, $this->_password)) {
            $session = new SessionManager();
            $session->set('form-errors', 'Invalid username or password.');
            return false;
        }

        return $user;
    }

    /**
     * Helper method responsible for finding user.
     * 
     * @return object The found User object.
     */
    private function findUser()
    {
        return (new User())->findByUsername($this->_username);   
    }

    /**
     * Method that is returning User object.
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = $this->findUser();
        }

        return $this->_user;
    }
}