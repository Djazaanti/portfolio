<?php

namespace Oc\Blog\controller;

use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

use Oc\Blog\model\UserModel;

class HomeController
{
    /**
     * @var TwigService Twig
     */
    private TwigService $twigService;

    /**
     * @param TwigService $twigService
     */
    public function __construct(TwigService $twigService)
    {
        // Je stock la configuration twig dans notre variable twig du controller
        $this->twigService = $twigService;
    }

    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function showHome() : void
    {
        $twig = $this->twigService->get();
        $userModel = new UserModel();

        // c'est mon parcours, pas des articles, je dois les renommer : issue -latest changes
        $posts = $userModel->getPostsHome();

        echo $twig->render('home.html.twig', ['posts' => $posts]);
    }
}
