<?php
require_once("new_config.php");
class Database {
    public $connect;
    function __construct() {
        $this->open_db_connection();
    }
    function open_db_connection() {
        // $this->connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        $this->connect = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        if($this->connect->connect_errno) {
            die ("Failed to connect " . $this->connect->connect_error);
        }
    }
    function query($sql) {
        $result = $this->connect->query($sql);
        $this->confirm_query($result);
        return $result;
    }
    function confirm_query($result) {
        if(!$result)
            die("Query Failed " . $this->connect->error);
    }
    function escape_string($str) {
        $escaped_string = $this->connect->real_escape_string($str);
        return $escaped_string;
    }
    function the_insert_id() {
        return mysqli_insert_id($this->connect);
    }
}
$database = new Database();

?>