<?php include "includes/db.php"; ?>
<?php session_start();?>
<?php
    // insert new user into db
    if(isset($_POST['submit']))
    {
        // entered data 
        $username = mysqli_real_escape_string($connect,$_POST['username']);
        $user_email = mysqli_real_escape_string($connect,$_POST['user_email']);
        $user_password = mysqli_real_escape_string($connect,$_POST['user_password']);
        $user_role = mysqli_real_escape_string($connect,$_POST['user_role']);
        //password hashing
        $user_password = password_hash($user_password,PASSWORD_BCRYPT,['cost'=>10]);
        // send data to db
        $insert_query = "INSERT INTO users (name,email,password,role)";
        $insert_query .= " VALUES ('$username','$user_email','$user_password','$user_role')";
        $send_ins_query = mysqli_query($connect,$insert_query);
        if(!$send_ins_query)
            die("Failed to insert " . mysqli_error($connect));
        header("Location:index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php if(isset($_SESSION['user_email'])):?>
    <nav>
        <a href="index.php">home</a>
        <a href="#">categories</a>
        <a href='admin.php'>Admin</a>
        <a href="register.php">register</a>
        <a href="logout.php">Logout</a>
        <a href="search.php">search</a>
        <a href="#">contact us</a>
        </nav>
    <br><br>
    <div class="regst">
    
    <form action="" method="post">
    
    <label for="name">Enter your name: </label><br>
    <input type="text" name="username" id="name"><br>
    
    <label for="email">Enter your email: </label><br>
    <input type="email" name="user_email" id="email"><br>

    <label for="password">Enter your password: </label><br>
    <input type="password" name="user_password" id="password"><br>

    <label for="role">Enter your role: </label><br>
    <input type="password" name="user_role" id="role"><br>

    <input type="submit" name="submit" value="Register">
    </form>

    </div>
    <footer>
        Library Management System 2022 @All right reserved.  
    </footer> 
    <?php else: header("Location:index.php")?>
    <?php endif; ?>
    
</body>
</html>