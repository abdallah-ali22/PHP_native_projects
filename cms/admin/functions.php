<?php
function escape($string)
{
    global $connect;
    return mysqli_real_escape_string($connect, trim($string));
}
function users_online()
{
    global $connect;
    $session = session_id();
    $time    = time();
    $time_out_in_seconds = 60;
    $time_out = $time - $time_out_in_seconds;
    $select_query = "SELECT * FROM users_online WHERE session = '$session'";
    $send_query   = mysqli_query($connect,$select_query);
    $count = mysqli_num_rows($send_query);
    if($count == null) {
        mysqli_query($connect,"INSERT INTO users_online(session,time) VALUES ('$session','$time')"); 
    }
    else {
        mysqli_query($connect,"UPDATE users_online SET time = '$time' WHERE session = '$session'"); 
    }  
    $user_online_query = mysqli_query($connect,"SELECT* FROM users_online WHERE time > '$time_out'");
    return $count_users = mysqli_num_rows($user_online_query);
}
function insert_categories()
{
    global $connect;
    if(isset($_POST['submit']))
    {
        $cat_title = $_POST['cat_title'];
        if($cat_title=="" || empty($cat_title))
        {
            echo "This field should not be empty <br>";
        }
        else
        {
            $query = "INSERT INTO categories (cat_title) VALUES ('$cat_title')";
            $add_category = mysqli_query($connect,$query);
            if(!$add_category)
                echo "Failed " . mysqli_error($connect);
        }
    }
}

function findAllCategories()
{
    global $connect;
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connect,$query);
    while($row = mysqli_fetch_assoc($select_categories))
    {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>$cat_id</td>";
        echo "<td>$cat_title</td>";
        echo "<td><a href='categories.php?delete=$cat_id'>Delete</a></td>";
        echo "<td><a href='categories.php?edit=$cat_id'>Edit</a></td>";
        echo "</tr>";
    }
}

function deleteCategories()
{
global $connect;
if(isset($_GET['delete']))
    {
    $the_cat_id = $_GET['delete'];
    $query = "DELETE FROM categories WHERE cat_id = $the_cat_id";
    $delete_query = mysqli_query($connect,$query);
    //for refreshing
    header("Location:categories.php");
    }
}

?>