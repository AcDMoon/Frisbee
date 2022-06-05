<?php

namespace application\views\RestorePasswordView;

class RestorePasswordView
{
    public static function renderRestorePage($email = '', $emailWarnings = '', $emailFromHash = '', $password = '')
    {
        self::renderHead();
        self::renderBody($email, $emailWarnings, $emailFromHash, $password);
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
       if ($data['emailFromHash']){
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


        //Ничего не пришло - форма с email
        //пришёл email и emailError - выводим ошибки
        //пришёл emailFromHash - форма с паролем и + js


    }


}