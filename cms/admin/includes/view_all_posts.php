<?php
if(isset($_POST['checkBoxArray'])) 
{
foreach($_POST['checkBoxArray'] as $postValueId) {
    $bulk_option = $_POST['bulk_option'] ;
    switch($bulk_option) {
        case 'published':
            $query = "UPDATE posts SET post_status='{$bulk_option}' WHERE post_id={$postValueId}";
            $publish_query = mysqli_query($connect,$query);
            if(!$publish_query)
                die("Failed " . mysqli_error($connect,$publish_query));
            break;
        case 'draft':
            $query = "UPDATE posts SET post_status='{$bulk_option}' WHERE post_id={$postValueId}";
            $draft_query = mysqli_query($connect,$query);
            if(!$draft_query)
                die("Failed " . mysqli_error($connect,$draft_query));
            break;
        case 'delete':
            $query = "DELETE FROM posts WHERE post_id={$postValueId}";
            $del_query = mysqli_query($connect,$query);
            if(!$del_query)
                die("Failed " . mysqli_error($connect,$del_query));
            break;
        case 'clone':
            $query = "SELECT * FROM posts WHERE post_id = {$postValueId}";
            $select_query = mysqli_query($connect,$query);
            while($row = mysqli_fetch_assoc($select_query)) 
            {
                $post_title = $row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_date = $row['post_date'];
                $post_author = $row['post_author'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_content = $row['post_content'];
            }
            $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date,post_image,post_content,post_tags,post_status) ";
    
            $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}') "; 
    
            $copy_query = mysqli_query($connect, $query);
            if(!$copy_query)
                die("Failed " . mysqli_error($connect));
            break;
    }

}
}



?>
<form action="" method="post">
<table class="table table-bordered table-hover">
    <div class="col-xs-4" id="bulkOptionContainer" style="padding:0px">
        <select class="form-control" name="bulk_option" id="">
            <option value="">Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
        </select>
    </div>
    <div class="col-xs-4">
        <input class="btn btn-success" type="submit" name="submit" value="Apply">
        <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
    </div>
    <thead>
        <tr>
            <th><input type="checkbox" name="" id="selectAllBoxes"></th>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>View Post</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Views</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM posts ORDER BY post_id DESC";
        $select_posts = mysqli_query($connect,$query);
        while($row = mysqli_fetch_assoc($select_posts))
        {
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            // $post_comment_count = $row['post_comment_count'];
            $post_date = $row['post_date'];
            $post_views_count = $row['post_views_count'];
            echo "<tr>";?>
<td><input type="checkbox" class="checkBoxes" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>
            <?php
            echo " <td>$post_id</td>";
            echo " <td>$post_author</td>";
            echo " <td>$post_title</td>";
            $cat_query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
            $con_query = mysqli_query($connect,$cat_query);
            while($row = mysqli_fetch_assoc($con_query)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo " <td>{$cat_title}</td>";
            }
            //echo " <td>$post_category_id</td>";
            echo " <td>$post_status</td>";
            echo " <td><img width =100 src='../images/$post_image'></td>";
            echo " <td>$post_tags</td>";
            //new way to display comments count
            $comment_count_query = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
            $send_count_query = mysqli_query($connect,$comment_count_query);
            if(!$send_count_query)
                die("Failed " . mysqli_error($connect));
            //$row = mysqli_fetch_array($send_count_query);
            //$comment_id = $row['comment_id'];
            $comments_count = mysqli_num_rows($send_count_query);
            echo " <td><a href='post_comments.php?id=$post_id'>$comments_count</a></td>";
            echo " <td>$post_date</td>";
            echo " <td><a href='../post.php?p_id=$post_id'>View Post</a></td>";
            echo " <td><a href='posts.php?source=edit_post&p_id=$post_id'>Edit</a></td>";
            echo " <td><a onClick=\" javascript: return confirm('Are you sure you want to delete'); \" href='posts.php?delete=$post_id'>Delete</a></td>";
            echo " <td><a href='posts.php?reset=$post_id'>{$post_views_count}</a></td>";
            echo "</tr>";
        }
        
        ?>
    </tbody>
</table>
</form>
<?php
if(isset($_GET['delete']))
{
    // global $connect;
    $id = $_GET['delete'];
    $query = "DELETE FROM posts WHERE post_id = $id";
    $result = mysqli_query($connect,$query);
    if(!$result)
        echo "Failed " . mysqli_error($connect);
    
    header("Location:posts.php");
}
?>

<?php
if(isset($_GET['edit']))
{
    include "edit_post.php";
}
if(isset($_GET['reset']))
{
    $id = $_GET['reset'];
    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = $id";
    $up_query = mysqli_query($connect,$query);
    if(!$up_query)
        die("Failed " . mysqli_error($connect));
    header("Location:posts.php");
}
?>