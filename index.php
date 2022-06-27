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
use Oc\Blog\controller\AdminController;


use Oc\Blog\service\TwigService;

session_start();

// convert id for URL of post details
$idString = explode('/', $_SERVER['QUERY_STRING']);
$postId = intval($idString[1]);

switch (true) {    
    // Manage POST form
    case $_SERVER['REQUEST_METHOD'] == 'POST' :
        if (isset($_SERVER['PATH_INFO']) && ($_SERVER['PATH_INFO'] == '/contact' || $_SERVER['PATH_INFO'] == '/#contact')) 
        {
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
        elseif ($_SERVER['QUERY_STRING'] == 'add-post') {
            if (!isset($_POST['isPublished'])) {
                $_POST['isPublished'] = 0;
            }
            // Vérifie si le fichier a été uploadé sans erreur.
            if($_FILES["media"]["error"] == 0){
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                $filename = $_FILES["media"]["name"];
                $filetype = $_FILES["media"]["type"];
                $filesize = $_FILES["media"]["size"];
                $file_tmp_name = $_FILES["media"]["tmp_name"];
                // Vérifie l'extension du fichier
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                $dashboardController = new DashboardController(TwigService::getInstance());
                $dashboardController->downloadFile($ext, $allowed, $filesize, $filetype, $filename, $file_tmp_name);
                $dashboardController->addPost($_POST['title'], $_POST['content'], $_POST['chapo'], date("d_m_Y_H_i_s").'.'.$ext, $_POST['isPublished'], date("Y-m-d H:i:s"), $_POST['userId']);

            }   
        } 
        elseif ($_SERVER['QUERY_STRING'] == 'validComment'){
            // récupérer l'id du commentaire
            $dashboardController = new DashboardController(TwigService::getInstance());
            $dashboardController->validComment($_POST['idComment']);
        }     
        elseif ($_SERVER['QUERY_STRING'] == 'deleteComment'){
            $dashboardController = new DashboardController(TwigService::getInstance());
            $dashboardController->deleteComment($_POST['idComment']);
        }  
        elseif ($_SERVER['QUERY_STRING'] == 'editPost') {
            $adminController = new AdminController(TwigService::getInstance());
            $adminController->editPost($_POST['idPost']);
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
        $dashboardController->dashboard();
        break;
    case $_SERVER['QUERY_STRING'] == 'adminPosts' :
        $adminController = new AdminController(TwigService::getInstance());
        $adminController->adminPosts();
        break;
    case $_SERVER['QUERY_STRING'] == 'adminPostDetails/'.$postId : 
        $adminController = new AdminController(TwigService::getInstance());
        $adminController->adminPostDetails($postId);
        break;
    case $_SERVER['QUERY_STRING'] == 'addPostFormular' : 
        $adminController = new AdminController(TwigService::getInstance());
        $adminController->addPostFormular();
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
