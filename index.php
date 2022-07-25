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
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();

session_start();

// convert id for URL of post details
$idString = explode('/', $request->server->get('QUERY_STRING'));
if ($idString[1] !== null){
    $postId = intval($idString[1]);
}
else {
    $postId = 0;
}

switch (true){
    // Manage POST form
    case $request->server->get('REQUEST_METHOD') == 'POST' :
        if ($request->request->get('action') !== null && $request->request->get('action') == 'contact') {

            $contactController = new ContactController(TwigService::getInstance());
            // check inputs format
            $name = htmlspecialchars($request->request->get('name'));
            $lastname = htmlspecialchars($request->request->get('lastname'));
            $email = $request->request->get('email');
            $message = htmlspecialchars($request->request->get('message'));

            $contactController->submitFormContact($name, $lastname, $email, $message);
        }
        elseif ($request->request->get('action') !== null && $request->request->get('action') == 'addComment'){
            $comment = $request->request->get('comment');
            $userId = intval($_SESSION['userId']);
            $postId = intval($request->request->get('postId'));

            $commentController = new CommentController(TwigService::getInstance());
            $commentController->sendComment($comment, $userId, $postId);
        }
        elseif ($request->request->get('action') !== null &&  $request->request->get('action') == 'login'){
            // traitement formulaire de connexion
            $connexionController = new ConnexionController(TwigService::getInstance());
            $pseudo = trim($request->request->get('pseudo'));
            $password = $request->request->get('password');
            $connexionController->verifyConnexion($pseudo, $password);
        }
        elseif ($request->request->get('action') !== null &&  $request->request->get('action') == 'validComment'){
            $idComment = intval($request->request->get('idComment'));
            $commentController = new CommentController(TwigService::getInstance());
            $commentController->validComment($idComment);
        }
        elseif ($request->request->get('action') !== null &&  $request->request->get('action') == 'deleteComment'){
            $idComment = intval($request->request->get('idComment'));
            $commentController = new CommentController(TwigService::getInstance());
            $commentController->deleteComment($idComment);
        }  
        elseif ($request->request->get('action') !== null &&  $request->request->get('action') == 'addPost'){

            if ($request->request->get('isPublished') == null ) {
                // $request->request->get('isPublished') = 0;
            }
            // Vérifie si le fichier a été uploadé sans erreur . 
            if($request->files->get("media")("error") == 0){
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                $filename = $request->files->get("media")("name");
                $filetype = $request->files->get("media")("type");
                $filesize = $request->files->get("media")("size");
                $file_tmp_name = $request->files->get("media")("tmp_name");
                // Vérifie l'extension du fichier
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                
                $postController = new PostController(TwigService::getInstance());
                $postController->downloadFile($ext, $allowed, $filesize, $filetype, $filename, $file_tmp_name);

                $title = htmlspecialchars($request->request->get('title'));
                $content = htmlspecialchars($request->request->get('content'));
                $chapo = htmlspecialchars($request->request->get('chapo'));
                $isPublished = boolval($request->request->get('isPublished'));
                $userId =  intval($request->request->get('userId'));
                $media = date("d_m_Y_H_i_s") .'.'.$ext;
                $postController->addPost($title, $content, $chapo, $isPublished, $userId, $media);
            }   
        } 
        elseif ($request->server->get('QUERY_STRING') == 'editPostFormular'){
            $postController = new PostController(TwigService::getInstance());
            $postController->editPostFormular($request->request);
        }
        elseif ($request->server->get('QUERY_STRING') == 'editPost'){
            
            if ($request->files->get('media') !== null)
            {
                // Vérifie si le fichier a été uploadé sans erreur . 
                if($request->files->get("media")("error") == 0){
                    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                    $filename = $request->files->get("media")("name");
                    $filetype = $request->files->get("media")("type");
                    $filesize = $request->files->get("media")("size");
                    $file_tmp_name = $request->files->get("media")("tmp_name");
                    // Vérifie l'extension du fichier
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                    $media = date("d_m_Y_H_i_s") .'.'.$ext;

                    $postController = new PostController(TwigService::getInstance());
                    $postController->downloadFile($ext, $allowed, $filesize, $filetype, $filename, $file_tmp_name);
                }
            } 
            else $media = $request->request->get('mediaExist');

            if ($request->request->get('publish') !== null ) $isPublished = boolval($request->request->get('publish'));
            else $isPublished = boolval($request->request->get('isPublished'));

            $authorId = intval($request->request->get('authorId'));
            $idPost = intval($request->request->get('idPost'));

            $postController = new PostController(TwigService::getInstance());
            $postController->editPost($request->request->get('title'), $request->request->get('content'), $request->request->get('chapo'), $media, $isPublished, $authorId, $idPost);
        }    
        elseif ($request->request->get('action') !== null &&  $request->request->get('action') == 'deletePost') {
            $idPost = intval($request->request->get('idPost'));

            $postController = new PostController(TwigService::getInstance());
            $postController->deletePost($idPost);
        } 
        elseif ($request->request->get('action') !== null &&  $request->request->get('action') == 'publishPost'){
            $idPost = intval($request->request->get('idPost'));

            $postController = new PostController(TwigService::getInstance());
            $postController->publishPost($idPost);
        }
        elseif ($request->request->get('action') !== null &&  $request->request->get('action') == 'save-user'){
            $userController = new UserController(TwigService::getInstance());
            $userController->addUser($request->request->get('pseudo'), $request->request->get('email'), $request->request->get('password'));
        }
        break;
    // once contact formular sent, show succes or error message
    case $request->server->get('QUERY_STRING') == 'contact' :
        $homeController = new HomeController(TwigService::getInstance());
        $homeController->showHome();
        break;
    case $request->server->get('QUERY_STRING') == 'blog' :
        $blogController = new BlogController(TwigService::getInstance());
        $blogController->showBlog();
        break;
    case $request->server->get('QUERY_STRING') == 'post/' . $postId :
        $postController = new PostController(TwigService::getInstance());
        $postController->showPostAndComments($postId);
        break;
    case $request->server->get('QUERY_STRING') == 'addCommentFormular/' . $postId :
        $commentController = new CommentController(TwigService::getInstance());
        $commentController->addCommentFormular($postId);
        break;
    case $request->server->get('QUERY_STRING') == 'connexion' :
        $connexionController = new ConnexionController(TwigService::getInstance());
        $connexionController->formularConnexion();
        break;
    case $request->server->get('QUERY_STRING') == 'logout' :
        $connexionController = new ConnexionController(TwigService::getInstance());
        $connexionController->logout();
        break;
    case $request->server->get('QUERY_STRING') == 'dashboard' :
        $_SESSION['page'] = 'dashboard';
        $dashboardController = new DashboardController(TwigService::getInstance());
        $dashboardController->dashboard();
        break;
    case $request->server->get('QUERY_STRING') == 'adminPosts' :
        $_SESSION['page'] = 'adminPosts';
        $adminController = new AdminController(TwigService::getInstance());
        $adminController->adminPosts();
        break;
    case $request->server->get('QUERY_STRING') == 'adminPostDetails/' . $postId :
        $_SESSION['page'] = 'adminPostDetails';
        $adminController = new AdminController(TwigService::getInstance());
        $adminController->adminPostDetails($postId);
        break;
    case $request->server->get('QUERY_STRING') == 'addPostFormular' :
        $postController = new PostController(TwigService::getInstance());
        $postController->addPostFormular();
        break;
    case $request->server->get('QUERY_STRING') == 'addUser' :
        $userController = new UserController(TwigService::getInstance());
        $userController->addUserFormular();
        break;
    // If any case is found
    case $request->server->get('QUERY_STRING') == '/home' :
        $homeController = new HomeController(TwigService::getInstance());
        $homeController->showHome();
        break;
    default:
        $homeController = new HomeController(TwigService::getInstance());
        $homeController->showHome();
} 
