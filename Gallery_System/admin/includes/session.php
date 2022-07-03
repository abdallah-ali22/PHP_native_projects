<?php

class session {

    private $signed_in = false;
    public $user_id;
    public $message;

    function __construct() {
        session_start();
        $this->check_the_login();
        $this->check_message();
    }
    // getter function of signed_in property
    function is_signed_in() {
        return $this->signed_in;
    }
    function login($user) {
        if($user) {
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->signed_in = true;
        }
    }
    function logout() {
        unset($this->user_id);
        unset($_SESSION['user_id']);
        $this->signed_in = false;
    }
    private function check_the_login() {
        if(isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true; 
        }
        else {
            unset($this->user_id);
            $this->signed_in = false;
        }
    }
    function message($msg="") {
        if(!empty($msg)) {
            $_SESSION['message'] = $msg;
        }
        else {
            return $this->message;
        }
    }
    private function check_message() {
        if(isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        }
        else {
            $this->message = "";
        }
    }
}
$session = new session();
$message = $session->message();
?>