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
        $userModel = new UserModel();
        $user = $userModel->getUserByPseudo($pseudo);
        
        if (is_array($user))
        {
            foreach($user as  $use) {
                if (password_verify($password, $use['password']) === true)
                {
                    if ($use['isValidate'] == 1)
                    {
                        $_SESSION['role'] = $use['role'];
                        $_SESSION['user'] = $use['pseudo'];
                        $_SESSION['userId'] = $use['id'];
                        $_SESSION['isValidate'] = $use['isValidate'];

                        header('location: index.php');
                    }
                    else {
                        echo $this->twigService->get()->render('formularConnexion.html.twig',  ['errorMessage' =>"Veuillez attendre la validation de votre compte, Merci !"]);
                    }
                }
                else
                {
                    echo $this->twigService->get()->render('formularConnexion.html.twig',  ['errorMessage' =>"Vérifiez votre mot de passe."]);
                }
            }

        }
        else
        {
            echo $this->twigService->get()->render('formularConnexion.html.twig',  ['errorMessage' =>"Cet identifiant n'existe pas !"]);
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
