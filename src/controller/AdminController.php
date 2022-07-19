<?php

declare(strict_types=1);

namespace OC\Blog\controller;

use Oc\Blog\model\PostModel;
use Oc\Blog\model\UserModel;
use OC\Blog\service\TwigService;
use Twig\error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


class AdminController
{

    private TwigService $twigService;

    /**
     * @param TwigService $twig
     */
    public function __construct(TwigService $twig)
    {
        // Je stock la configuration du service twig dans notre variable twig du controller
        $this->twigService = $twig;
    }

    // Ne semble pas être utiliser => A supprimer
    /**
     * @return void
     */
    public function allAdmins(): void
    {
        $userModel = new UserModel();
        $admins = $userModel->getAdmins();

        echo $this->twigService->get()->render('admin/dashboard.html.twig', ['admins' => $admins]);
    }

    /**
     * @return void
     */
    public function adminPosts(): void
    {
        $postModel = new PostModel();
        $posts = $postModel->getAdminPosts();

        echo $this->twigService->get()->render('admin/adminPosts.html.twig', ['posts' => $posts]);

        $_SESSION["SuccessMessage"] = "";
        $_SESSION["ErrorMessage"] = "";
    }


    /**
     * @param int $id
     *
     * @return void
     */
    public function adminPostDetails(int $id): void
    {
        $postModel = new PostModel();
        $post = $postModel->getPost($id);

        $userModel = new UserModel();
        $admins = $userModel->getAdmins();

        echo $this->twigService->get()->render('admin/adminPostDetails.html.twig', ['post' => $post, 'admins' => $admins]);

        $_SESSION["SuccessMessage"] = "";
        $_SESSION["ErrorMessage"] = "";
    }

}
