<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    define("DB_HOST", "localhost");
    define("DB_NAME", "manvaasam");
    define("DB_USER", "root");
    define("DB_PASS", "");
} else {
    define("DB_HOST", "127.0.0.1");
    define("DB_USER", "u707479837_manvaasam");
    define("DB_NAME", "u707479837_manvaasam");
    define("DB_PASS", "S!mbZN#u5|");
}

date_default_timezone_set('Asia/Kolkata');
$pdoConn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
$pdoConn->exec("set names utf8");

class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $error;
    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->pass);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            $this->error = $exception->getMessage();
            echo "Connection error: " . $this->error;
        }
        return $this->conn;
    }
}
