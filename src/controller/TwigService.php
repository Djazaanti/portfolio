<?php
declare(strict_types=1);
namespace Oc\Blog\controller;
class TwigService{

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

    public function getTwig(): Environment
{
    return $this->twig;
}

}