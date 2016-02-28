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
        return $this->query("SELECT id, username, password 
                             FROM {$this->_table} 
                             WHERE username = ?")
                    ->bind($username)
                    ->one();
    }

    /**
     * Find all users and sort them by id DESC ( newest at the top ).
     * We are sorting by id instead of created_at so we do not need to put index on created_at field.
     * We save some memory, and effect is the same ;)
     * 
     * @return User|null
     */
    public function findAll()
    {
        return $this->query("SELECT id, username, email FROM {$this->_table} ORDER BY id DESC")->all();
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

    /**
     * Method that is responsible for saving user ( uppon registration ).
     * 
     * @param  string $username 
     * @param  string $email    
     * @param  string $password 
     * @return integer          The user id.
     */
    public function saveUser($username, $email, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        return $this->query("INSERT INTO {$this->_table} 
                             SET username = ?, 
                                 password = ?,
                                 email = ?,
                                 created_at = NOW()")
                    ->bind($username, $hash, $email)
                    ->run();
    }
}