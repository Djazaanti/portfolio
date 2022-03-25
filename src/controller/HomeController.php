<?php
namespace Oc\Blog\controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Oc\Blog\controller\TwigService;

class HomeController{

    public function __construct(TwigService $twig)
    {
        // Je stock la configuration twig dans notre variable twig du controller
        $this->twig = $twig;
    }
     public function showHome()
    {
        $this->twig->getTwig()->render('home.html.twig');
    }
}