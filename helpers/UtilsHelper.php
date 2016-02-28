<?php
namespace app\helpers;

/**
 * UtilsHelper class.
 * @todo Maybe some of the methods here can go to some routing component.
 */
class UtilsHelper
{
	/**
	 * Converts text encoding from windows-1250 to utf-8.
	 * 
	 * @param  mixed $data Array|String with text to convert.
	 * @return mixed       Array|String with converted text.
	 */
	public static function toUtf8($data) 
	{
		if (is_scalar($data)) {
			return iconv("windows-1250", "utf-8", $data);
		}

		foreach ($data as $key => $value) {
			$data[$key] = self::toUtf8($value);
		}

		return $data;
	}

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
}
