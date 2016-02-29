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

    /**
     * Method that is returning URL to the process folder and submitted script inside it.
     * 
     * @param  string $path path to the script inside process folder.
     * @return string       full URL to the given script
     */
    public static function process($path)
    {
        return '/'.APP_NAME."/process/".$path;
    }

    /**
     * Method that is returning URL to the process/backend/ folder and submitted script inside it.
     * 
     * @param  string $path path to the script inside process/backend/ folder.
     * @return string       full URL to the given script
     */
    public static function processBackend($path)
    {
        return '/'.APP_NAME."/process/backend/".$path;
    }    
}