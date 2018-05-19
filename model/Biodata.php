<?php

namespace CodeYourFuture\Model;

class Biodata {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function get($id) {
        $sql = $this->db->prepare("SELECT * FROM users_profile WHERE user_id=?");
        $sql->execute(array($id));
        if ($sql->rowCount() == 1) {
            $response = array("data" => $sql->fetch());
        } else {
            $response = array("error" => array(
                "code" => 404,
                "message" => "Not found."
            ));
        }
        return json_encode($response);
    }
}