<?php
declare(strict_types=1);

// On charge l'autoloader de composer afin d'avoir accès aux dépendances du projet comme Twig
require_once('vendor/autoload.php');

use Oc\Blog\controller\AdminController;
use Oc\Blog\controller\BlogController;
use Oc\Blog\controller\CommentController;
use Oc\Blog\controller\ConnexionController;
use Oc\Blog\controller\ContactController;
use Oc\Blog\controller\DashboardController;
use Oc\Blog\controller\HomeController;
use Oc\Blog\controller\PostController;
use Oc\Blog\controller\UserController;

use Oc\Blog\service\TwigService;

session_start();

// convert id for URL of post details
$idString = explode('/', $_SERVER['QUERY_STRING']);
if (isset($idString[1])){
    $postId = intval($idString[1]);
}
else {
    $postId = 0;
}

switch (true){
    // Manage POST form
    case $_SERVER['REQUEST_METHOD'] == 'POST' :
        if (isset($_POST['action']) && ($_POST['action']) == 'contact') {

            $contactController = new ContactController(TwigService::getInstance());
            // check inputs format
            $name = htmlspecialchars($_POST['name']);
            $lastname = htmlspecialchars($_POST['lastname']);
            $email = $_POST['email'];
            $message = htmlspecialchars($_POST['message']);

            $contactController->submitFormContact($name, $lastname, $email, $message);
        }
        elseif (isset($_POST['action']) && ($_POST['action']) == 'addComment'){
            $comment = $_POST['comment'];
            $userId = intval($_SESSION['userId']);
            $postId = intval($_POST['postId']);

            $commentController = new CommentController(TwigService::getInstance());
            $commentController->sendComment($comment, $userId, $postId);
        }
        elseif (isset($_POST['action']) &&  ($_POST['action']) == 'login'){
            // traitement formulaire de connexion
            $connexionController = new ConnexionController(TwigService::getInstance());
            $pseudo = trim($_POST['pseudo']);
            $password = $_POST['password'];
            $connexionController->verifyConnexion($pseudo, $password);
        }
        elseif (isset($_POST['action']) &&  ($_POST['action']) == 'validComment'){
            $idComment = intval($_POST['idComment']);
            $commentController = new CommentController(TwigService::getInstance());
            $commentController->validComment($idComment);
        }
        elseif (isset($_POST['action']) &&  ($_POST['action']) == 'deleteComment'){
            $idComment = intval($_POST['idComment']);
            $commentController = new CommentController(TwigService::getInstance());
            $commentController->deleteComment($idComment);
        }  
        elseif (isset($_POST['action']) &&  ($_POST['action']) == 'addPost'){

            if (!isset($_POST['isPublished'])){
                $_POST['isPublished'] = 0;
            }
            // Vérifie si le fichier a été uploadé sans erreur . 
            if($_FILES["media"]["error"] == 0){
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                $filename = $_FILES["media"]["name"];
                $filetype = $_FILES["media"]["type"];
                $filesize = $_FILES["media"]["size"];
                $file_tmp_name = $_FILES["media"]["tmp_name"];
                // Vérifie l'extension du fichier
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                
                $postController = new PostController(TwigService::getInstance());
                $postController->downloadFile($ext, $allowed, $filesize, $filetype, $filename, $file_tmp_name);

                $title = htmlspecialchars($_POST['title']);
                $content = htmlspecialchars($_POST['content']);
                $chapo = htmlspecialchars($_POST['chapo']);
                $isPublished = boolval($_POST['isPublished']);
                $userId =  intval($_POST['userId']);
                $media = date("d_m_Y_H_i_s") .'.'.$ext;
                $postController->addPost($title, $content, $chapo, $isPublished, $userId, $media);
            }   
        } 
        elseif ($_SERVER['QUERY_STRING'] == 'editPostFormular/' . $postId){

            $_SESSION['page'] = 'editPostFormular/' . $postId;

            // vérifier si nouveau fichier sélectionné $_FILES non vide
            if ($_FILES['media']['name'] != "")
            {
                // Vérifie si le fichier a été uploadé sans erreur . 
                if($_FILES["media"]["error"] == 0){
                    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                    $filename = $_FILES["media"]["name"];
                    $filetype = $_FILES["media"]["type"];
                    $filesize = $_FILES["media"]["size"];
                    $file_tmp_name = $_FILES["media"]["tmp_name"];
                    // Vérifie l'extension du fichier
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                    $media = date("d_m_Y_H_i_s") .'.'.$ext;

                    $postController = new PostController(TwigService::getInstance());
                    $postController->downloadFile($ext, $allowed, $filesize, $filetype, $filename, $file_tmp_name, $postId);
                }
            }
            else {
                $media = $_POST['mediaExist'];
            }

            if (isset($_POST['publish'])) $isPublished = boolval($_POST['publish']);
            else $isPublished = boolval($_POST['isPublished']);

            $authorId = intval($_POST['authorId']);
            $idPost = intval($_POST['idPost']);

            $postController = new PostController(TwigService::getInstance());
            $postController->editPost($_POST['title'], $_POST['content'], $_POST['chapo'], $media, $isPublished, $authorId, $idPost);
        }    
        elseif (isset($_POST['action']) &&  ($_POST['action']) == 'deletePost') {
            $idPost = intval($_POST['idPost']);

            $postController = new PostController(TwigService::getInstance());
            $postController->deletePost($idPost);
        } 
        elseif (isset($_POST['action']) &&  ($_POST['action']) == 'publishPost'){
            $idPost = intval($_POST['idPost']);

            $postController = new PostController(TwigService::getInstance());
            $postController->publishPost($idPost);
        }
        elseif (isset($_POST['action']) &&  ($_POST['action']) == 'save-user'){
            $userController = new UserController(TwigService::getInstance());
            $userController->addUser($_POST['pseudo'], $_POST['email'], $_POST['password']);
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
    case $_SERVER['QUERY_STRING'] == 'post/' . $postId :
        $postController = new PostController(TwigService::getInstance());
        $postController->showPostAndComments($postId);
        break;
    case $_SERVER['QUERY_STRING'] == 'addCommentFormular/' . $postId :
        $commentController = new CommentController(TwigService::getInstance());
        $commentController->addCommentFormular($postId);
        break;
    case $_SERVER['QUERY_STRING'] == 'connexion' :
        $connexionController = new ConnexionController(TwigService::getInstance());
        $connexionController->formularConnexion();
        break;
    case $_SERVER['QUERY_STRING'] == 'logout' :
        $connexionController = new ConnexionController(TwigService::getInstance());
        $connexionController->logout();
        break;
    case $_SERVER['QUERY_STRING'] == 'dashboard' :
        $_SESSION['page'] = 'dashboard';
        $dashboardController = new DashboardController(TwigService::getInstance());
        $dashboardController->dashboard();
        break;
    case $_SERVER['QUERY_STRING'] == 'adminPosts' :
        $_SESSION['page'] = 'adminPosts';
        $adminController = new AdminController(TwigService::getInstance());
        $adminController->adminPosts();
        break;
    case $_SERVER['QUERY_STRING'] == 'adminPostDetails/' . $postId :
        $_SESSION['page'] = 'adminPostDetails/' . $postId;
        $adminController = new AdminController(TwigService::getInstance());
        $adminController->adminPostDetails($postId);
        break;
    case $_SERVER['QUERY_STRING'] == 'addPostFormular' :
        $postController = new PostController(TwigService::getInstance());
        $postController->addPostFormular();
        break;
    case $_SERVER['QUERY_STRING'] == 'editPostFormular/' . $postId :
        $_SESSION['page'] = 'editPostFormular/' . $postId;
        $postController = new PostController(TwigService::getInstance());
        $postController->editPostFormular($postId);
        break;
    case $_SERVER['QUERY_STRING'] == 'addUser' :
        $userController = new UserController(TwigService::getInstance());
        $userController->addUserFormular();
        break;
    // If any case is found
    case $_SERVER['QUERY_STRING'] == '/home' :
        $homeController = new HomeController(TwigService::getInstance());
        $homeController->showHome();
        break;
    default:
        $homeController = new HomeController(TwigService::getInstance());
        $homeController->showHome();
} 
