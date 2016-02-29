<?php
namespace app\helpers;

/**
 * UtilsHelper class.
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
}
