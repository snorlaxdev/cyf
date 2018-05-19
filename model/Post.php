<?php

namespace CodeYourFuture\Model;

class Post {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function get($id) {
        $sql_post = $this->db->prepare(
            "SELECT posts.title, posts.content, users.username 
            FROM posts 
            JOIN users ON users.id = posts.createdBy 
            WHERE posts.id=?");
        $sql_comments = $this->db->prepare(
            "SELECT comments.comment FROM comments WHERE postId=?"
        );
        $sql_post->execute(array($id));
        $sql_comments->execute(array($id));
        if ($sql_post->rowCount() == 1) {
            $response = $sql_post->fetch();
            $response['comments'] = $sql_comments->fetchAll();
        } else {
            $response = array("error" => array(
                "code" => 404,
                "message" => "Not found"
            ));
        }
        return json_encode($response);
    }
}