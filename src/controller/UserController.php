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


class UserController{
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
    public function addUserFormular() : void {
        echo $this->twigService->get()->render('admin/addUserFormular.html.twig');
    }

  
    /**
     * @param string $pseudo
     * @param string $email
     * @param string $password
     * 
     * @return void
     */
    public function addUser(string $pseudo, string $email, string $password) : void {

        $userModel = new UserModel();
        $userModel->saveUser($pseudo, $email, $password);
        
        header('location: index.php?connexion');
    }
}