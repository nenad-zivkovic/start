<?php
namespace app\models;

use app\components\db\DB as DB;

/**
 * Class that is represening the user database table. 
 */
class User extends DB
{
    protected $_table = 'user';

    /**
     * Finds a user by id.
     * 
     * @param  integer $id integer.
     * @return app\models\User
     */
    public function findOneById($id)
    {
        return $this->query("SELECT * FROM {$this->_table} WHERE id = ?")->bind($id)->one();
    }
}