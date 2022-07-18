<?php

declare(strict_types=1);

namespace Oc\Blog\controller;

use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

use Oc\Blog\model\PostModel;
use Oc\Blog\model\CommentModel;
use Oc\Blog\model\UserModel;


/**
 * @UserController Le controller permettant de gérer l'utilisateur
 */
class PostController
{
    /**
     * @var TwigService Twig
     */
    private TwigService $twigService;

    /**
     * Le constructeur de la classe UserController.
     * Il attend en paramètre twig pour afficher les vues
     * @param TwigService $twig Le service twig
     */
    public function __construct(TwigService $twig)
    {
        // Je stock la configuration du service twig dans notre variable twig du controller
        $this->twigService = $twig;
    }

    
    /**
     * @param mixed $id
     * 
     * @return void
     */
    public function showPostAndComments(mixed $id) : void{
        $postModel = new PostModel();
        $commentModel = new CommentModel();

        $post = $postModel->getPost($id);
        $comments = $commentModel->getComments($id);

        $userModel = new UserModel();
        $author = $userModel->getAuthor($id);
        
        echo $this->twigService->get()->render('post.html.twig', ['comments' => $comments, 'post' => $post, 'author' => $author]);
    }

    
    /**
     * @return void
     */
    public function addPostFormular() : void {
        $userModel = new UserModel();
        $admins = $userModel->getAdmins();

        echo $this->twigService->get()->render('admin/addPost.html.twig', ['admins' => $admins]);

    }

    /**
     * @param mixed $id
     * 
     * @return [type]
     */
    public function editPost(string $title, string $content, string $chapo, string $media, bool $isPublished, mixed $updatedAt, int $authorId, int $idPost) {
        $postModel = new PostModel();
        $postModel->updatePost($title, $content, $chapo, $media, $isPublished, $updatedAt, $authorId, $idPost);

        $_SESSION["SuccessMessage"] = "article mis à jour avec succès";
        header("location: index.php?dashboard");

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
            $_SESSION['ErrorMessage'] = "Erreur : Veuillez sélectionner un format de fichier valide.";
            header('location: index.php?addPostFormular'); die;
        } 

        // Vérifie la taille du fichier - 5Mo maximum
        $maxsize = 5 * 1024 * 1024 ;
        if($filesize > $maxsize) {
            $_SESSION['ErrorMessage'] = "Erreur: La taille du fichier est supérieure à la limite autorisée.";
            header('location: index.php?addPostFormular');die;
        }
        // Vérifie le type MIME du fichier
        if(in_array($filetype, $allowed)){
                move_uploaded_file($file_tmp_name, "public/assets/img/portfolio/".date("d_m_Y à H_i_s").'.'.$ext);
        }
        $_SESSION['SuccessMessage'] = "Fichier téléchagé";
        header('location: index.php?dashboard');

    }

    public function editPostFormular(array $postInformations) : void {
        
        $userId = intval($postInformations['userId']);
        $userModel = new UserModel();
        $author = $userModel->getUser($userId);
        $users = $userModel->getUsers();
        
        echo $this->twigService->get()->render('admin/editPost.html.twig', ['postInformations' => $postInformations, 'author' => $author, 'users' => $users]);
    }

    
    /**
     * @param int $idPost
     * 
     * @return void
     */
    public function deletePost(int $idPost) : void {
        $postModel = new PostModel();
        $post = $postModel->deletePostInBDD($idPost);
        
        $_SESSION["SuccessMessage"] = "article supprimé avec succès";
        header("location: index.php?dashboard");
    }

    public function publishPost( int $idPost) : void {
        $postModel = new PostModel();
        $post = $postModel->updatePublishPost($idPost);

        $_SESSION["SuccessMessage"] = "article publié avec succès";
        header("location: index.php?dashboard");

    }
}
