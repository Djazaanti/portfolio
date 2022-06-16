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

        $req = $db->prepare('SELECT id, content, isValidate, updatedAt, user_id, post_id FROM comment WHERE post_id = ?');
        $req->execute(array($id));

        return $req->fetchAll();
    }

    /**
     * @return array
     */
    public function getCommentairesAValider() : array {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        $req = $db->prepare('SELECT user.pseudo, user.email, comment.user_id, comment.id, comment.content, comment.createdAt, post.title
                            FROM comment
                            JOIN user
                            ON comment.user_id = user.id
                            JOIN post
                            ON comment.post_id = post.id
                            WHERE isValidate = 1');
        $req->execute();

        return $req->fetchAll();
    }
}
