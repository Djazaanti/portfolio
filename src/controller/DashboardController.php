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
        $userModel = new UserModel();
        $admins = $userModel->getAdmins();

        echo $this->twigService->get()->render('admin/dashboard.html.twig', ['commentaires' => $commentaires, 'admins' => $admins]);
    }


    /**
     * @param string $title
     * @param string $content
     * @param string $chapo
     * @param string $media
     * @param string $isPublished
     * @param mixed $createdAt
     * @param string $userId
     * 
     * @return void
     */
    public function addPost(string $title, string $content, string $chapo, string $media, string $isPublished, mixed $createdAt, string $userId) : void {
        $title = htmlspecialchars($title);
        $content = htmlspecialchars($content);
        $chapo = htmlspecialchars($chapo);
        $userId =  intval($userId);
        
        $postModel = new PostModel();
        $retunReq = $postModel->insertPostInDB($title, $content, $chapo, $media, $isPublished, $createdAt, $userId);

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
    public function downloadFile($ext, $allowed, $filesize, $filetype, $filename, $file_tmp_name) : void{
        
        if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");

        // Vérifie la taille du fichier - 5Mo maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");

        // Vérifie le type MIME du fichier
        if(in_array($filetype, $allowed)){
            // Vérifie si le fichier existe avant de le télécharger.
            if(file_exists("upload/" .$filename)){
                echo $filename. " existe déjà.";
            } else{
                move_uploaded_file($file_tmp_name, "public/assets/img/portfolio/".date("d_m_Y_H_i_s").'.'.$ext);
            }
        }
        else{
            echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer."; 
        } 

        header('location: index.php?dashboard');

    }

    /**
     * @param mixed $idComment
     * 
     * @return void
     */
    public function validComment($idComment) : void {
        $commentModel = new CommentModel();
        $commentModel->updateValidComment($idComment);

        header('location: index.php?dashboard');
    }

    public function deleteComment($idComment) : void {
        $commentModel = new CommentModel();
        $commentModel->updateDeleteComment($idComment);

        header('location: index.php?dashboard');
    }

}
