<?php
declare(strict_types=1);

// On charge l'autoloader de composer afin d'avoir accès aux dépendances du projet comme Twig
require_once('vendor/autoload.php');

use Oc\Blog\controller\ContactController;
use Oc\Blog\controller\HomeController;
use Oc\Blog\controller\UserController;
use Oc\Blog\service\TwigService;

session_start();

$userController = new UserController(TwigService::getInstance());
$homeController = new HomeController(TwigService::getInstance());
var_dump($_SERVER['REQUEST_METHOD']);
var_dump($_POST);
switch (true) {
    // If nothing in url we load the home page and reset session variable
    case !isset($_SERVER['PATH_INFO']) :
        unset($_SESSION['flash']);
        unset($_SESSION['flash_message']);
        $homeController->showHome();
        break;
    
    // Manage POST form
    case $_SERVER['REQUEST_METHOD'] = 'POST' :
        
        // if url is equals to /contact or /#contact
        if (($_SERVER['PATH_INFO'] = '/contact' || $_SERVER['PATH_INFO'] = '/#contact')) {
            // echo 'hello de contact formular';
            $contactController = new ContactController(TwigService::getInstance());
            $contactController->submitFormContact(
                htmlspecialchars($_POST['name']),
                htmlspecialchars($_POST['lastname']),
                filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
                htmlspecialchars($_POST['message'])
            );
        }
        break;
    case $_SERVER['QUERY_STRING'] = 'posts' :
        echo 'hello posts';
        $userController->showPosts();
        break;
    case $_GET['action'] == 'post' :
        //  TO DO : vérifier UserModel, si la table est la bonne
        $userController->showPostAndComments($_GET['id']);
        break;
    // If any case is found
    default:
        $homeController->showHome();
}




// // var_dump($_SERVER['PATH_INFO']);
// var_dump($_SERVER['REQUEST_METHOD']);
// // var_dump($_SERVER['PATH_INFO']);
// var_dump($_SERVER['QUERY_STRING']);
// // var_dump($_GET['action']);

// // If nothing in url we load the home page and reset session variable
// if(!isset($_SERVER['PATH_INFO'])){
//     unset($_SESSION['flash']);
//     unset($_SESSION['flash_message']);
//     $homeController->showHome();
// }
    
// // Manage POST form
// elseif($_SERVER['REQUEST_METHOD'] = 'POST'){
//     // if url is equals to /contact or /#contact
//     // if (($_SERVER['QUERY_STRING'] = '/contact' || $_SERVER['PATH_INFO'] = '/#contact')) {
//         if ($_SERVER['QUERY_STRING'] = '/contact'){ 
//             echo 'hello de contact form';
//         // $contactController = new ContactController(TwigService::getInstance());
//         // $contactController->submitFormContact(
//         //     $_POST['name'],
//         //     $_POST['lastname'],
//         //     $_POST['email'],
//         //     $_POST['message'],
//         // );
//     }
// }
    
// elseif ($_SERVER['QUERY_STRING'] = '/posts'){
//     echo 'hello posts';
//     $userController->showPosts();
// }
    
// elseif ($_GET['action'] == 'post'){
//     //  TO DO : vérifier UserModel, si la table est la bonne
//     $userController->showPostAndComments($_GET['id']);
// }
    
// // If any case is found
// else
    // $homeController->showHome();