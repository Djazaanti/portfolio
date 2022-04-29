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
    private static ?TwigService $_instance;

    /**
     * le constructeur de la classe
     */
    private function __construct()
    {
        // On créé le systeme de fichier Twig pour retrouver les vues (html) qui seront dans le dossier '../src/view'
        $templatesPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'view';
        // $rootPath = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR;
        $loader = new FilesystemLoader($templatesPath, getcwd());

        // On configure twig (on ajoute le mode "debug" et on supprime le "cache")
        $twig = new Environment($loader, [
            'debug' => true,
            'cache' => false //__DIR__ .'/tmp'
        ]);

        // On active le var_dump() de twig pour debugger
        $twig->addExtension(new DebugExtension());
        $twig->addGlobal('session', $_SESSION);

        // Je stock la configuration twig dans notre variable twig du controller
        $this->twig = $twig;
    }

    /**
     * Permet d'instancier la classe une seule fois pour tout le projet (Singleton Pattern).
     * @see https://grafikart.fr/tutoriels/singleton-569
     * @return TwigService
     */
    public static function getInstance(): TwigService
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new TwigService();
        }

        return self::$_instance;
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