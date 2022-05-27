<?php

namespace application\views\LoginView;



class LoginView
{
    private static function renderHead()
    {
        $style = 'public/styles/sign-up.css';
        $title = 'Log In';
        ob_start();
        require 'application/views/templates/head.php';
        $head = ob_get_contents();
        ob_end_clean();
        return $head;
    }

    private static function renderBody(array $warnings, string $destination)
    {

        ob_start();
        require 'application/views/templates/loginBody.php';
        $body = ob_get_contents();
        ob_end_clean();
        return $body;
    }

    public static function renderLoginPage(array $warnings = [], string $destination = '')
    {
        $head = self::renderHead();
        $body = self::renderBody($warnings, $destination);
        require 'application/views/templates/html.php';
    }
}