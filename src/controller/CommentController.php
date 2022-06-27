<?php

declare(strict_types=1);

namespace Oc\Blog\controller;

use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

use Oc\Blog\model\CommentModel;


/**
 * @UserController Le controller permettant de gérer l'utilisateur
 */
class CommentController
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
     * @return void
     */
    public function addCommentFormular($postId) : void {
        $idOfPost = $postId; 
        echo $this->twigService->get()->render('addComment.html.twig', ['idOfPost' => $idOfPost]);
    }

    /**
     * @param mixed $comment
     * @param mixed $user
     * 
     * @return void
     */
    public function sendComment($comment, $user, $postId) : void {
          $commentModel = new CommentModel();
        $commentModel->saveComment($comment, $user, $postId);
    }
}
