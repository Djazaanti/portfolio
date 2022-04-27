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
    public function submitFormContact($name, $lastname, $email, $message){
        $submitContact = $contactModel->insertFormContact($name, $lastname, $email, $message);
        if ($submitContact === false) {
            // die('Impossible d\'enregistrer ce formulaire de contact !');
            $this->twigService->get()->render('contactSection.html.Twig', "impossible d\'enregistrer ce formulaire de contact ! ");
        }
        else {
            
            echo $this->twigService->get()->render('contactSection.html.Twig', ['emailcontact' => $email] );
        }
    }
    public function showUsers()
    {
        $userModel = new UserModel();
        $users = $userModel->getUsers();
        echo $this->twigService->get()->render('user.html.twig', ['users' => $users]);
    }


    public function showPosts(){
        $userModel = new UserModel();
        $posts = $userModel->getPosts();
        // pointe vers la page listant tous les posts : à mettre le CSS
        echo $this->twigService->get()->render('posts.html.twig', ['posts' => $posts]); 
    }

    public function showPostAndComments($id){
        $userModel = new UserModel();
        $post = $userModel->getPost($id);
        $comments = $userModel->getComments($id);
       // var_dump($post); die;
        echo $this->twigService->get()->render('post.html.twig', [ 'comments' => $comments, 'post' => $post]);
    }

}
