<?php

declare(strict_types=1);

namespace Oc\Blog\controller;

use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

use Oc\Blog\model\UserModel;

/**
 * @UserController Le controller permettant de gérer l'utilisateur
 */
class UserController
{
    /**
     * @var TwigService Twig
     */
    private TwigService $twigService;
    protected UserModel  $userModel;

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

    // public function showUsers()
    // {
    //     $userModel = new UserModel();
    //     $users = $userModel->getUsers();
    //     echo $this->twigService->get()->render('user.html.twig', ['users' => $users]);
    // }

    /**
     * @return [type]
     */
    public function showPosts(){
        $userModel = new UserModel();
        $posts = $userModel->getPosts();
        echo $this->twigService->get()->render('posts.html.twig', ['posts' => $posts]); 
    }

    /**
     * @param mixed $id
     * 
     * @return [type]
     */
    public function showPostAndComments($id){
        $userModel = new UserModel();
        $post = $userModel->getPost($id);
        $comments = $userModel->getComments($id);
        echo $this->twigService->get()->render('post.html.twig', ['comments' => $comments, 'post' => $post]);
    }
}
