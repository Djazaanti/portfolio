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

        $posts = $db->prepare('SELECT id, title, content, updatedAt, chapo, media  FROM post ORDER BY id DESC');
        $posts->execute();

        return $posts->fetchAll();
    }

    /**
     * @param int $id
     * 
     * @return array
     */
    public function getPost(int $id) : array
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
     * @param string $title
     * @param string $content
     * @param string $chapo
     * @param string $media
     * @param bool $isPublished
     * @param string $adminName
     */
    public function insertPostInDB(string $title, string $content, string $chapo, string $media, string $isPublished, mixed $createdAt, int $id_admin) {

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
                            "createdAt" => date("d_m_Y_H_i_s"),
                            "user_id" => $id_admin
        ));
        die;        
    }
}
