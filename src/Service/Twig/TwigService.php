<?php
namespace App\Service\Twig;

use Twig\Environment;
use Twig\TwigFunction;

class TwigService
{
    protected $twig;


    public function __construct(Environment $twig)
    {
        $this->twig = $twig;

        $getName = new TwigFunction('getName');
        $twig->addFunction($getName);

        $inArray = new TwigFunction('inArray');
        $twig->addFunction($inArray);

    }

    public function getName() {
        if (isset($_SESSION['adminName'])):
            echo $_SESSION['adminName'];
//        else:
//            echo "logout";
        endif;
    }

    public function inArray($needle, $haystack): bool
    {
        return in_array($needle, $haystack);
    }
}