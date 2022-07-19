<?php
declare(strict_types=1);

namespace Oc\Blog\controller;

use Oc\Blog\model\PostModel;
use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
        $this->twigService = $twigService;
    }

    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function showHome(): void
    {
        $twig = $this->twigService->get();
        $postModel = new PostModel();

        // ceci est mon parcours, pas des articles, je dois les renommer : issue -latest changes
        $posts = $postModel->getPostsHome();

        echo $twig->render('home.html.twig', ['posts' => $posts]);
    }
}
