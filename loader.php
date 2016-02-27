<?php	

/**
 * Script that is defining paths and also includes config and autoloader.
 *
 * @author Nenad Zivkovic <nenad@freetuts.org>
 * @copyright 2015
 */

//---------------------------------------------------------------------------------------------------------------------- 

/**
 * File path constants
 */
 
// Application name, you have to set this to your project name/root
define('APP_NAME', 'app');
 
// DIRECTORY_SEPARATOR is a PHP pre-defined constant ( \ for windows, / for Unix )
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR); 
 
// Site root path for the file system
defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'var'.DS.'www'.DS.'html'.DS.APP_NAME.DS);

// Path to "includes" folder
defined('INCLUDES') ? null : define('INCLUDES', SITE_ROOT.'includes'.DS);

//----------------------------------------------------------------------------------------------------------------------

/**
 * Include config and SplClassLoader
 */
require_once INCLUDES.'config.php';
require_once INCLUDES.'SplClassLoader.php';
 
//----------------------------------------------------------------------------------------------------------------------

/**
 * Register namespace
 */
SplClassLoader::getInstance("app", __DIR__)->register();

//----------------------------------------------------------------------------------------------------------------------