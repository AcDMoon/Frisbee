<?php

namespace application\views\RestorePasswordView;

class RestorePasswordView
{
    public static function renderRestorePage($data = [])
    {
        $head = self::renderHead();
        $body = self::renderBody($data);
        require 'application/views/templates/html.php';
    }

    private static function renderHead()
    {
        $style = 'public/styles/sign-up.css';
        $title = 'Restore Password';
        ob_start();
        require 'application/views/templates/head.php';
        $head = ob_get_contents();
        ob_end_clean();
        return $head;
    }


    private static function renderBody($data)
    {
        if (isset($data['emailFromHash'])) {
            ob_start();
            require 'application/views/templates/restorePasswordBody(passwordForm).php';
            $body = ob_get_contents();
            ob_end_clean();
            return $body;
        }
        ob_start();
        require 'application/views/templates/restorePasswordBody(emailForm).php';
        $body = ob_get_contents();
        ob_end_clean();
        return $body;
    }
}
