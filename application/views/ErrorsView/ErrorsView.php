<?php

namespace Frisbee\views\ErrorsView;

use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;

class ErrorsView
{
    private static function renderHead($error)
    {
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
        $style = 'http://' . $domain['domain'] . '/styles/sign-up.css';
        $title = $error['title'];
        $data = compact('style', 'title');
        return IncludeOrRequireMethods::requireTemplate('head.php', $data);
    }

    private static function renderBody($error, $errorDescription = '')
    {
        $h = $error['h'];
        $header = $error['header'];

        if (!$errorDescription) {
            $errorDescription = $error['description'];
        }
        $data = compact('h', 'errorDescription', 'header');
        return IncludeOrRequireMethods::requireTemplate($error['template'], $data);
    }


    public static function renderErrorPage(string $errorType, string $errorDescription = '')
    {
        $error = IncludeOrRequireMethods::requireConfig('errors.php')[$errorType];
        $head = self::renderHead($error);
        $body = self::renderBody($error, $errorDescription);
        $data = compact('body', 'head');
        IncludeOrRequireMethods::requireTemplate('html.php', $data, false);
    }
}
