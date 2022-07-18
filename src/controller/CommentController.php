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
     * @param TwigService $twig Le service twig
     */
    public function __construct(TwigService $twig)
    {
        // Je stock la configuration du service twig dans notre variable twig du controller
        $this->twigService = $twig;
    }

    /**
     * @param int $postId
     * 
     * @return void
     */
    public function addCommentFormular(int $postId) : void {
        echo $this->twigService->get()->render('addComment.html.twig', ['postId' => $postId]);
    }

    /**
     * @param string $comment
     * @param id $user
     * @param id $postId
     * 
     * @return void
     */
    public function sendComment(string $comment, int $user, int $postId) : void {
        $commentModel = new CommentModel();
        $commentModel->saveComment($comment, $user, $postId);
        $_SESSION['SuccessMessage'] = "Commentaire envoyé !";

        header('location: index.php?post/'.$postId);
    }
}
