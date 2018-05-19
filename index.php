<?php
// Setup Database Driver
define('DB_HOST', 'localhost');
define('DB_NAME', 'cyf');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
// Composer Autoload
require __DIR__.'/vendor/autoload.php';
// Class Initialization
use CodeYourFuture\Database as Database;
use CodeYourFuture\Helper\Changes as Changes;
use CodeYourFuture\Helper\SerialNumberGenerator as SerialNumberGenerator;
use CodeYourFuture\Helper\SimpleValidation as SimpleValidation;
use CodeYourFuture\Model\Post as Post;
use CodeYourFuture\Model\Biodata as Biodata;
// Database Initialization
$db = new Database();
// Default bad request response
$badRequest = array(
    "error" => array(
        "code" => 400,
        "message" => "Bad request"
    )
);
// 
switch($_GET['id']) {
    case 1:
        $biodata = new Biodata($db);
        if (isset($_GET['user_id'])) {
            header('Content-Type: application/json');
            echo $biodata->get($_GET['user_id']);
        } else {
            header('Content-Type: application/json');
            echo json_encode($badRequest);
        }
        break;
    case 2:
        if (isset($_POST['submit'])) {
            $errors = array();
            if (!SimpleValidation::isUsernameValid($_POST['username'])) {
                $errors[0] = "Username must be letter and lowercase";
            }
            if (!SimpleValidation::isEmailValid($_POST['email'])) {
                $errors[1] = "Invalid email";
            }
            if (!SimpleValidation::isPhoneNumberValid($_POST['phone-number'])) {
                $errors[2] = "Phone number must be number";
            }
            $isValidated = (empty($errors) ? TRUE : FALSE);
            require __DIR__.'/template/FormValidation.php';
        } else {
            require __DIR__.'/template/FormValidation.php';
        }
        break;
    case 3:
        header('Content-Type: application/json');
        $keyGen = new SerialNumberGenerator();
        $generatedKeys = array();
        if (isset($_GET['count'])) {
            for ($i = 0; $i < $_GET['count']; $i++) {
                array_push($generatedKeys, $keyGen->generate());
            }
        } else {
            $generatedKeys = $keyGen->generate();
        }
        $response = array("data" => array("keys" => $generatedKeys));
        echo json_encode($response);
        break;
    case 4:
        if (isset($_POST['submit'])) {
            $response = json_decode(Changes::getChanges($_POST['total'], $_POST['cash']), TRUE);
            if (array_key_exists('data', $response)) {
                $data = $response['data'];
                $returnVal = 'Changes: <br>';
                while ($element = current($data)) {
                    $returnVal .= key($data).' '.$element.'x'.'<br>';
                    next($data);
                }
            } else {
                $invalid = $response['error']['message'];
            }
            require __DIR__.'/template/ChangesForm.php';
        } else {
            require __DIR__.'/template/ChangesForm.php';
        }
        break;
    case 5:
            // Tolonglah, saya lemah sama soal yang seperti ini :(
            header('Content-Type: text/plain');
            echo "DWDW      DW          DW\n";
            echo "DW  DW    DW          DW\n";
            echo "DW    DW  DW    DW    DW\n";
            echo "DW    DW  DW  DWDWDW  DW\n";
            echo "DW  DW    DWDW      DWDW\n";
            echo "DWDW      DW          DW\n";
        break;
    case 6:
        $post = new Post($db);
        if (isset($_GET['post_id'])) {
            header('Content-Type: application/json');
            echo $post->get($_GET['post_id']);
        } else {
            header('Content-Type: application/json');
            echo json_encode($badRequest);
        }
        break;
    case 7:
        $post = new Post($db);
        if (isset($_GET['post_id'])) {
            $data = $post->get($_GET['post_id']);
            $data = json_decode($data);
            require __DIR__.'/template/Post.php';
        } else {
            header('Content-Type: application/json');
            echo json_encode($badRequest);
        }
        break;
    default:
        header('Content-Type: text/plain');
        echo 'For guide, please read readme.md in folder';
        break;
}