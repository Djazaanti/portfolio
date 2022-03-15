<?php

declare(strict_types=1);

namespace Oc\Blog\controller;

use Oc\Blog\model\UserModel;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class UserController
{
    private TwigService $twig;

    public function _construct(TwigService $twig)
    {
        // Je stock la configuration twig dans notre variable twig du controller
        $this->twig = $twig;
    }
    

    public function displayText(){
        printf("hello de UserController() \n ");
        $this->twig->getTwig()->render('home.twig');
    }

    /**
     * - récupérer les informations des utilisateurs
     * - afficher les utilisateurs
     */
    public function showUsers()
    {
        $userModel = new UserModel();
        $users = $userModel->getUsers();
        /*$users = [
            [
                'id' => 1,
                'pseudo' => 'Djazaanti'
            ],
        ];*/
        $this->twig->getTwig()->render('home.html.twig', [$users]);
        var_dump($this->twig);
    }

}
