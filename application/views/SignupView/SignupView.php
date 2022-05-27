<?php

namespace application\views\SignupView;

class SignupView
{
    private static function renderHead()
    {
        $style = 'public/styles/sign-up.css';
        $title = 'Sign Up';
        ob_start();
        require 'application/views/templates/head.php';
        $head = ob_get_contents();
        ob_end_clean();
        return $head;
    }

    private static function renderBody(array $warnings)
    {

        ob_start();
        require 'application/views/templates/signupBody.php';
        $body = ob_get_contents();
        ob_end_clean();
        return $body;
    }

    public static function renderSignupPage(array $warnings = [])
    {
        $head = self::renderHead();
        $body = self::renderBody($warnings);
        require 'application/views/templates/html.php';
    }
}
