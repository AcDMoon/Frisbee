<?php

namespace Frisbee\views\RestorePasswordView;

use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;

class RestorePasswordView
{
    public static function renderRestorePage($data = [])
    {
        $head = self::renderHead();
        $body = self::renderBody($data);

        $scriptPath = '/scripts/restorePasswordScript.js';
        $requireData = compact('scriptPath');
        $script = IncludeOrRequireMethods::requireTemplate('script.php', $requireData);

        $data = compact('body', 'head', 'script');
        IncludeOrRequireMethods::requireTemplate('html.php', $data, false);
    }

    private static function renderHead()
    {
        $style = 'styles/sign-up.css';
        $title = 'Restore Password';
        $data = compact('style', 'title');
        $head = IncludeOrRequireMethods::requireTemplate('head.php', $data);
        return $head;
    }


    private static function renderBody($data)
    {
        if (isset($data['emailFromHash'])) {
            $data = compact('data');
            $body = IncludeOrRequireMethods::requireTemplate('restorePasswordBody(passwordForm).php', $data);
            return $body;
        }
        $data = compact('data');
        $body = IncludeOrRequireMethods::requireTemplate('restorePasswordBody(emailForm).php', $data);
        return $body;
    }
}
