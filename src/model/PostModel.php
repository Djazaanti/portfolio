<?php

declare(strict_types=1);

namespace Oc\Blog\model;

use PDO;

class PostModel
{
    /**
     * @return \PDO|null
     */
    public function dbConnect(): ?\PDO
    {
        try {
            $db = new \PDO('mysql:host=127.0.0.1;port=3306;dbname=blog;charset=UTF8', 'root', '');
            return $db;
        } catch (\PDOException $e) {
            echo $e->getMessage();

            return null;
        }
    }

    /*
     * Get all post ordered by their identifier
     * @return array
     */
    public function getPosts(): array
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
        try {
                       
        $posts = $db->prepare('SELECT * FROM post ORDER BY id DESC');
        $posts->execute();

        return $posts->fetchAll();
        } catch (\PDOException $e) {
            $ErrorMessage = $e->getMessage();
            return [];
        }
    }

    /**
     * * Get all post for Admin
     * @return array empty if not found
     */
    public function getAdminPosts() : array
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        try {
            $posts = $db->prepare('SELECT id, title, content, createdAt, isPublished, updatedAt, chapo, media  FROM post ORDER BY id DESC');
            $posts->execute();
    
            return $posts->fetchAll();
        } catch (\PDOException $e) {
            $ErrorMessage = $e->getMessage();
            return [];
        }

    }

    /**
     * @param int $id
     * 
     * @return array
     */
    public function getPost(int $id): array
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
        try {
            $req = $db->prepare('SELECT * FROM post where id = ?');
            $req->execute(array($id));
    
            return $req->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $ErrorMessage = $e->getMessage();
            return [];
        }

    }

    /**
     * @param string $title
     * @param string $content
     * @param string $chapo
     * @param bool $isPublished
     * @param int $userId
     * @param string $media
     * 
     * @return array
     */
    public function  addPost(string $title, string $content, string $chapo, bool $isPublished, int $userId, string $media) : array {

        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
        try {
            $req = $db->prepare("INSERT INTO post(title, content, chapo, media, isPublished, createdAt, updatedAt, user_id) 
                             VALUES(:title, :content, :chapo, :media, :isPublished, :createdAt, :updatedAt, :user_id) ");
            $req->execute(array(
                            "title" => $title,
                            "content" => $content,
                            "chapo" => $chapo,
                            "media" => $media,
                            "isPublished" => $isPublished,
                            "createdAt" => date("Y_m_d_H_i_s"),
                            "updatedAt" => date("Y_m_d_H_i_s"),
                            "user_id" => $userId
        ));
        } catch (\PDOException $e) {
            $ErrorMessage = $e->getMessage();
            return [];
        }
              
    }

    /**
     * @param int $idPost
     * 
     * @return void
     */
    public function deletePostinBDD(int $idPost): void
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return;
        }

        try {
            $req = $db->prepare("DELETE FROM post WHERE id=:idPost");
            $req->execute(array("idPost" => $idPost));

        } catch (\PDOException $e) {
            $ErrorMessage = $e->getMessage();
        }
    }

    /**
     * @param string $title
     * @param string $content
     * @param string $chapo
     * @param string $media
     * @param bool $isPublished
     * @param mixed $updatedAt
     * @param int $authorId
     * @param int $idPost
     * 
     * @return array
     */
    public function updatePost(string $title, string $content, string $chapo, string $media, bool $isPublished, int $authorId, int $idPost): array|bool
    { 
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
        try {
            $req = $db->prepare('UPDATE post SET title =:title, content =:content, chapo =:chapo, media =:media, isPublished =:isPublished, updatedAt =:updatedAt, user_id =:userId WHERE id =:idPost ');

            return  $req->execute(array(
                'title' => $title,
                'content' => $content,
                'chapo' => $chapo,
                'media' => $media,
                'isPublished' => $isPublished,
                'updatedAt' => date("Y-m-d H:i:s"),
                'userId' => $authorId,
                'idPost' => $idPost
            )); 
        } catch (\PDOException $e) {
            $ErrorMessage = $e->getMessage();
            return [];
        }
    }

    /**
     * @param int $idPost
     * 
     * @return array
     */
    public function updatePublishPost(int $idPost): array|bool {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        try {
            $req = $db->prepare('UPDATE post SET isPublished=1  WHERE id=:idPost');

            return  $req->execute(array(
                'idPost' => $idPost
            ));
        } catch (\PDOException $e) {
            $ErrorMessage = $e->getMessage();
            return [];
        }
    }

    /**
     * @return int|null
     */
    public function countPostsToPublish() : ?int {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
        try {
            $req = $db->prepare('SELECT id FROM post WHERE isPublished=0');
            $req->execute();
            return $postsToPublish = $req->rowCount(); 
        } catch (\PDOException $e) {
            $ErrorMessage = $e->getMessage();
            return null;
        }
    }

    /**
     * @return int|null
     */
    public function countPostsPublished() : ?int {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
        try {
            $req = $db->prepare('SELECT id FROM post WHERE isPublished=1');
            $req->execute();

            return $postsPublished = $req->rowCount(); 
        } catch (\PDOException $e) {
            $ErrorMessage = $e->getMessage();
            return null;
        }
    }

}
