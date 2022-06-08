<?php

namespace Frisbee\views\SignupView;

class SignupView
{
    private static function renderHead()
    {
        $style = 'styles/sign-up.css';
        $title = 'Sign Up';
        ob_start();
        require $GLOBALS['base_dir'] . 'views/templates/head.php';
        $head = ob_get_contents();
        ob_end_clean();
        return $head;
    }

    private static function renderBody(array $warnings)
    {

        ob_start();
        require $GLOBALS['base_dir'] . 'views/templates/signupBody.php';
        $body = ob_get_contents();
        ob_end_clean();
        return $body;
    }

    public static function renderSignupPage(array $warnings = [])
    {
        $head = self::renderHead();
        $body = self::renderBody($warnings);
        require $GLOBALS['base_dir'] . 'views/templates/html.php';
    }
}
