<?php

namespace CodeYourFuture;
use \PDO as PDO;

class Database extends PDO {
    public function __construct() {
        parent::__construct("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USERNAME, DB_PASSWORD);
        PDO::setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        PDO::setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
        PDO::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}