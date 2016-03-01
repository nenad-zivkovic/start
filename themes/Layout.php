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

    /**
     * Outputs the page header. It can accept the array of parameters that you can use for setting 
     * dynamic values in tags inside header like: page titles, meta tags etc.
     * 
     * @param  array  $params array of values that should be injected inside html tags
     */
    public function header($params = [])
    {
        $pageTitle = (isset($params['title'])) ? $params['title'] : APP_NAME ;
        $pageDescription = (isset($params['description'])) ? $params['description'] : 'php template login register' ;

        require_once self::$_theme .DS. 'header.php';

        if ($this->_authManager->userIsMember()) {
            require_once self::$_theme .DS. 'navigation.php';
        }
    }

    /**
     * Outputs the page footer.
     */
    public function footer()
    {
        require_once self::$_theme .DS. 'footer.php';
    }
}