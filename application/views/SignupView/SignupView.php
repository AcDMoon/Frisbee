<?php

namespace Frisbee\views\SignupView;

use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;

class SignupView
{
    private static function renderHead()
    {
        $style = 'styles/sign-up.css';
        $title = 'Sign Up';
        $data = compact('style', 'title');
        $head = IncludeOrRequireMethods::requireTemplate('head.php', $data);
        return $head;
    }

    private static function renderBody(array $warnings)
    {
        $data = compact('warnings');
        $body = IncludeOrRequireMethods::requireTemplate('signupBody.php', $data);
        return $body;
    }

    public static function renderSignupPage(array $warnings = [])
    {
        $head = self::renderHead();
        $body = self::renderBody($warnings);
        $data = compact('body', 'head');
        IncludeOrRequireMethods::requireTemplate('html.php', $data, false);
    }
}
