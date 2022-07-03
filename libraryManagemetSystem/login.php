<?php include "includes/db.php"; ?>
<?php session_start();?>
<?php
    if(isset($_POST['submit']))
    {
        $user_email = mysqli_real_escape_string($connect,$_POST['user_email']);
        $user_password = mysqli_real_escape_string($connect,$_POST['user_password']);

        $select_query = "SELECT * FROM users WHERE email = '{$user_email}' AND role = 'admin'";
        $send_selc_query = mysqli_query($connect,$select_query);
        if(!$send_selc_query)
            die("failed " . mysqli_error($connect));
        if(mysqli_num_rows($send_selc_query) > 0){
        while($row = mysqli_fetch_assoc($send_selc_query))
        {
        $user_id = $row['id'];
        $username = $row['name'];
        $user_email = $row['email'];
        $db_user_password = $row['password'];
        }
        if(password_verify($user_password, $db_user_password))
        {
            $_SESSION['username'] = $username;
            $_SESSION['user_email'] = $user_email; 
            header("Location:admin.php");
        }
        }
        
        }
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php if(!isset($_SESSION['user_email'])): ?>
    <nav>
        <a href="index.php">home</a>
        <a href="#">categories</a>
        <a href="register.php">register</a>
        <a href="search.php">search</a>
        <a href="#">contact us</a>
    </nav>

    <div class="loginFrom">

    <form action="" method="post">

    <label for="email">Enter your email: </label><br>
    <input type="email" name="user_email" id="email"><br>

    <label for="password">Enter your password: </label><br>
    <input type="password" name="user_password" id="password"><br>

    <input type="submit" name="submit" value="Login">
    </form>

    </div>
    
    
    <footer>
        Library Management System 2022 @All right reserved.  
    </footer> 
    <?php else:header("Location:admin.php")?>
    <?php endif;?>
</body>
</html>