<?php
declare(strict_types=1);

// On charge l'autoloader de composer afin d'avoir accès aux dépendances du projet comme Twig
require_once('vendor/autoload.php');

use Oc\Blog\controller\HomeController;
use Oc\Blog\controller\UserController;
use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

$userController = new UserController(TwigService::getInstance());

if(isset ($_GET['action']) == 'users'){
    // récupère les users
    $userController->showUsers();
    $userController->get()->render('user.html.twig');
}
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