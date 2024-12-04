<?php

namespace app\models;

use PDO;

class Post {
    private $db;

    public function __construct() {
        $dsn = 'mysql:host=' . DBHOST . ';dbname=' . DBNAME;
        $username = DBUSER;
        $password = DBPASS;

        try {
            $this->db = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            error_log("Connection error: " . $e->getMessage());
            throw new \Exception("Database connection error");
        }
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO posts (title, content) VALUES (:title, :content)");
        $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
        $stmt->bindParam(':content', $data['content'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getAllPosts() {
        $stmt = $this->db->prepare("SELECT * FROM posts ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPostById($id) {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function update($id, $title, $content) {
        $stmt = $this->db->prepare("UPDATE posts SET title = :title, content = :content WHERE id = :id");
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }    

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}