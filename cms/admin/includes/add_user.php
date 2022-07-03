<?php
    if(isset($_POST['create_user']))
    {
        // global $connect;
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        $username = $_POST['username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        $user_password = mysqli_real_escape_string($connect,$user_password);
        $user_password = password_hash($user_password,PASSWORD_BCRYPT,['cost'=>10]);        
        $ins_query = "INSERT INTO users (user_firstname,user_lastname,user_role,username,
            user_email,user_password) 
            VALUES('{$user_firstname}','{$user_lastname}','{$user_role}',
            '{$username}','{$user_email}','{$user_password}')";
        $insert_query = mysqli_query($connect,$ins_query);
        if(!$insert_query)
            die("failed " . mysqli_error($connect));
        echo "User created: " . "<a href='users.php'>View Users</a>";
    }

?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" class="form-control" name="user_firstname" id="user_firstname">
    </div>
    <div class="form-group">
        <label for="user_lastname">lastname</label>
        <input type="text" class="form-control" name="user_lastname" id="user_lastname">
    </div>
    <div class="form-group">
        <!-- <label for="user_role">User Role</label> -->
        <select name="user_role" id="user_role">
            <option value="subscriber">Select Options</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
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
        <input type="text" class="form-control" name="username" id="username">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email" id="user_email">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password" id="user_password">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add user">
    </div>
</form>
