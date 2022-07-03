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
            $count = 0;
            if(isset($_SESSION['username']))
            {
                $per_page = 5;
            if(isset($_GET['page']))
            {
                $page_num = $_GET['page'];
            }
            else
            {
                $page_num = "";
            }
            if($page_num == "" || $page_num == 1)
            {
                $page_num = 0;
            }
            else
            {
                $page_num = ($page_num * $per_page ) - $per_page;
            }
            $count_query = "SELECT * FROM posts";
            $send_count_query = mysqli_query($connect,$count_query);
            $count = mysqli_num_rows($send_count_query);
            $count = ceil($count/5);
            $query = "SELECT * FROM posts WHERE post_status = 'published' LIMIT $page_num,$per_page ";
            $result = mysqli_query($connect,$query);
            if(mysqli_num_rows($result) == 0)
            {
                $count = 0;
                echo "<h2 class='text-center'>No Posts Published</h2>";
            }
            while($row = mysqli_fetch_assoc($result)){
                $post_id = $row["post_id"];
                $post_title = $row["post_title"];
                $post_author = $row["post_author"];
                $post_image = $row["post_image"];
                $post_date = $row["post_date"];
                $post_content = substr($row["post_content"],0,100);
            
                ?>
            <!-- <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1> -->

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id;?>"><?php echo $post_title;?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author;?>&p_id=<?php echo $post_id;?>"><?php echo $post_author;?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date;?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id;?>">
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                </a>
                <hr>
                <p><?php echo $post_content;?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

            
            
        <?php } }
        else 
        {
            echo "<h2 class='text-center'>No Posts Available untill you sign in</h2>";
        }
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
    <ul class="pager">
        <?php 
            for($i=1;$i<=$count;$i++)
            {
                if($i == $page_num)
                    echo "<li><a class='active_link' href='index.php?page=$i'>{$i}</a></li>";
                else    
                    echo "<li><a href='index.php?page=$i'>{$i}</a></li>";

            }          
        ?>
    </ul>
        <hr>
    <!-- Footer -->
<?php include "includes/footer.php" ?>
