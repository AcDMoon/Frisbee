<?php

namespace Frisbee\views\SignupView;

use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;

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
        $emailErrors = $passwordErrors = $nameErrors = $dateErrors = '';
        foreach ($warnings as $warningType => $warningsList) {
            ob_start();
            foreach ($warningsList as $error) {
                $data = compact('error');
                IncludeOrRequireMethods::requireTemplate('signupErrors.php', $data, false);
            }
            ${$warningType} = ob_get_contents();
            ob_end_clean();
        }

        $data = compact('emailErrors', 'passwordErrors', 'nameErrors', 'dateErrors');
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
