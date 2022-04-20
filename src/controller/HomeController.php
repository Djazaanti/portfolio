<?php
// On ajoute le namespace grâce à composer
// https://grafikart.fr/tutoriels/autoload-561
// https://grafikart.fr/tutoriels/namespaces-563
namespace Oc\Blog\controller;

use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

use Oc\Blog\model\UserModel;

class HomeController
{
    /**
     * @var TwigService Twig
     */
    private TwigService $twigService;

    /**
     * On fait un constructeur pour pouvoir utiliser notre service twig dans la classe
     * https://grafikart.fr/tutoriels/class-poo-555
     * @param TwigService $twigService
     */
    public function __construct(TwigService $twigService)
    {
        // Je stock la configuration twig dans notre variable twig du controller
        $this->twigService = $twigService;
    }

    /**
     * On affiche la page home.
     *
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function showHome(): void
    {
        $twig = $this->twigService->get();
        $userModel = new UserModel();
        $posts = $userModel->getPostsHome();

        echo $twig->render('home.html.twig', ['posts' => $posts]);
    }
}
