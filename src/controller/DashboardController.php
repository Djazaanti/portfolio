<?php

declare(strict_types=1);

namespace OC\Blog\controller;

use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

use Oc\Blog\model\CommentModel;
use Oc\Blog\model\PostModel;
use Oc\Blog\model\UserModel;


class DashboardController{
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
     */
    public function dashboard() : void {

        $commentModel = new CommentModel();
        $commentsToValid = $commentModel->getCommentsToValid();
        $NbCommentsToValid = $commentModel->countCommentsToValid();

        $userModel = new UserModel();
        $admins = $userModel->getAdmins();
        $NbUsersValidated = $userModel->countUsersValidated();
        $NbUsersToValid = $userModel->countUsersToValid();

        $postModel = new PostModel();
        $posts = $postModel->getPosts();
        $NbPostsToPublish = $postModel->countPostsToPublish();
        $NbPostsPublished = $postModel->countPostsPublished();
        
        $_SESSION['page'] = "dashboard";
        echo $this->twigService->get()->render('admin/dashboard.html.twig', ['commentsToValid' => $commentsToValid, 'admins' => $admins, 'posts' => $posts, 'NbCommentsToValid' => $NbCommentsToValid, 'NbUsersValidated' => $NbUsersValidated, 'NbUsersToValid' => $NbUsersToValid, 'NbPostsToPublish' => $NbPostsToPublish, 'NbPostsPublished' => $NbPostsPublished]);

        $_SESSION["SuccessMessage"] = "";
        $_SESSION["ErrorMessage"] = "";
    }


    /**
     * @param int $idComment
     * 
     * @return void
     */
    public function validComment(int $idComment) : void {
        
        $commentModel = new CommentModel();
        $commentModel->updateValidComment($idComment);
        $_SESSION['SuccessMessage'] = "Commentaire validé";
        header('location: index.php?dashboard');
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

}
