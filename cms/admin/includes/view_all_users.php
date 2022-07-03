<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM users";
        $select_posts = mysqli_query($connect,$query);
        while($row = mysqli_fetch_assoc($select_posts))
        {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];    
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
            echo "<tr>";
            echo " <td>$user_id</td>";
            echo " <td>$username</td>";
            echo " <td>$user_firstname</td>";
            // $cat_query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
            // $con_query = mysqli_query($connect,$cat_query);
            // while($row = mysqli_fetch_assoc($con_query)) {
            //     $cat_id = $row['cat_id'];
            //     $cat_title = $row['cat_title'];
            //     echo " <td>{$cat_title}</td>";
            // }
            echo " <td>$user_lastname</td>";
            echo " <td>$user_email</td>";
            // $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
            // $select_post_id_query = mysqli_query($connect,$query);
            // while($row = mysqli_fetch_assoc($select_post_id_query)) {
            //     $post_id = $row['post_id'];
            //     $post_title = $row['post_title'];
            //     echo " <td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
            // }

            
            echo " <td>$user_role</td>";
            echo " <td><a href='users.php?change_to_admin=$user_id'>Admin</a></td>";
            echo " <td><a href='users.php?change_to_sub=$user_id'>Subscriber</a></td>";
            echo " <td><a href='users.php?delete=$user_id'>Delete</a></td>";
            echo " <td><a href='users.php?source=edit_user&u_id=$user_id'>Edit</a></td>";
            echo "</tr>";
        }
        
        ?>
    </tbody>
</table>
<?php
if(isset($_GET['change_to_admin']))
{
    $user_id = $_GET['change_to_admin'];
    $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $user_id";
    $result = mysqli_query($connect,$query);
    if(!$result)
        echo "Failed " . mysqli_error($connect);
    
    header("Location:users.php");
}
if(isset($_GET['change_to_sub']))
{
    $user_id = $_GET['change_to_sub'];
    $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $user_id";
    $result = mysqli_query($connect,$query);
    if(!$result)
        echo "Failed " . mysqli_error($connect);
    
    header("Location:users.php");
}
if(isset($_GET['delete']))
{
    if(isset($_SESSION['user_role']))
    {
        if($_SESSION['user_role'] == 'admin')
        {
            $d_id = $_GET['delete'];
            $d_id = mysqli_real_escape_string($connect,$d_id);
            $query = "DELETE FROM users WHERE user_id = $d_id";
            $result = mysqli_query($connect,$query);
            if(!$result)
                echo "Failed " . mysqli_error($connect);
            
            header("Location:users.php");
        }
    }
}
?>

<?php
if(isset($_GET['edit_user']))
{
    include "edit_user.php";
}
?>