<?php

namespace Oc\Blog\controller;

class BlogController{
    public function showPosts(){
        echo 
        $posts = $userModel->getUsers();
        return $posts;
    }
    
    public function showPost($id){
        $post = $userModel->getPost($id);
        $comments = $userModel->getComments($id);
        return $comments;
    }
    
    /**
     * Fonction test pour d'afficher la home page
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function displayText()
    {
        // On affiche le template twig home.html.twig
        echo "hello de BlogController";
    }
}