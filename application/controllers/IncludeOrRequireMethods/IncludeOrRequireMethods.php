<?php

namespace Frisbee\controllers\IncludeOrRequireMethods;

class IncludeOrRequireMethods
{
    public static function includeTemplate(string $template, array $data = [])
    {
    }


    public static function requireTemplate(string $template, array $data = [], $buffer = true)
    {
        extract($data);
        if ($buffer) {
            ob_start();
            require $GLOBALS['base_dir'] . 'views/templates/' . $template;
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }
        require $GLOBALS['base_dir'] . 'views/templates/' . $template;
    }


    public static function includeFile(string $path)
    {
    }


    public static function requireFile(string $path)
    {
    }

    public static function requireConfig(string $config)
    {
        $configData = require $GLOBALS['base_dir'] . 'config/' . $config;
        return $configData;
    }
}
