<?php

namespace Oc\Blog\service;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 * @TwigService Classe qui permet d'instancier Twig
 */
class TwigService
{
    /** @var Environment Twig environment to display */
    private Environment $twig;

    /**
     * le constructeur de la classe
     */
    public function __construct()
    {
        // On créé le systeme de fichier Twig pour retrouver les vues (html)
        $loader = new FilesystemLoader('../src/view');

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

    /**
     * On permet d'accéder à l'attribut twig via le getter
     * @see https://www.bgmp.fr/la-programmation-orientee-objet-en-php/
     * @return Environment
     */
    public function get(): Environment
    {
        return $this->twig;
    }

}
