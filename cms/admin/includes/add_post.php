<?php
    if(isset($_POST['create_post']))
    {
        // global $connect;
        $post_title = $_POST['post_title'];
        $post_author = $_POST['post_author'];
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status'];
        
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];

        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];

        $post_date = date('d-m-y');

        // $post_comment_count = 4;
        move_uploaded_file($post_image_temp, "../images/$post_image" );

        $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date,post_image,post_content,post_tags,post_status) ";
    
        $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}') "; 
    
        $create_post_query = mysqli_query($connect, $query);
        $p_id = mysqli_insert_id($connect);
        echo "<p>Post Created: <a href='../post.php?p_id={$p_id}'>View Post</a> or <a href='posts.php'>Edit Other Posts</a></p>";
        
    }

?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title" id="title">
    </div>
    <div class="form-group">
        <label for="category">Post Category</label>
    <select name="post_category" id="category" class="form-control">
        <?php
            $display_cat_query = "SELECT * FROM categories";
            $result = mysqli_query($connect,$display_cat_query);
            if(!$result)
                echo "Failed " . mysqli_error($connect);
            while($row = mysqli_fetch_assoc($result))
            {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<option value='$cat_id'>$cat_title</option>";
            }
        ?>
        </select>
    </div>
    <!-- <div class="form-group">
        <label for="author">Post Author</label>
        <input type="text" class="form-control" name="author" id="author">
    </div> -->
    <div class="form-group">
        <label for="author">Post Author</label>
    <select name="post_author" id="author" class="form-control">
        <?php
            $display_users_query = "SELECT * FROM users";
            $result = mysqli_query($connect,$display_users_query);
            if(!$result)
                echo "Failed " . mysqli_error($connect);
            while($row = mysqli_fetch_assoc($result))
            {
                $user_id = $row['user_id'];
                $username = $row['username'];
                echo "<option value='$username'>$username</option>";
            }
        ?>
        </select>
    </div>
    <div class="form-group">
        <select name="post_status" id="">
            <option value="draft">Post Status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" class="form-control" name="image" id="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" id="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" id="post_content" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
</form>
