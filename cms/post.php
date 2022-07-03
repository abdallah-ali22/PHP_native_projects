<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

    <!-- Navigation -->
<?php include "includes/navigation.php"; ?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php 
            if(isset($_SESSION['username']))
            {
                if(isset($_GET['p_id']))
            {    
                $p_id = $_GET['p_id'];
                $up_query = "UPDATE posts SET post_views_count =post_views_count + 1 WHERE post_id = $p_id ";
                $send_query = mysqli_query($connect,$up_query);
                if(!$send_query)
                    die("Failed " . mysqli_error($connect));
            $query = "SELECT * FROM posts WHERE post_id = {$p_id}";
            $result = mysqli_query($connect,$query);
            while($row = mysqli_fetch_assoc($result)){
                $post_title = $row["post_title"];
                $post_author = $row["post_author"];
                $post_image = $row["post_image"];
                $post_date = $row["post_date"];
                $post_content = $row["post_content"];

                ?>
            <!-- <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1> -->

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title;?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author;?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date;?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content;?></p>    
            
        <?php }}
        else 
            {header("Location: index.php");}
    
            
            
    ?>
    <!-- Blog Comments -->
<?php 

    if(isset($_POST['create_comment']))
    {
        $post_id = $_GET['p_id'];
        $comment_author = $_POST['comment_author'];
        $comment_email = $_POST['comment_email'];
        $comment_content = $_POST['comment_content'];
        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){
        $query = "INSERT INTO comments (comment_post_id,comment_author,comment_email,
            comment_content,comment_status,comment_date)";
        $query .= "VALUES ({$post_id},'{$comment_author}','{$comment_email}',
            '{$comment_content}','unapproved', now())";
        $create_comment_query = mysqli_query($connect,$query);
        if(!$create_comment_query)
            die("failed " . mysqli_error($connect));
    // $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 
    //     WHERE post_id = $post_id";
    // $update_comment_count = mysqli_query($connect,$query);
    // if(!$update_comment_count)
    //     die("failed " . mysqli_error($connect));
    }
    else 
    {
        echo "<script>alert('Fields cannot be empty')</script>";
    }

    }

?>
    <!-- Comments Form -->
    <div class="well">
        <h4>Leave a Comment:</h4>
        <form role="form" action="" method="post">
            <div class="form-group">
                <label for="comment_author">Author</label>
                <input type="text" name="comment_author" id="comment_author" class="form-control">
            </div>
            <div class="form-group">
                <label for="comment_email">Email</label>
                <input type="email" name="comment_email" id="comment_email" class="form-control">
            </div>
            <div class="form-group">
                <label for="comment_content">Your Comment</label>
                <textarea class="form-control" rows="3" name="comment_content" id="comment_content"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="create_comment">Add Comment</button>
        </form>
    </div>

    <hr>

    <!-- Posted Comments -->
<?php
    $query = "SELECT * FROM comments WHERE comment_post_id = {$p_id} 
        AND comment_status = 'approved' ORDER BY comment_id DESC";
    $select_comment_query = mysqli_query($connect,$query);
    if(!$select_comment_query)
        die("Failed " . mysqli_error($connect));
    while($row = mysqli_fetch_assoc($select_comment_query)) {
        $comment_author = $row['comment_author'];
        $comment_content = $row['comment_content'];
        $comment_date = $row['comment_date'];?>
        <!-- Comment -->
    <div class="media">
        <a class="pull-left" href="#">
            <img class="media-object" src="http://placehold.it/64x64" alt="">
        </a>
        <div class="media-body">
            <h4 class="media-heading"><?php echo $comment_author; ?>
                <small><?php echo $comment_date; ?></small>
            </h4>
            <?php echo $comment_content; ?>        </div>
    </div>



    <?php }}
    else 
        echo "<h2 class='text-center'>You must log in first</h2>";
    ?>
            <hr>

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>
    <!-- Footer -->
<?php include "includes/footer.php" ?>
