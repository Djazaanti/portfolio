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
        $templatesPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'view';
        $loader = new FilesystemLoader($templatesPath, getcwd());

        // On configure twig (on ajoute le mode "debug" et on supprime le "cache")
        $twig = new Environment($loader, [
            'debug' => true,
            'cache' => false
        ]);

        // On active le var_dump() de twig pour debugger
        $twig->addExtension(new DebugExtension());
        $twig->addGlobal('session', $_SESSION);

        $this->twig = $twig;
    }

    /**
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
     * @return Environment
     */
    public function get(): Environment
    {
        return $this->twig;
    }
}