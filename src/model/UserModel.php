<?php

declare(strict_types=1);

namespace Oc\Blog\model;

class UserModel extends Model
{

    /**
     * @return [type]
     * récupère tous les posts
     */
    public function getPostsPosts()
    {
        if(null === $db){
            return[];
        }
        $req = $db->prepare('SELECT * FROM article');
        $req->execute();

        return $req->fetchAll();
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
        if(null === $db){
            return[];
        }
        
        $req = $db->prepare('SELECT * FROM article where id = ?');
        $posts = $req->execute($id);

        return $posts;
    }
    
    public function getComments($id)
    {
        if(null === $db){
            return[];
        }
        $req = $db->prepare('SELECT id, content, isValidate, createdAt, User_id, Article_id FROM comments WHERE Article_id = ?');
        $comments = $req->execute($id);

        return $comments;
    }

    /**
     * - Se connecter à la base de données
     * - Récupérer les utilisateurs
     * @return array d'utilisateurs
     */
    public function getUsers(): array
    {
        //$db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        $req = $db->prepare('SELECT pseudo FROM user');
        $req->execute();

        return $req->fetchAll();
    }

    public function getUser($id)
    {
        if(null === $db){
            return[];
        }
        
        $req = $db->prepare('SELECT * FROM user where id = ?');
        $user = $req->execute($id);

        return $user;
    }


}
