<?php

declare(strict_types=1);

namespace Oc\Blog\model;

use PDO;

class CommentModel
{
    /**
     * @return \PDO|null
     */
    public function dbConnect() : ?\PDO
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
     * @param int $id
     * 
     * @return array
     */
    public function getComments(int $id) : array
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        try {
            $req = $db->prepare('SELECT id, content, isValidate, updatedAt, user_id, post_id FROM comment WHERE post_id = ?');
            $req->execute(array($id));
    
            return $req->fetchAll();
        } catch (PDOException $e) {
            $ErrorMessage = $e->getMessage();
        }
    }

   
    /**
     * @param string $comment
     * @param id $user
     * @param id $postId
     * 
     * @return [type]
     */
    public function saveComment(string $comment, int $user, int $postId)  {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        $isValidate = 0 ;
        $createdAt = date("Y-m-d H:i:s"); 
        $updatedAt = date("Y-m-d H:i:s");
        
        try {
            $req = $db->prepare('INSERT INTO comment (content, isValidate, createdAt, updatedAt, user_id, post_id) VALUES(:content, :isValidate, :createdAt, :updatedAt, :user_id, :post_id) ');
            $req->execute(array(
                "content" => $comment,
                "isValidate" => $isValidate,
                "createdAt" => $createdAt,
                "updatedAt" => $updatedAt,
                "user_id" => $user,
                "post_id" => $postId
            ));
        } catch (PDOException $e) {
            $ErrorMessage = $e->getMessage();
        }

    }

    /**
     * @return array
     */
    public function getCommentsToValid() : array {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
        try {
            $req = $db->prepare('SELECT user.pseudo, user.email, comment.user_id, comment.id, comment.content, comment.createdAt, post.title
                                FROM comment
                                JOIN user
                                ON comment.user_id = user.id
                                JOIN post
                                ON comment.post_id = post.id
                                WHERE comment.isValidate = 0');
            $req->execute();
    
            return $req->fetchAll();
        } catch (PDOException $e) {
            $ErrorMessage = $e->getMessage();
        }
    }

    public function updateValidComment( int $idComment) {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
        try {
            $req = $db->prepare('UPDATE comment SET isValidate=:isValidate WHERE id=:id');
            $req->execute(array(
                "isValidate" => 1,
                "id" => $idComment
            ));     
            
            return $req;
        } catch (PDOException $e) {
            $ErrorMessage = $e->getMessage();
        }
    }

    /**
     * @param int $idComment
     * 
     * @return [type]
     */
    public function updateDeleteComment(int $idComment) {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        try {
            $req = $db->prepare('DELETE FROM comment WHERE id=:id');
            $req->execute(array(
                "id" => $idComment
            )); 
        } catch (PDOException $e) {
            $ErrorMessage = $e->getMessage();
        }    
    }

    /**
     * @return int
     */
    public function countCommentsToValid() : int {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        try {
            $req = $db->prepare('SELECT id FROM comment WHERE isValidate=0');
            $req->execute();
            return $commentsToValid = $req->rowCount(); 
        } catch (PDOException $e) {
            $ErrorMessage = $e->getMessage();
        }  
    }

}
