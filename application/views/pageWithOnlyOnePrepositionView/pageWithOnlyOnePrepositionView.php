<?php

namespace Frisbee\views\pageWithOnlyOnePrepositionView;

use Frisbee\views\IncludeOrRequireMethods\IncludeOrRequireMethods;

class pageWithOnlyOnePrepositionView
{
    private static function renderHead($pageWithOnlyOnePreposition, $domain)
    {
        $style = 'http://' . $domain . '/styles/sign-up.css';
        $title = $pageWithOnlyOnePreposition['title'];
        $data = compact('style', 'title');
        return IncludeOrRequireMethods::requireTemplate('head.php', $data);
    }

    private static function renderBody($pageWithOnlyOnePreposition, $domain)
    {
        $h = $pageWithOnlyOnePreposition['h'];
        $data = compact('h', 'domain');
        return IncludeOrRequireMethods::requireTemplate($pageWithOnlyOnePreposition['template'], $data);
    }


    public static function renderSimplePage($pageType)
    {
        $domain = IncludeOrRequireMethods::requireConfig('validDomain.php')['domain'];
        $pageWithOnlyOnePreposition = IncludeOrRequireMethods::requireConfig('pageWithOnlyOnePreposition.php')[$pageType];
        $head = self::renderHead($pageWithOnlyOnePreposition, $domain);
        $body = self::renderBody($pageWithOnlyOnePreposition, $domain);
        $data = compact('body', 'head');
        IncludeOrRequireMethods::requireTemplate('html.php', $data, false);
    }
}

