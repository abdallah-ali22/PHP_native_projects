<?php session_start(); ?>
<?php
    $_SESSION['username'] = null;
    $_SESSION['user_email'] = null; 
    header("Location:index.php");
?>