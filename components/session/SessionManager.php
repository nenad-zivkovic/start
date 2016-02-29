<?php
namespace app\components\session;

/**
 * Session wrapping class.
 */
class SessionManager
{
    /**
     * Starts the session.
     */
    public function open()
    {
        if ($this->getIsActive()) {
            return;
        }
        session_start();
    }

    /**
     * Ends the current session and store session data.
     */
    public function close()
    {
        if ($this->getIsActive()) {
            session_write_close();
        }
    }

    /**
     * Frees all session variables and destroys all data registered to a session.
     */
    public function destroy()
    {
        if ($this->getIsActive()) {
            session_unset();
            $sessionId = session_id();
            session_destroy();
            session_id($sessionId);
        }
    }

    /**
     * @return boolean whether the session has started
     */
    public function getIsActive()
    {
        return session_status() == PHP_SESSION_ACTIVE;
    }

    /**
     * Returns the number of items in the session.
     * 
     * @return integer the number of session variables
     */
    
    public function getCount()
    {
        $this->open();
        
        return count($_SESSION);
    }
    /**
     * Returns the number of items in the session.
     * 
     * @return integer number of items in the session.
     */
    public function count()
    {
        return $this->getCount();
    }

    /**
     * Returns the session variable value with the session variable name.
     * If the session variable does not exist, null will be returned.
     * 
     * @param string $key the session variable name
     * @return mixed      the session variable value, or null if the session variable does not exist.
     */
    public function get($key)
    {
        $this->open();

        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Adds a session variable.
     * If the specified name already exists, the old value will be overwritten.
     * 
     * @param string $key   session variable name.
     * @param mixed  $value session variable value.
     */
    public function set($key, $value)
    {
        $this->open();

        $_SESSION[$key] = $value;
    }

    /**
     * Removes a session variable.
     * 
     * @param string $key the name of the session variable to be removed
     * @return mixed      the removed value, null if no such session variable.
     */
    public function remove($key)
    {
        $this->open();

        if (!isset($_SESSION[$key])) {
            return null;
        }

        $value = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $value;
    }

    /**
     * Removes all session variables
     */
    public function removeAll()
    {
        $this->open();

        foreach (array_keys($_SESSION) as $key) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * @param mixed    $key session variable name
     * @return boolean      whether there is the named session variable
     */
    public function has($key)
    {
        $this->open();

        return isset($_SESSION[$key]);
    }  

    /**
     * Updates the current session Id with a newly generated one .
     * Please refer to <http://php.net/session_regenerate_id> for more details.
     * 
     * @param boolean $deleteOldSession Whether to delete the old associated session file or not.
     */
    public function regenerateId($deleteOldSession = false)
    {
        session_regenerate_id($deleteOldSession);
    }      
}
