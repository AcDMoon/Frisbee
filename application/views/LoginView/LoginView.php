<?php

namespace Frisbee\views\LoginView;

use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;

class LoginView
{
    private static function renderHead()
    {
        $style = 'styles/sign-up.css';
        $title = 'Log In';
        $data = compact('style', 'title');
        $head = IncludeOrRequireMethods::requireTemplate('head.php', $data);
        return $head;
    }

    private static function renderBody(array $warnings, string $destination)
    {
        $data = compact('warnings', 'destination');
        $body = IncludeOrRequireMethods::requireTemplate('loginBody.php', $data);
        return $body;
    }

    public static function renderLoginPage(array $warnings = [], string $destination = '')
    {
        $head = self::renderHead();
        $body = self::renderBody($warnings, $destination);
        $data = compact('body', 'head', 'warnings', 'destination');
        IncludeOrRequireMethods::requireTemplate('html.php', $data, false);
    }
}