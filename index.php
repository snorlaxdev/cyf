<?php
require __DIR__.'/config/conn.php';
require __DIR__.'/vendor/autoload.php';

use \Rundiz\SerialNumberGenerator\SerialNumberGenerator;

class Soal {

    function one($id) {
        global $db;
        $query = $db->prepare("SELECT * FROM users_profile WHERE user_id=?");
        $query->execute(array($id));
        if ($query->rowCount() == 1) {
            header('Content-Type: application/json');
            echo json_encode(array(
                'data' => $query->fetch()
                )
            );
        } else {
            header('Content-Type: application/json');
            echo json_encode(array(
                'error' => array(
                    'code' => 404,
                    'message' => 'User profile with id '.$id.' not found'
                )
            ));
        }
    }

    function two(){
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone-number'];
            $errors;
            if (!preg_match('/^[a-z]+$/', $username)) {
                $errors[0] = "Username must be letter and lowercase";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[1] = "Invalid email";
            }
            if (!preg_match('/^[a-z@.]+$/', $email)) {
                $errors[1] = "Invalid email";
            }
            if (!preg_match('/^[0-9+]+$/', $phone_number)) {
                $errors[2] = "Phone number must be number";
            }
            if (empty($errors)) {
                $success = "Success!";
            }
            require __DIR__.'/modules/two.php';
        } else {
            require __DIR__.'/modules/two.php';
        }
    }

    function three($total){
        $keyGen = new SerialNumberGenerator();
        $keyGen->numberChunks = 4;
        $keyGen->numberLettersPerChunk = 4;
        $keys = array();
        for ($i = 0; $i < $total; $i++) { array_push($keys, $keyGen->generate()); }
        unset($keyGen);
        header('Content-Type: application/json');
        echo json_encode(array(
            'data' => $keys
        ));
    }

    function four(){
        if (isset($_POST['submit'])) {
            $total = $_POST['total'];
            $cash = $_POST['cash'];
            if ($total > $cash) {
                $invalid = "Cash shouldn't be less than total";
                require __DIR__.'/modules/four.php';
                return;
            }
            $change = $cash - $total;
            $result;
            if ($change >= 50000) {
                $result['50000'] = ($change - ($change % 50000)) / 50000;
                $change = $change - ($change - ($change % 50000));
            }
            if ($change >= 20000) {
                $result['20000'] = ($change - ($change % 20000)) / 20000;
                $change = $change - ($change - ($change % 20000));
            }
            if ($change >= 10000) {
                $result['10000'] = ($change - ($change % 10000)) / 10000;
                $change = $change - ($change - ($change % 10000));
            }
            if ($change >= 5000) {
                $result['5000'] = ($change - ($change % 5000)) / 5000;
                $change = $change - ($change - ($change % 5000));
            }
            if ($change >= 2000) {
                $result['2000'] = ($change - ($change % 2000)) / 2000;
                $change = $change - ($change - ($change % 2000));
            }
            if ($change >= 1000) {
                $result['1000'] = ($change - ($change % 1000)) / 1000;
                $change = $change - ($change - ($change % 1000));
            }
            if ($change >= 500) {
                $result['500'] = ($change - ($change % 500)) / 500;
                $change = $change - ($change - ($change % 500));
            }
            if ($change > 0) {
                $result[$change] = 1;
            }
            $returnVal = 'Change:<br>';
            while ($element = current($result)) {
                $returnVal .= key($result).' '.$element.'x'.'<br>';
                next($result);
            }
            require __DIR__.'/modules/four.php';
        } else {
            require __DIR__.'/modules/four.php';
        }
    }

    function five(){
        // Tolonglah, saya lemah sama soal yang seperti ini :(
        echo "DWDW      DW          DW";
        echo "DW  DW    DW          DW";
        echo "DW    DW  DW    DW    DW";
        echo "DW    DW  DW  DWDWDW  DW";
        echo "DW  DW    DWDW      DWDW";
        echo "DWDW      DW          DW";
    }

    function six($id){
        global $db;
        $query_post = $db->prepare("SELECT posts.title, posts.content, users.username FROM posts JOIN users ON users.id = posts.createdBy WHERE posts.id=?");
        $query_comments = $db->prepare("SELECT comments.comment FROM comments WHERE postId=?");
        $query_post->execute(array($id));
        $query_comments->execute(array($id));
        if ($query_post->rowCount() == 1) {
            header('Content-Type: application/json');
            $result = $query_post->fetch();
            $result['comments'] = $query_comments->fetchAll();
            echo json_encode(array(
                'data' => $result
            ));
        } else {
            header('Content-Type: application/json');
            echo json_encode(array(
                'error' => array(
                    'code' => 404,
                    'message' => 'Post not found'
                )
            ));
        }
    }

    function seven($id){
        global $db;
        $query_post = $db->prepare("SELECT posts.title, posts.content, users.username FROM posts JOIN users ON users.id = posts.createdBy WHERE posts.id=?");
        $query_comments = $db->prepare("SELECT comments.comment FROM comments WHERE postId=?");
        $query_post->execute(array($id));
        $query_comments->execute(array($id));
        if ($query_post->rowCount() == 1) {
            $result = $query_post->fetch();
            $result['comments'] = $query_comments->fetchAll();
            include __DIR__.'/modules/seven.php';
        } else {
            header('Content-Type: application/json');
            echo json_encode(array(
                'error' => array(
                    'code' => 404,
                    'message' => 'Post not found'
                )
            ));
        }
    }
}

$soal = new Soal();

switch($_GET['id']) {
    case 1:
        if (!isset($_GET['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(array(
                'error' => array(
                    'code' => 400,
                    'message' => 'Bad request'
                )
            ));
            return;
        }
        $soal->one($_GET['user_id']);
        break;
    case 2:
        $soal->two();
        break;
    case 3:
        if (!isset($_GET['total'])) {
            $soal->three(1);
            return;
        }
        $soal->three($_GET['total']);
        break;
    case 4:
        $soal->four();
        break;
    case 5:
        $soal->five();
        break;
    case 6:
        if (!isset($_GET['post_id'])) {
            header('Content-Type: application/json');
            echo json_encode(array(
                'error' => array(
                    'code' => 400,
                    'message' => 'Bad request'
                )
            ));
            return;
        }
        $soal->six($_GET['post_id']);
        break;
    case 7:
        if (!isset($_GET['post_id'])) {
            header('Content-Type: application/json');
            echo json_encode(array(
                'error' => array(
                    'code' => 400,
                    'message' => 'Bad request'
                )
            ));
            return;
        }
        $soal->seven($_GET['post_id']);
        break;
    default:
        header('Content-Type: text/plain');
        echo 'For guide, please read readme.md in folder';
        break;
}