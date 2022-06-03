<?php

declare(strict_types=1);

namespace Oc\Blog\controller;

use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

use Oc\Blog\model\PostModel;
use Oc\Blog\model\CommentModel;


/**
 * @UserController Le controller permettant de gérer l'utilisateur
 */
class PostController
{
    /**
     * @var TwigService Twig
     */
    private TwigService $twigService;

    /**
     * Le constructeur de la classe UserController.
     * Il attend en paramètre twig pour afficher les vues
     * @param TwigService $twig Le service twig
     */
    public function __construct(TwigService $twig)
    {
        // Je stock la configuration du service twig dans notre variable twig du controller
        $this->twigService = $twig;
    }

    /**
     * @param int $id
     * 
     * @return void
     */
    public function showPostAndComments(int $id) : void{
        $postModel = new PostModel();
        $commentModel = new CommentModel();
        $post = $postModel->getPost($id);
        $comments = $commentModel->getComments($id);
        echo $this->twigService->get()->render('post.html.twig', ['comments' => $comments, 'post' => $post]);
    }
}
