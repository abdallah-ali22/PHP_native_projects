<?php include "includes/admin_header.php"?>
<?php
    if(isset($_SESSION['username'])) 
    {
        $username = $_SESSION['username'];
        $query = "SELECT * FROM users WHERE username = '{$username}'";
        $select_query = mysqli_query($connect,$query);
        while($row = mysqli_fetch_assoc($select_query))
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
        
        $up_query = "UPDATE users SET user_firstname='{$user_firstname}',
            user_lastname='{$user_lastname}',user_role='{$user_role}',
            username='{$username}',user_email='{$user_email}',user_password='{$user_password}'
            WHERE username = '{$username}'";
        $update_query = mysqli_query($connect,$up_query);
        if(!$update_query)
            die("failed " . mysqli_error($connect));
    }
    }

?>
<div id="wrapper">

<!-- Navigation -->

<?php include "includes/admin_nav.php"?>

<div id="page-wrapper">

<div class="container-fluid">

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Welcome to admin
            <small>Author</small>
        </h1>
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
            <option value="subscriber"><?php echo $user_role;?></option>
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
        <input type="password" value="<?php echo $user_password;?>" class="form-control" name="user_password" id="user_password">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_user" value="Edit user">
    </div>
</form>
    </div>


</div>
<!-- /.row -->

</div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include "includes/admin_footer.php" ?>
