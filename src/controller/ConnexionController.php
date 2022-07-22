<?php

declare(strict_types=1);

namespace Oc\Blog\controller;

use Oc\Blog\model\UserModel;
use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ConnexionController
{

    /**
     * @var TwigService
     */
    private TwigService $twigService;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';

    /**
     * @param TwigService $twig
     */
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
    public function verifyConnexion(string $pseudo, string $password): void
    {
        
        $pass = password_hash("Luna", PASSWORD_DEFAULT);
        // echo($pass);

        $userModel = new UserModel();
        $user = $userModel->VerifyUser($pseudo, $password);
        if ($user != [] && $_SESSION['isValidate'] == 1)
        {
            $_SESSION['role'] = $user['role'];
            $_SESSION['user'] = $user['pseudo'];
            $_SESSION['userId'] = $user['id'];
            $_SESSION['isValidate'] = $user['isValidate'];

            header('location: index.php');
        }
        
        else {
            echo $this->twigService->get()->render('formularConnexion.html.twig',  ['errorMessage' =>"Vérifiez votre mot de passe. Sinon, réessayez une fois votre compte validé !", "pass" => $pass]);
        }
    }
    
    /**
     * @return void
     */
    public function formularConnexion() : void
    {
        echo $this->twigService->get()->render('formularConnexion.html.twig');
    }

    /**
     * @return void
     */
    public function logout() : void
    {
        if (isset($_SESSION) && !empty($_SESSION['user']) ){
            session_destroy();
        } 
        header('location: index.php');
    }
}
    