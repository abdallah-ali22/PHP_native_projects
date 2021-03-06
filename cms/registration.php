<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php
    if(isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        //clean them up
        $username = mysqli_real_escape_string($connect, $username);
        $email = mysqli_real_escape_string($connect, $email);
        $password = mysqli_real_escape_string($connect, $password);
        if(!empty($username) && !empty($email) && !empty($password)) 
        {
        $password = password_hash($password,PASSWORD_BCRYPT,['cost' => 12]);

        // $query = "SELECT randSalt FROM users";
        // $select_randsalt_query = mysqli_query($connect,$query);
        // if(!$select_randsalt_query)
        // {
        //     die("Failed " . mysqli_error($connect));
        // }
        // $row = mysqli_fetch_assoc($select_randsalt_query);
        // $salt = $row['randSalt'];
        // //to encrypt password => crypt function takes 2 parameters 1=> the original one 2=>
        // $password = crypt($password,$salt);
        $ins_query = "INSERT INTO users (username,user_email,user_password)";
        $ins_query .= "VALUES ('{$username}','{$email}','{$password}')";
        $result_query = mysqli_query($connect,$ins_query);
        if(!$result_query)
            die("Failed " . mysqli_error($connect));
        $message = "Your registration has been submitted";
        }
        else
            $message = "Fields cannot be empty";
        
    }
    else 
        $message = "";


?>
    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    

    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <h6 class="text-center"><?php  echo $message ;?></h6>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
