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
    public function editPost(string $title, string $content, string $chapo, string $media, bool $isPublished, mixed $updatedAt, int $userId, int $idPost) {
    // public function editPost(string $title, mixed $updatedAt, int $idPost) {

        // var_dump($title.'<br>');
        // var_dump($content.'<br>');
        // var_dump($chapo.'<br>');
        // var_dump($media.'<br>');
        // var_dump(boolval($isPublished).'<br>');
        // var_dump($updatedAt.'<br>');
        // var_dump($userId.'<br>');
        // var_dump($idPost.'<br>');

        $postModel = new PostModel();
        $postModel->updatePost($title, $content, $chapo, $media, $isPublished, $updatedAt, $userId, $idPost);

        $_SESSION["SuccessMessage"] = "article mis à jour avec succès";
        header("location: index.php?dashboard");

    }

    public function editPostFormular(array $postInformations) : void {
        
        $userId = intval($postInformations['userId']);
        $userModel = new UserModel();
        $user = $userModel->getUser($userId);
        
        echo $this->twigService->get()->render('admin/editPost.html.twig', ['postInformations' => $postInformations, 'user' => $user]);
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
