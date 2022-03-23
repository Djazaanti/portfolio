<?php

declare(strict_types=1);

namespace Oc\Blog\controller;


use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * @UserController Le controller permettant de gérer l'utilisateur
 */
class UserController
{
    /**
     * @var TwigService Twig
     */
    private TwigService $twigService;

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

    /**
     * Fonction test pour d'afficher la home page
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function displayText()
    {
        // On affiche le template twig home.html.twig
        echo $this->twigService->get()->render('home.html.twig');
    }

    /**
     * Fonction pour :
     * - récupérer les informations des utilisateurs
     * - afficher les utilisateurs
     */
    public function showUsers()
    {
//        $userModel = new UserModel();
//        $users = $userModel->getUsers();
        // On récupère des faux utilisateurs, une fois le UserModel fonctionnel
        // Tu peux remplacer la ligne ci-dessous par les lignes 51 et 52.
        // La fonction mockUsers() est just pour tester sans la base de données.
        $users = $this->mockUsers();

        // On affiche les utilisateurs dans le template twig home.html.twig
        echo $this->twigService->get()->render('home.html.twig', ['users' => $users]);
    }

    /**
     * Fonction qui permet de créer des faux utilisateurs.
     * @return array[]
     */
    private function mockUsers() : array
    {
        return [
            [
                'id' => 1,
                'pseudo' => 'Djazaanti'
            ],
            [
                'id' => 2,
                'pseudo' => 'Toto'
            ]
        ];
    }

}
