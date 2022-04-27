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

$blogPath = substr("/projectsOC/blog_portfolio/posts", -5, 5);
$Uri = substr($_SERVER['REQUEST_URI'], -5, 5);
// var_dump($blogUri);
var_dump($_GET['action']);

switch (true) {
    // If nothing in url we load the home page and reset session variable
    case !isset($_SERVER['PATH_INFO']) :
        unset($_SESSION['flash']);
        unset($_SESSION['flash_message']);
        $homeController->showHome();
        break;
    case $_SERVER['PATH_INFO'] = 'posts' :
        $userController->showPosts();
        break;
    case $_GET['action'] = 'post' :
        $userController->showPostAndComments($_GET['id']);
        break;
    // Manage POST form
    case $_SERVER['REQUEST_METHOD'] == 'POST' :
        // if url is equals to /contact or /#contact
        if (($_SERVER['PATH_INFO'] == '/contact' || $_SERVER['PATH_INFO'] == '/#contact')) {
            $contactController = new ContactController(TwigService::getInstance());
            $contactController->submitFormContact(
                $_POST['name'],
                $_POST['lastname'],
                $_POST['email'],
                $_POST['message'],
            );
        }
        break;
    // If any case is found
    default:
        $homeController->showHome();
}