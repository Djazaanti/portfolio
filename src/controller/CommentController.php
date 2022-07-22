<?php

declare(strict_types=1);

namespace Oc\Blog\controller;

use Oc\Blog\model\CommentModel;
use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * @CommentController Le controller permettant de gérer les commentaires
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
     * @param int $idComment
     * 
     * @return void
     */
    public function deleteComment(int $idComment) : void {
        $commentModel = new CommentModel();
        $commentModel->updateDeleteComment($idComment);

        $_SESSION['SuccessMessage'] = "Commentaire supprimé";
        
        header('location: index.php?dashboard');
    }
    
    /**
     * @param string $comment
     * @param int $user
     * @param int $postId
     * 
     * @return void
     */
    public function sendComment(string $comment, int $user, int $postId) : void
    {
        $commentModel = new CommentModel();
        $commentModel->saveComment($comment, $user, $postId);
        $_SESSION['SuccessMessage'] = "Commentaire envoyé !";

        header('location: index.php?post/'.$postId);
    }

    /**
     * @param int $idComment
     * 
     * @return void
     */
    public function validComment(int $idComment) : void
    {
        $commentModel = new CommentModel();
        $commentModel->updateValidComment($idComment);
        $_SESSION['SuccessMessage'] = "Commentaire validé";
        header('location: index.php?dashboard');
    }
}
