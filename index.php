<?php
declare(strict_types=1);

// On charge l'autoloader de composer afin d'avoir accès aux dépendances du projet comme Twig
require_once('vendor/autoload.php');

use Oc\Blog\controller\UserController;
use Oc\Blog\service\TwigService;

$twigService = new TwigService(); 
$controller = new UserController($twigService);

// On veut afficher les utilisateurs
$users = $controller->showUsers();
foreach($users as $user){
echo "$user[pseudo]";
}

// On instancie Twig
$twigService = new TwigService();

// On instancie le User Controller en lui passant en paramètre twig
$controller = new UserController($twigService);

// On affiche les sutilisateurs
$controller->showUsers();
