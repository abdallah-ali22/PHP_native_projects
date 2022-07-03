<?php
    if(isset($_GET['u_id']))
    {    $the_get_id = $_GET['u_id'];
    $query = "SELECT * FROM users WHERE user_id = $the_get_id";
    $select_users = mysqli_query($connect,$query);
        while($row = mysqli_fetch_assoc($select_users))
        {
            
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_role = $row['user_role'];
            $username = $row['username'];
            $user_email = $row['user_email'];
            $user_password = $row['user_password'];
            
        }



    if(isset($_POST['update_user']))
    {
        // global $connect;
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        $username = $_POST['username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        // $query = "SELECT randSalt FROM users";
        // $select_randsalt_query = mysqli_query($connect,$query);
        // if(!$select_randsalt_query)
        // {
        //     die("Failed " . mysqli_error($connect));
        // }
        // $row = mysqli_fetch_assoc($select_randsalt_query);
        // $salt = $row['randSalt'];
        //to encrypt password => crypt function takes 2 parameters 1=> the original one 2=>
        // $hashed_password = crypt($new_user_password,$salt);
        if(!empty($user_password))
        {
            $get_password_query = "SELECT user_password FROM users WHERE user_id = $the_get_id";
            $send_password_query = mysqli_query($connect,$get_password_query);
            if(!$send_password_query)
                die("Failed " . mysqli_error($connect));
            $row = mysqli_fetch_array($send_password_query);
            $db_password = $row['user_password'];
            if($db_password != $user_password)
                $hashed_password = password_hash($user_password,PASSWORD_BCRYPT,['cost'=>10]);
            $up_query = "UPDATE users SET user_firstname='{$user_firstname}',
            user_lastname='{$user_lastname}',user_role='{$user_role}',
            username='{$username}',user_email='{$user_email}',user_password='{$hashed_password}'
            WHERE user_id = $the_get_id";
        $update_query = mysqli_query($connect,$up_query);
        if(!$update_query)
            die("failed " . mysqli_error($connect));
    }
    }
    }
    else 
        header("Location: index.php");
    // $user_password = crypt($user_password,$hashed_password);
    
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" value="<?php echo $user_firstname;?>" class="form-control" name="user_firstname" id="user_firstname">
    </div>
    <div class="form-group">
        <label for="user_lastname">lastname</label>
        <input type="text" value="<?php echo $user_lastname;?>" class="form-control" name="user_lastname" id="user_lastname">
    </div>
    <div class="form-group">
        <!-- <label for="user_role">User Role</label> -->
        <select name="user_role" id="user_role">
            <?php if(empty($user_role)) 
                echo "<option value='subscriber'>Subscriber</option>";?>
            <option value="<?php echo $user_role;?>"><?php echo $user_role;?></option>
            <?php
                if($user_role == 'admin')
                    echo "<option value='subscriber'>Subscriber</option>";
                else 
                    echo "<option value='admin'>Admin</option>";
            ?>
        </select>
    </div>
    <!-- <div class="form-group">
        <label for="category">Post Category</label>
    <select name="post_category" id="category" class="form-control"> -->
        <?php
            // $display_user_query = "SELECT * FROM users";
            // $result = mysqli_query($connect,$display_user_query);
            // if(!$result)
            //     echo "Failed " . mysqli_error($connect);
            // while($row = mysqli_fetch_assoc($result))
            // {
            //     $user_id = $row['user_id'];
            //     $user_role = $row['user_role'];
            //     echo "<option value='$user_id'>$user_role</option>";
            // }
        ?>
        <!-- </select>
    </div> -->
    <!-- <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" class="form-control" name="image" id="post_image">
    </div> -->
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" value="<?php echo $username;?>" class="form-control" name="username" id="username">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" value="<?php echo $user_email;?>" class="form-control" name="user_email" id="user_email">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" value="" class="form-control" name="user_password" id="user_password">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_user" value="Edit user">
    </div>
</form>
