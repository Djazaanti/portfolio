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

    
    /**
     * @return [type]
     * récupère tous les posts
     */
    public function getPostsPosts()
    {
        if(null === $this->db){
            return[];
        }
        $posts = $this->db->prepare('SELECT * FROM article');
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
    public function getPost($id)
    {
        if(null === $this->db){
            return[];
        }
        
        $req = $this->db->prepare('SELECT * FROM article where id = ?');
        $post = $req->execute($id);

        return $post;
    }
    
    public function getComments($id)
    {
        if(null === $this->db){
            return[];
        }
        $req = $this->db->prepare('SELECT id, content, isValidate, createdAt, User_id, Article_id FROM comments WHERE Article_id = ?');
        $comments = $req->execute($id);

        return $comments->fetchAll();
    }

   
    public function getUser($id)
    {
        if(null === $this->db){
            return[];
        }
        
        $req = $this->db->prepare('SELECT * FROM user where id = ?');
        $user = $req->execute($id);

        return $user;
    }


}
