<?php
namespace app\components\web;

/**
 * UrlManager class.
 */
class UrlManager
{
    /**
     * Redirects the user to the site home page.
     */
    public static function goHome()
    {
        header('Location: /'.APP_NAME);
        exit();
    }

    /**
     * Redirects the user to the site home page.
     */
    public static function goToRegistrationForm()
    {
        header('Location: /'.APP_NAME.'/register.php');
        exit();
    }

    /**
     * Redirects the user to the members home page.
     */
    public static function goToMembersHome()
    {
        header('Location: /'.APP_NAME.'/backend/home.php');
        exit();
    }

    /**
     * Redirects to the given page ( page is the part of this application ).
     * 
     * @param  string $page
     */
    public static function redirectTo($page)
    {
        header('Location: /'.APP_NAME.'/'.$page);
        exit();
    }
}