<?php include "db.php" ?>
<?php session_start(); ?>
<?php
    if(isset($_POST['login']))
    {
        global $connect;
        $username = $_POST['username'];
        $password = $_POST['password'];

        // FOR SECURITY
        $username = mysqli_real_escape_string($connect,$username);
        $password = mysqli_real_escape_string($connect,$password);
        $select_query = "SELECT * FROM users WHERE username = '{$username}'AND user_role = 'admin'";
        $select_user_query = mysqli_query($connect,$select_query);
        if(!$select_user_query)
            die("failed " . mysqli_error($connect));
        while($row = mysqli_fetch_assoc($select_user_query)) {
            $db_user_id = $row['user_id'];
            $db_username = $row['username'];
            $db_user_password = $row['user_password'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            $db_user_role = $row['user_role'];  
            //$salt = $row['randSalt'];
        }
        //$password = crypt($password,$db_user_password);
    if(password_verify($password, $db_user_password))
    {
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;  
        header("Location:../admin");
    }
    else
        header("Location:../index.php");
    }


?>