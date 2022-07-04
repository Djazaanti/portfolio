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
    public const ROLE_USER = 'user';

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
    public function verifyConnexion(string $pseudo, string $password) : void 
    {
        $userModel = new UserModel();
        $user = $userModel->getUserByPseudo($pseudo);
        $_SESSION['role'] = $user['role'];
        $_SESSION['user'] = $user['pseudo'];
        $_SESSION['userId'] = $user['id'];
        if ($user['password'] == $password ) {
            header('location: index.php');
        }
        else {
            echo $this->twigService->get()->render('formularConnexion.html.twig',  ['errorMessage' =>"l'utilisateur n'a pas les droits d'accès"]);
        }
    }

    
    /**
     * @return void
     */
    public function formularConnexion() : void
    {
        echo $this->twigService->get()->render('formularConnexion.html.twig');
    }

    public function logout() {
        if (isset($_SESSION) && !empty($_SESSION['user']) ){
            session_destroy();
        } 
        header('location: index.php');
    }
}
    