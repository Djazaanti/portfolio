<?php

declare(strict_types=1);

namespace OC\Blog\controller;

use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

use Oc\Blog\model\CommentModel;
use Oc\Blog\model\PostModel;
use Oc\Blog\model\UserModel;


class DashboardController{
    /**
     * @var TwigService Twig
     */
    private TwigService $twigService;

    /**
     * @param TwigService $twigService
     */
    public function __construct(TwigService $twigService)
    {
        // Je stock la configuration twig dans notre variable twig du controller
        $this->twigService = $twigService;
    }

    /**
     * @return void
     */
    public function dashboard() : void {

        $commentModel = new CommentModel();
        $commentaires = $commentModel->getCommentairesAValider();
        $NbCommentsToValid = $commentModel->countCommentsToValid();

        $userModel = new UserModel();
        $admins = $userModel->getAdmins();
        $NbUsers = $userModel->countUsers();

        $postModel = new PostModel();
        $posts = $postModel->getPosts();
        $NbPostsToPublish = $postModel->countPostsToPublish();
        $NbPostsPublished = $postModel->countPostsPublished();
        
        var_dump($NbCommentsToValid );
        $_SESSION['page'] = "dashboard";
        echo $this->twigService->get()->render('admin/dashboard.html.twig', ['commentaires' => $commentaires, 'admins' => $admins, 'posts' => $posts, 'NbCommentsToValid' => $NbCommentsToValid, 'NbUsers' => $NbUsers, 'NbPostsToPublish' => $NbPostsToPublish, 'NbPostsPublished' => $NbPostsPublished]);

        $_SESSION["SuccessMessage"] = "";
        $_SESSION["ErrorMessage"] = "";

    }


    
    /**
     * @param mixed $title
     * @param mixed $content
     * @param mixed $chapo
     * @param mixed $media
     * @param mixed $isPublished
     * @param mixed $createdAt
     * @param mixed $userId
     * 
     * @return void
     */
    public function addPost(mixed $title, mixed $content, mixed $chapo, mixed $media, mixed $isPublished, mixed $createdAt, mixed $userId) : void {
        $title = htmlspecialchars($title);
        $content = htmlspecialchars($content);
        $chapo = htmlspecialchars($chapo);
        $userId =  intval($userId);
        
        $postModel = new PostModel();
        $postModel->insertPostInDB($title, $content, $chapo, $media, $isPublished, $createdAt, $userId);

        $_SESSION['SuccessMessage'] = "Article ajouté !";
        header('location: index.php?dashboard');

    }

   
    /**
     * @param mixed $ext
     * @param mixed $allowed
     * @param mixed $filesize
     * @param mixed $filetype
     * @param mixed $filename
     * @param mixed $file_tmp_name
     * 
     * @return void
     */
    public function downloadFile(mixed $ext, mixed $allowed, mixed $filesize, mixed $filetype, mixed $filename, mixed $file_tmp_name) : void {
        
        if(!array_key_exists($ext, $allowed)) {
            // $_SESSION['ErrorMessage'] = "Erreur : Veuillez sélectionner un format de fichier valide.";
            header('location: index.php?addPostFormular'); die;
        } 

        // Vérifie la taille du fichier - 5Mo maximum
        $maxsize = 5 * 1024 * 1024 ;
        if($filesize > $maxsize) {
            // $_SESSION['ErrorMessage'] = "Erreur: La taille du fichier est supérieure à la limite autorisée.";
            header('location: index.php?addPostFormular');die;
        }
        // Vérifie le type MIME du fichier
        if(in_array($filetype, $allowed)){
                move_uploaded_file($file_tmp_name, "public/assets/img/portfolio/".date("d_m_Y à H_i_s").'.'.$ext);
        }
        // $_SESSION['SuccessMessage'] = "Fichier téléchagé";
        header('location: index.php?dashboard');

    }


    /**
     * @param int $idComment
     * 
     * @return void
     */
    public function validComment(int $idComment) : void {
        
        $commentModel = new CommentModel();
        $commentModel->updateValidComment($idComment);
        $_SESSION['SuccessMessage'] = "Commentaire validé";
        header('location: index.php?dashboard');
    }

    /**
     * @param int $idComment
     * 
     * @return void
     */
    public function deleteComment(int $idComment) : void {
        $commentModel = new CommentModel();
        $commentModel->updateDeleteComment($idComment);
        $_SESSION['SuccessMessage'] = "Commentaire supprimé";
        // echo $this->twigService->get()->render('admin/dashboard.html.twig', ['Message' => $_SESSION['message']]);
        header('location: index.php?dashboard');
    }

}
