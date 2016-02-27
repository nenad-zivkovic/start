<?php
namespace app\components\web;

/**
 * Html class
 */
class Html
{
    /**
     * Encodes special characters into HTML entities.
     * 
     * @param string $content the content to be encoded
     * @return string         the encoded content
     */
    public static function encode($content)
    {
        return htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, APP_CHARSET);
    }
}