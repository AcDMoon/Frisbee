<?php

namespace Frisbee\views\pageWithOnlyOnePrepositionView;

use Frisbee\controllers\IncludeOrRequireMethods\IncludeOrRequireMethods;

class pageWithOnlyOnePrepositionView
{
    private static function renderHead($pageWithOnlyOnePreposition)
    {
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php');
        $style = 'http://' . $domain['domain'] . '/styles/sign-up.css';
        $title = $pageWithOnlyOnePreposition['title'];
        $data = compact('style', 'title');
        return IncludeOrRequireMethods::requireTemplate('head.php', $data);
    }

    private static function renderBody($pageWithOnlyOnePreposition)
    {
        $h = $pageWithOnlyOnePreposition['h'];
        $data = compact('h');
        return IncludeOrRequireMethods::requireTemplate($pageWithOnlyOnePreposition['template'], $data);
    }


    public static function renderSimplePage($pageType)
    {
        $pageWithOnlyOnePreposition = IncludeOrRequireMethods::requireConfig('pageWithOnlyOnePreposition.php')[$pageType];
        $head = self::renderHead($pageWithOnlyOnePreposition);
        $body = self::renderBody($pageWithOnlyOnePreposition);
        $data = compact('body', 'head');
        IncludeOrRequireMethods::requireTemplate('html.php', $data, false);
    }
}

