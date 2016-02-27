<?php
namespace app\helpers;

/**
 * QueryHelper class.
 */
class QueryHelper
{
	/**
	 * This method is used to build placeholders from the array.
	 * Example of usage is in WHERE IN condition.
	 * 
	 * @param  array  $data Array with values that need to be bound.
	 * @return string       CSV
	 */
	public static function buildPlaceholders(array $data)
	{
        $arrayOfPlaceholders = array_fill(0, count($data), '?');
        $stringOfPlaceholders = join(',', $arrayOfPlaceholders);
        return $stringOfPlaceholders;
	}
}
