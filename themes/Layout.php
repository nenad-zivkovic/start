<?php
namespace app\themes;

use app\components\auth\iAuthManager as iAuthManager;

/**
 * Class that is responsible for including reusable parts of the site.
 */
class Layout
{
    private static $_theme = 'default';
    
    protected $_authManager;

    public function __construct(iAuthManager $authManager)
    {
        $this->_authManager = $authManager;
    }

    public function header()
    {
        require_once self::$_theme .DS. 'header.php';

        if ($this->_authManager->userIsMember()) {
            require_once self::$_theme .DS. 'navigation.php';
        }
    }

    public function footer()
    {
        require_once self::$_theme .DS. 'footer.php';
    }
}