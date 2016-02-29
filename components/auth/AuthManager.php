<?php
namespace app\components\auth;

use app\components\session\SessionManager as SessionManager;

/**
 * Application authentication manager. 
 * It is using sessions to do its job.
 * Not using dependency injection intentionaly.
 */
class AuthManager implements iAuthManager
{
    /**
     * Use session to figure out if user is logged in ( member )
     * 
     * @return boolean
     */
    public function userIsMember()
    {
        $session = new SessionManager();
        $userId = $session->get('userId');
        
        if (!empty($userId)) {
            return true;
        }

        return false;
    }

    /**
     * Do not allow to guests to see the page that AuthManager is protecting.
     */
    public function protectPage()
    {
        if (!$this->userIsMember()) {
            UrlManager::goHome();
        }
    }
}