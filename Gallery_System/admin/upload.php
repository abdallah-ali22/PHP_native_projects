<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php
$msg = "";
if(isset($_POST['submit'])) {
    $photo = new Photo();
    $photo->title = $_POST['title'];
    $photo->set_file($_FILES['file_upload']);
    if($photo->save()) {
        $msg = "Photo uploaded successfully";
    }
    else {
        $msg = join("<br>", $photo->errors);
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
            Uploads
            <small>Subheading</small>
            </h1>


            <?php echo "<h3>{$msg}<h3>";?>
            <div class="col-md-6">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control">
                </div>
                <div class="form-group">
                    <input type="file" name="file_upload" id="">
                </div>
                <input type="submit" value="Submit" name="submit">
            </form>
            </div>



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