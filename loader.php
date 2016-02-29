<?php	
error_reporting(E_ALL);
ini_set("display_errors", 1);

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
define('APP_NAME', 'start');
 
// DIRECTORY_SEPARATOR is a PHP pre-defined constant ( \ for windows, / for Unix )
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR); 
 
// Site root path for the file system
defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'var'.DS.'www'.DS.'html'.DS.APP_NAME.DS);

// Path to "includes" folder
defined('INCLUDES') ? null : define('INCLUDES', SITE_ROOT.'includes'.DS);

// Path to "lib" folder
defined('LIB') ? null : define('LIB', SITE_ROOT.'lib'.DS);

// Path to "process" folder
defined('PROCESS') ? null : define('PROCESS', SITE_ROOT.'process'.DS);

//----------------------------------------------------------------------------------------------------------------------

/**
 * Include config, SplClassLoader, and password library
 */
require_once INCLUDES.'config.php';
require_once INCLUDES.'SplClassLoader.php';
require_once LIB.'password.php';
 
//----------------------------------------------------------------------------------------------------------------------

/**
 * Register namespace
 */
SplClassLoader::getInstance("app", __DIR__)->register();

//----------------------------------------------------------------------------------------------------------------------
