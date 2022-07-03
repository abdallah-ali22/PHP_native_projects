<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>
<?php
if(empty($_GET['id'])) {
    redirect("users.php");
}
$user = User::search_by_id($_GET['id']);
if(isset($_POST['update'])) {
    $user->username = $_POST['username'];
    $user->first_name = $_POST['first_name'];
    $user->last_name = $_POST['last_name'];
    $user->password = $_POST['password'];
    if(empty($_FILES['user_image'])) {
        $user->save();
        $session->message("The user has been updated");
        redirect("users.php");
        
    }
    else {
        $user->set_file($_FILES['user_image']);
        $user->save_user_and_image();
        $user->save();
        // redirect("edit_user.php?id={$user->id}");
        $session->message("The {$user->username} user has been updated");
        redirect("users.php");
        
    }
    
}
?>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <?php include ('includes/top_nav.php'); ?>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <?php include ('includes/side_nav.php'); ?>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">


        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
            <div class="col-lg-12">
            <h1 class="page-header">
            Photos
            <small>Subheading</small>
            </h1>
            <div class="col-md-6">
                <img src="<?php echo $user->image_path_and_placeholder();?>" class="img-responsive" alt="">
            </div>
            <form action="" method="post" enctype="multipart/form-data" >
            <div class="col-md-6">
                <div class="form-group">
                    <input type="file" name="user_image">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" value="<?php echo $user->username;?>" id="username" class="form-control">
                </div>
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" value="<?php echo $user->first_name;?>" id="first_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" value="<?php echo $user->last_name;?>" id="last_name" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" value="<?php echo $user->password;?>" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <a href="delete_user.php?id=<?php echo $user->id;?>" class="btn btn-danger">Delete</a>
                    <input type="submit" value="Update" name="update" class="btn btn-primary pull-right">
                </div>
                
            </div>
            
            

                </form>
            <!-- <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> Blank Page
            </li>
            </ol> -->
            </div>
            </div>
            <!-- /.row -->

            </div>



            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>