<?php

declare(strict_types=1);

namespace Oc\Blog\controller;

use Oc\Blog\model\CommentModel;
use Oc\Blog\model\PostModel;
use Oc\Blog\model\UserModel;
use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
     * @param TwigService $twig Le service twig
     */
    public function __construct(TwigService $twig)
    {
        $this->twigService = $twig;
    }
    
    /**
     * @param int $id
     * 
     * @return void
     */
    public function showPostAndComments(int $id) : void
    {
        $postModel = new PostModel();
        $post = $postModel->getPost($id);

        $commentModel = new CommentModel();
        $comments = $commentModel->getComments($id);

        $userModel = new UserModel();
        $author = $userModel->getAuthor($id);
        
        echo $this->twigService->get()->render('post.html.twig', ['comments' => $comments, 'post' => $post, 'author' => $author]);
    }

    /**
     * @return void
     */
    public function addPostFormular() : void
    {
        $userModel = new UserModel();
        $admins = $userModel->getAdmins();

        echo $this->twigService->get()->render('admin/addPost.html.twig', ['admins' => $admins]);
    }

    /**
     * @param string $title
     * @param string $content
     * @param string $chapo
     * @param bool $isPublished
     * @param int $userId
     * @param string $media
     * 
     * @return void
     */
    public function addPost(string $title, string $content, string $chapo, bool $isPublished, int $userId, string $media) : void
    {
        $postModel = new PostModel();
        $postModel->addPost($title, $content, $chapo, $isPublished, $userId, $media);

        $_SESSION['SuccessMessage'] = "Article ajouté !";

        header('location: index.php?dashboard');

    }

    /**
     * @param string $ext
     * @param array $allowed
     * @param int $filesize
     * @param string $filetype
     * @param string $filename
     * @param string $file_tmp_name
     * @param int|null $postId
     * 
     * @return void
     */
    public function downloadFile(string $ext, array $allowed, int $filesize, string $filetype, string $filename, string $file_tmp_name, ?int $postId) : void
    { 
        // vérifie le format du fichier
        if(!array_key_exists($ext, $allowed)) {

            $_SESSION['ErrorMessage'] = "Erreur : Veuillez sélectionner un format de fichier valide.";

            if ($_SESSION['page'] ==  "editPostFormular/".$postId )
            {
                header('location: index.php?editPostFormular/' . $postId); 
            }
            else header('location: index.php?addPostFormular');
        } 

        // Vérifie la taille du fichier - 5Mo maximum
        $maxsize = 5 * 1024 * 1024 ;
        if($filesize > $maxsize) {
            $_SESSION['ErrorMessage'] = "Erreur: La taille du fichier est supérieure à la limite autorisée.";

            if ($_SESSION['page'] ==  "editPostFormular/".$postId )
            {
                header('location: index.php?editPostFormular/' . $postId); 
            }
            else header('location: index.php?addPostFormular');
        }
        // Vérifie le type MIME du fichier
        if(in_array($filetype, $allowed)){
            move_uploaded_file($file_tmp_name, "public/assets/img/portfolio/".date("d_m_Y_H_i_s").'.'.$ext);
            $_SESSION['SuccessMessage'] = "Fichier téléchagé";
        }
    }

    /**
     * @param int $postId
     * 
     * @return void
     */
    public function editPostFormular(int $postId) : void
    {
        $postModel = new PostModel();
        $post = $postModel->getPost($postId);

        $userModel = new UserModel();
        $author = $userModel->getUser($post['user_id']);

        $admins = $userModel->getAdmins();
        
        echo $this->twigService->get()->render('admin/editPost.html.twig', ['post' => $post, 'author' => $author, 'admins' => $admins]);
    }

    /**
     * @param string $title
     * @param string $content
     * @param string $chapo
     * @param string $media
     * @param bool $isPublished
     * @param string $updatedAt
     * @param int $authorId
     * @param int $idPost
     * 
     * @return void
     */
    public function editPost(string $title, string $content, string $chapo, string $media, bool $isPublished, int $authorId, int $idPost) : void
    {
        $postModel = new PostModel();
        $postModel->updatePost($title, $content, $chapo, $media, $isPublished, $authorId, $idPost);

        $_SESSION["SuccessMessage"] = "article mis à jour avec succès";

        if ($_SESSION['page'] == 'dashboard') {
            header('location: index.php?dashboard');
        }
        elseif ($_SESSION['page'] == 'adminPosts' || $_SESSION['page'] = 'adminPostDetails' . $postId) {
            header('location: index.php?adminPosts');
        }
    }

    
    /**
     * @param int $idPost
     * 
     * @return void
     */
    public function deletePost(int $idPost) : void
    {
        $postModel = new PostModel();
        $post = $postModel->deletePostInBDD($idPost);
        
        $_SESSION["SuccessMessage"] = "article supprimé avec succès";

        if ($_SESSION['page'] == 'dashboard') {
            header('location: index.php?dashboard');
        }
        elseif ($_SESSION['page'] == 'adminPosts' || $_SESSION['page'] = 'adminPostDetails') {
            header('location: index.php?adminPosts');
        }
    }

    /**
     * @param int $idPost
     * 
     * @return void
     */
    public function publishPost( int $idPost) : void
    {
        $postModel = new PostModel();
        $post = $postModel->updatePublishPost($idPost);

        $_SESSION["SuccessMessage"] = "article publié avec succès";

        if ($_SESSION['page'] == 'dashboard') {
            header('location: index.php?dashboard');
        }
        elseif ($_SESSION['page'] == 'adminPosts' || $_SESSION['page'] = 'adminPostDetails') {
            header('location: index.php?adminPosts');
        }
    }
}
