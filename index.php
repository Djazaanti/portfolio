<?php
declare(strict_types=1);
session_start();
// On charge l'autoloader de composer afin d'avoir accès aux dépendances du projet comme Twig
require_once('vendor/autoload.php');

use Oc\Blog\controller\HomeController;
use Oc\Blog\controller\UserController;
use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

$userController = new UserController(TwigService::getInstance());
//print_r($userController);

if(isset ($_GET['action']))
{

    /* show users 
    if ($_GET['action'] == 'users'){
        $userController->showUsers();
    }*/

    // show posts
    if($_GET['action'] == 'posts')
    {
    $userController->showPostsHome();
    }  

    // show selected post ans his comments 
    elseif($_GET['action'] == 'post')
    {
    $id = $_GET['id'];
    $userController->showPostAndComments($id);
    } 

}


// instancie le Home Controller en lui passant en paramètre Twig Service
$homeController = new HomeController(TwigService::getInstance());

$homeController->showHome();