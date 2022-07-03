<?php
        if(isset($_GET['p_id']))
        $p_id = $_GET['p_id'];
        $query = "SELECT * FROM posts WHERE post_id = $p_id";
        $select_posts = mysqli_query($connect,$query);
        while($row = mysqli_fetch_assoc($select_posts))
        {
            
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date = $row['post_date'];
        }
            if(isset($_POST['edit']))
{
        //$edit_id = $_GET['edit_post'];escape()
        $post_title = escape($_POST['title']);
        $post_author = escape($_POST['post_author']);
        $post_category_id = escape($_POST['post_category']);
        $post_status = escape($_POST['post_status']);
        
        $post_image = escape($_FILES['image']['name']);
        $post_image_temp = escape($_FILES['image']['tmp_name']);

        $post_tags = escape($_POST['post_tags']);
        $post_content = escape($_POST['post_content']);

        $post_date = date('d-m-y');

        //$post_comment_count = 4;
        move_uploaded_file($post_image_temp, "../images/$post_image" );
        if(empty($post_image)) {
            $query = "SELECT * FROM posts WHERE post_id = $p_id ";
            $select_image = mysqli_query($connect,$query);
            while($row = mysqli_fetch_array($select_image)) {    
                $post_image = $row['post_image'];}}
        $query = "UPDATE posts SET ";
        $query .="post_title  = '{$post_title}', ";
        $query .="post_category_id = '{$post_category_id}', ";
        $query .="post_date   =  now(), ";
        $query .="post_author = '{$post_author}', ";
        $query .="post_status = '{$post_status}', ";
        $query .="post_tags   = '{$post_tags}', ";
        $query .="post_content= '{$post_content}', ";
        $query .="post_image  = '{$post_image}'";
        $query .= "WHERE post_id = {$p_id} ";
        
        $update_post = mysqli_query($connect,$query);
        if(!$update_post) echo "Failed " . mysqli_error($connect);
        //header("Location:posts.php");
        echo "<p>Post Updated: <a href='../post.php?p_id={$p_id}'>View Post</a> or <a href='posts.php'>Edit Other Posts</a></p>";
}

?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title ?>" type="text" class="form-control" name="title" id="title">
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
        <input value="<?php //echo $post_author?>" type="text" class="form-control" name="author" id="author">
    </div> -->
    <div class="form-group">
        <label for="author">Post Author</label>
    <select name="post_author" id="author" class="form-control">
        <?php echo "<option value='$post_author'>$post_author</option>";?>
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
            <option value="<?php echo $post_status;?>"><?php echo $post_status;?></option>
            <?php
                if($post_status == 'draft')
                    echo "<option value='published'>Published</option>";
                else
                    echo "<option value='draft'>Draft</option>";
            ?>
        </select>
        <!-- <label for="post_status">Post Status</label>
        <input value="" type="text" class="form-control" name="post_status" id="post_status">
    --> </div> 
    <div class="form-group">
        <img width=100 src="../images/<?php echo $post_image?>" alt="">
        <input type="file" class="form-control" name="image" id="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags?>" type="text" class="form-control" name="post_tags" id="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" id="post_content" cols="30" rows="10">
            <?php echo $post_content?>
        </textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit" value="Edit Post">
    </div>
</form>
<?php
// if(isset($_GET['edit'])){
    
//     $edit_id =  escape($_GET['p_id']);

//     }



?>
