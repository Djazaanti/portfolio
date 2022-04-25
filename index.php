<?php
declare(strict_types=1);
session_start();
// On charge l'autoloader de composer afin d'avoir accès aux dépendances du projet comme Twig
require_once('vendor/autoload.php');

use Oc\Blog\controller\HomeController;
use Oc\Blog\controller\UserController;
use Oc\Blog\controller\contactController;
use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

$userController = new UserController(TwigService::getInstance());
$homeController = new HomeController(TwigService::getInstance());
//print_r($userController);

// ar_dump($_SERVER);
var_dump($_SERVER["REQUEST_METHOD"]);
// var_dump($_SERVER["QUERY_STRING"]);
// var_dump($_GET["action"]);
// if(isset ($_POST['/contact']))
// {
//     var_dump($_SERVER);
//     print_r($_POST);
//     die;
// }

if(isset ($_GET['action']))
{
    
    if($_GET['action'] == '/contact'){
        //var_dump($_SERVER);
        //print_r($_POST);
        // $UserController->submitFormContact($_POST['name'], $_POST['lastname'], $_POST['email'], $_POST['message']);
    } 

    elseif($_GET['action'] == 'contact'){
       // $userController->get()->render('contact.html.twig');
    } 
    // show posts
    elseif($_GET['action'] == 'posts'){
        $userController->showPosts();
    }  

    // show selected post ans his comments 
    elseif($_GET['action'] == 'post'){
        $id = $_GET['id'];
        $userController->showPostAndComments($id);
    } 

}



$homeController->showHome();