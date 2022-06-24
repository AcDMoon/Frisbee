<?php

namespace Frisbee\views\IncludeOrRequireMethods;

class IncludeOrRequireMethods
{
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


    public static function requireConfig(string $config)
    {
        $configData = require $GLOBALS['base_dir'] . 'config/' . $config;
        return $configData;
    }
}
