<?php

declare(strict_types=1);

namespace Oc\Blog\controller;

use Oc\Blog\model\PostModel;
use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


/**
 * BlogController Le controller permettant de gérer les blogs
 */
class BlogController
{
    /**
     * @var TwigService Twig
     */
    private TwigService $twigService;

    /**
     * @param TwigService $twig Le service twig
     */
    public function __construct(TwigService $twig)
    {
        // Je stock la configuration du service twig dans notre variable twig du controller
        $this->twigService = $twig;
    }

    /**
     * @return void
     */
    public function showBlog(): void
    {
        $postModel = new PostModel();
        $posts = $postModel->getPosts();
        echo $this->twigService->get()->render('blog.html.twig', ['posts' => $posts]);
    }
}
