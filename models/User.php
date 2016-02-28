<?php
namespace app\models;

use app\components\db\DBManager as DBManager;

/**
 * Class that is represening the user database table. 
 */
class User extends DBManager
{
    protected $_table = 'user';

    /**
     * Finds a user by id.
     * 
     * @param  integer $id integer.
     * @return User|null
     */
    public function findById($id)
    {
        return $this->query("SELECT * FROM {$this->_table} WHERE id = ?")->bind($id)->one();
    }

    /**
     * Finds a user by username.
     * 
     * @param  string $username
     * @return User|null
     */
    public function findByUsername($username)
    {
        return $this->query("SELECT * FROM {$this->_table} WHERE username = ?")->bind($username)->one();
    }

    /**
     * Use password library to validate user submitted password against the one stored in database.
     * 
     * @param  string  $passwordFromDb    the user password stored in database
     * @param  string  $submittedPassword the user submitted password throught the form
     * @return boolean                    whether or not passwords match
     */
    public function validatePassword($passwordFromDb, $submittedPassword)
    {
        if (!password_verify($submittedPassword, $passwordFromDb)) {
            return false;
        }

        return true;
    }
}