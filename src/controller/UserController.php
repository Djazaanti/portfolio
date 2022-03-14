<?php

declare(strict_types=1);

namespace Oc\Blog\controller;

use Oc\Blog\model\UserModel;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class UserController
{
    private Environment $twig;

    public function _construct()
    {
        // On créé le systeme de fichier Twig pour retrouver les vues (html)
        $loader = new FilesystemLoader('src/view');

        // On configure twig (on ajoute le mode "debug" et on supprime le "cache")
        $twig = new Environment($loader, [
            'debug' => true,
            'cache' => false //__DIR__ .'/tmp'
        ]);

        // On active le var_dump() de twig pour debugger
        $twig->addExtension(new DebugExtension());

        // Je stock la configuration twig dans notre variable twig du controller
        $this->twig = $twig;
    }
    

    public function displayText(){
        printf("hello de UserController() \n ");
        $this->twig->render('home.twig');
    }

    /**
     * - récupérer les informations des utilisateurs
     * - afficher les utilisateurs
     */
    public function showUsers()
    {
//        $userModel = new UserModel();
//        $users = $userModel->getUsers();
        $users = [
            [
                'id' => 1,
                'pseudo' => 'Djazaanti'
            ],
        ];

        $this->twig->render('home.twig', [$users]);
    }

}
