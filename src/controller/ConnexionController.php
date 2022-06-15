<?php

declare(strict_types=1);

namespace Oc\Blog\controller;

use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

use Oc\Blog\model\UserModel;

class ConnexionController{

    private TwigService $twigService;

    public const ROLE_ADMIN = 'admin';

    public function __construct(TwigService $twig){
        // Je stock la configuration du service twig dans notre variable twig du controller
        $this->twigService = $twig;
    }
    
    
    /**
     * @param string $pseudo
     * @param string $password
     * 
     * @return void
     */
    public function verifyConnexionAdmin(string $pseudo, string $password) : void 
    {
        $userModel = new UserModel();
        $user = $userModel->getUserByPseudo($pseudo);

        if ($user['password'] == $password && $user['role'] == self::ROLE_ADMIN )  {
            //  template admin page 'dashboard'
            echo $this->twigService->get()->render('admin/dashboard.html.twig');
        }
        else {
            echo $this->twigService->get()->render('formularConnexionAdmin.html.twig',  ['errorMessage' =>"l'utilisateur n'a pas les droits d'accès"]);
        }
    }

    
    /**
     * @return void
     */
    public function formularConnexionAdmin() : void
    {
        echo $this->twigService->get()->render('formularConnexionAdmin.html.twig');
    }
}
