<?php

declare(strict_types=1);

namespace Oc\Blog\model;

class UserModel
{
    /*public function __construct(){
    }*/

    /**
     * @return \PDO|null
     */
    public function dbConnect(): ?\PDO
    {
        try {
            $db = new \PDO('mysql:host=127.0.0.1;port=3307;dbname=blog;charset=UTF8', 'root', '');
            return $db;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

     /**
     * - Se connecter à la base de données
     * - Récupérer les utilisateurs
     * @return array d'utilisateurs
     */
    public function getUsers(): array
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        $req = $db->prepare('SELECT pseudo FROM user');
        $req->execute();
        return $req->fetchAll();
    }

    public function getPostsHome()
    {
        $db = $this->dbConnect();
        if(null === $db){
            return[];
        }
        $posts = $db->prepare('SELECT  id, title, content, updatedAt, chapo,media  FROM post ORDER BY  id DESC limit 3');
        $posts->execute();

        return $posts->fetchAll();
    }


    public function getPosts()
    {
        $db = $this->dbConnect();
        if(null === $db){
            return[];
        }
        $posts = $db->prepare('SELECT id, title, content, updatedAt, chapo,media  FROM post ORDER BY id DESC');
        $posts->execute();

        return $posts->fetchAll();
    }

    /**
     * récupère un post avec id donné
     * @param mixed $id
     * 
     * @return [type]
     * 
     */
    public function getPost($id): array
    {
        $db = $this->dbConnect();
        if(null === $db){
            return[];
        }
        
        $req = $db->prepare('SELECT * FROM post where id = ?');
        $req->execute(array($id));
        return $post = $req->fetchAll();
    }
    
    public function getComments($id)
    {
        $db = $this->dbConnect();
        if(null === $db){
            return[];
        }
        $req = $db->prepare('SELECT id, content, isValidate, updatedAt, user_id, post_id FROM comment WHERE post_id = ?');
        $req->execute(array($id));
        return $comments = $req->fetchAll();
    }

   
    public function getUser($id)
    {
        $db = $this->dbConnect();
        if(null === $db){
            return[];
        }
        
        $req = $db->prepare('SELECT * FROM user where id = ?');
        $req->execute(array($id));
        return $user = $req->fetchAll();
    }
}