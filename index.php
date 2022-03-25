<?php
declare(strict_types=1);

// On charge l'autoloader de composer afin d'avoir accès aux dépendances du projet comme Twig
require_once('vendor/autoload.php');

use Oc\Blog\controller\HomeController;
use Oc\Blog\controller\UserController;
use Oc\Blog\service\TwigService;

$controller = new UserController(TwigService::getInstance());

// On veut afficher les utilisateurs
/*$users = $controller->showUsers();
foreach($users as $user)
{
echo "$user[pseudo], \n";
}*/

// On affiche les sutilisateurs
//$userController->showUsers();

// instancie le Home Controller en lui passant en paramètre Twig Service
$homeController = new HomeController(TwigService::getInstance());

$homeController->showHome();
