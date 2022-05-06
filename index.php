<?php
declare(strict_types=1);

// On charge l'autoloader de composer afin d'avoir accès aux dépendances du projet comme Twig
require_once('vendor/autoload.php');

use Oc\Blog\controller\ContactController;
use Oc\Blog\controller\HomeController;
use Oc\Blog\controller\UserController;
use Oc\Blog\service\TwigService;

session_start();

switch (true) {    
    // Manage POST form
    case $_SERVER['REQUEST_METHOD'] == 'POST' :
        
        // if url is equals to /contact or /#contact
        if (($_SERVER['PATH_INFO'] == '/contact' || $_SERVER['PATH_INFO'] == '/#contact')) {
            // echo 'Bonjour'.$_POST['name'];
            $contactController = new ContactController(TwigService::getInstance());
            // check inputs format
            $name = htmlspecialchars($_POST['name']);
            $lastname =  htmlspecialchars($_POST['lastname']);
            $email = $_POST['email'];
            $message =  htmlspecialchars($_POST['message']);

            $contactController->submitFormContact($name, $lastname, $email, $message);
        }
        break;
    // once contact formular sent, show succes or error message
    case $_SERVER['QUERY_STRING'] == 'contact' :
        $contactController = new ContactController(TwigService::getInstance());
        $contactController->showContactMessage();
        break;
    case $_SERVER['QUERY_STRING'] == 'posts' :
        $userController = new UserController(TwigService::getInstance());
        $userController->showPosts();
        break;
        // récupérer un /posts/int 
    case $_SERVER['QUERY_STRING'] == 'post' :
        //  TO DO : vérifier UserModel, si la table est la bonne
        $userController = new UserController(TwigService::getInstance());
        $userController->showPostAndComments($_GET['id']);
        break;
    // If any case is found
    default:
        unset($_SESSION['flash']);
        unset($_SESSION['flash_message']);
        $homeController = new HomeController(TwigService::getInstance());
        $homeController->showHome();
}