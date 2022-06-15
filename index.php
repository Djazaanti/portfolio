<?php
declare(strict_types=1);

// On charge l'autoloader de composer afin d'avoir accès aux dépendances du projet comme Twig
require_once('vendor/autoload.php');

use Oc\Blog\controller\ContactController;
use Oc\Blog\controller\HomeController;
use Oc\Blog\controller\ConnexionController;
use Oc\Blog\controller\BlogController;
use Oc\Blog\controller\PostController;
use Oc\Blog\controller\DashboardController;

use Oc\Blog\service\TwigService;

session_start();

// convert id for URL of post details
$postId = intval(substr($_SERVER['QUERY_STRING'], -1));

switch (true) {    
    // Manage POST form
    case $_SERVER['REQUEST_METHOD'] == 'POST' :
        if (isset($_SERVER['PATH_INFO']) && ($_SERVER['PATH_INFO'] == '/contact' || $_SERVER['PATH_INFO'] == '/#contact')) {
            $contactController = new ContactController(TwigService::getInstance());
            // check inputs format
            $name = htmlspecialchars($_POST['name']);
            $lastname =  htmlspecialchars($_POST['lastname']);
            $email = $_POST['email'];
            $message =  htmlspecialchars($_POST['message']);

            $contactController->submitFormContact($name, $lastname, $email, $message);
        }
        elseif ($_SERVER['QUERY_STRING'] == 'dashboard') {
            // traitement formulaire de connexion
            $connexionController = new ConnexionController(TwigService::getInstance());
            $pseudo = trim($_POST['pseudo']);
            $password = trim($_POST['password']);
            $connexionController->verifyConnexionAdmin($pseudo, $password);
        }
        break;
    // once contact formular sent, show succes or error message
    case $_SERVER['QUERY_STRING'] == 'contact' :
        $homeController = new HomeController(TwigService::getInstance());
        $homeController->showHome();
        break;
    case $_SERVER['QUERY_STRING'] == 'blog' :
        $blogController = new BlogController(TwigService::getInstance());
        $blogController->showBlog();
        break;
    case $_SERVER['QUERY_STRING'] == 'post/'.$postId :
        $postController = new PostController(TwigService::getInstance());
        $postController->showPostAndComments($postId);
        break;
    case $_SERVER['QUERY_STRING'] == 'connexion-admin' : 
        $connexionController = new ConnexionController(TwigService::getInstance());
        $connexionController->formularConnexionAdmin();
        break;
    case $_SERVER['QUERY_STRING'] == 'dashboard' : 
        $dashboardController = new DashboardController(TwigService::getInstance());
        $dashboardController->dashboardPage();
        $dashboardController->commentairesEnAttente();

        break;
    // If any case is found
    case $_SERVER['QUERY_STRING'] == '/home' :
        unset($_SESSION['flash']);
        unset($_SESSION['flash_message']);
        $homeController = new HomeController(TwigService::getInstance());
        $homeController->showHome();
        break;
    default:
        unset($_SESSION['flash']);
        unset($_SESSION['flash_message']);
        $homeController = new HomeController(TwigService::getInstance());
        $homeController->showHome();
} 
