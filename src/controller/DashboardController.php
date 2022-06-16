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
        // Je stock la configuration twig dans notre variable twig du controller
        $this->twigService = $twigService;
    }

    /**
     * @return void
     */
    public function dashboard() : void {

        $commentModel = new CommentModel();
        $commentaires = $commentModel->getCommentairesAValider();
        $userModel = new UserModel();
        $admins = $userModel->getAdmins();

        echo $this->twigService->get()->render('admin/dashboard.html.twig', ['commentaires' => $commentaires, 'admins' => $admins]);
    }


    /**
     * @param string $title
     * @param string $content
     * @param string $chapo
     * @param string $media
     * @param string $isPublished
     * @param mixed $createdAt
     * @param string $userId
     * 
     * @return void
     */
    public function addPost(string $title, string $content, string $chapo, string $media, string $isPublished, mixed $createdAt, string $userId) : void {
        $title = htmlspecialchars($title);
        $content = htmlspecialchars($content);
        $chapo = htmlspecialchars($chapo);
        $userId =  intval($userId);
        
        $postModel = new PostModel();
        $retunReq = $postModel->insertPostInDB($title, $content, $chapo, $media, $isPublished, $createdAt, $userId);

        header('location: index.php?dashboard');

    }
}
