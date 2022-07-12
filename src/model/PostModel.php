<?php

declare(strict_types=1);

namespace Oc\Blog\model;

use PDO;

class PostModel
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
     * @return array
     */
    public function getPostsHome() : array
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
        $posts = $db->prepare('SELECT  id, title, content, updatedAt, chapo, media  FROM post ORDER BY  id DESC limit 3');
        $posts->execute();

        return $posts->fetchAll();
    }

    /**
     * @return array
     */
    public function getPosts() : array
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        $posts = $db->prepare('SELECT * FROM post ORDER BY id DESC');
        $posts->execute();

        return $posts->fetchAll();
    }

    /**
     * @return array
     */
    public function getAdminPosts() : array {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        $posts = $db->prepare('SELECT id, title, content, createdAt, isPublished, updatedAt, chapo, media  FROM post ORDER BY isPublished ASC');
        $posts->execute();

        return $posts->fetchAll();
    }

    /**
     * @param mixed $id
     * 
     * @return array
     */
    public function getPost(mixed $id) : array
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
        
        $req = $db->prepare('SELECT * FROM post where id = ?');
        $req->execute(array($id));

        return $req->fetchAll();
    }

    /**
     * @param mixed $title
     * @param mixed $content
     * @param mixed $chapo
     * @param mixed $media
     * @param mixed $isPublished
     * @param mixed $createdAt
     * @param mixed $id_admin
     * 
     * @return array
     */
    public function insertPostInDB(mixed $title, mixed $content, mixed $chapo, mixed $media, mixed $isPublished, mixed $createdAt, mixed $id_admin) : array {

        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
        $req = $db->prepare("INSERT INTO post(title, content, chapo, media, isPublished, createdAt, user_id) 
                             VALUES(:title, :content, :chapo, :media, :isPublished, :createdAt, :user_id) ");
        $req->execute(array(
                            "title" => $title,
                            "content" => $content,
                            "chapo" => $chapo,
                            "media" => $media,
                            "isPublished" => $isPublished,
                            "createdAt" => $createdAt,
                            "user_id" => $id_admin
        ));
        die;        
    }

    public function deletePostinBDD(int $idPost) {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        $req = $db->prepare("DELETE FROM post WHERE id=:idPost");
        $req->execute(array("idPost" => $idPost));
    }

    public function updatePost(string $title, string $content, string $chapo, string $media, bool $isPublished, mixed $updatedAt, int $userId, int $idPost) {

        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
        // var_dump($title.'<br>');
        // var_dump($content.'<br>');
        // var_dump($chapo.'<br>');
        // var_dump($media.'<br>');
        // var_dump($isPublished.'<br>');
        // var_dump($updatedAt.'<br>');
        // var_dump($userId.'<br>');
        // var_dump($idPost.'<br>');

        $req = $db->prepare('UPDATE post SET title =:title, content =:content, chapo =:chapo, media =:media, isPublished =:isPublished, updatedAt =:updatedAt, user_id =:userId WHERE id =:idPost ');

        return  $req->execute(array(
            'title' => $title,
            'content' => $content,
            'chapo' => $chapo,
            'media' => $media,
            'isPublished' => $isPublished,
            'updatedAt' => $updatedAt,
            'userId' => $userId,
            'idPost' => $idPost
        )); 

    }

    public function updatePublishPost($idPost) {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        $req = $db->prepare('UPDATE post SET isPublished=1  WHERE id=:idPost');

        return  $req->execute(array(
            'idPost' => $idPost
        ));
    }
}
