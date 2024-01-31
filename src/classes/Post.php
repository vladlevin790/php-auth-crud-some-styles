<?php

namespace src\classes;

require_once("Database.php");

class Post extends Database
{
    public $title;
    public $content;
    public $user_id;

    public function __construct(string $title, string $content, int $user_id)
    {
        $this->title = $title;
        $this->content = $content;
        $this->user_id = $user_id;
        parent::__construct("localhost:3308", "root", "", "AutorizationTest");
    }

    public function createPost()
    {
        $query = "INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)";
        $statement = $this->mysqli->prepare($query);
        $statement->bind_param("ssi", $this->title, $this->content, $this->user_id);
        return $statement->execute();
    }

    public function readPosts()
    {
        $query = "SELECT id, title, content, user_id FROM posts";
        $result = $this->mysqli->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updatePost($postId, $newTitle, $newContent)
    {
        $query = "UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?";
        $statement = $this->mysqli->prepare($query);
        $statement->bind_param("ssii", $newTitle, $newContent, $postId, $this->user_id);
        return $statement->execute();
    }

    public function deletePost($postId)
    {
        $query = "DELETE FROM posts WHERE id = ? AND user_id = ?";
        $statement = $this->mysqli->prepare($query);
        $statement->bind_param("ii", $postId, $this->user_id);
        return $statement->execute();
    }
}

?>
