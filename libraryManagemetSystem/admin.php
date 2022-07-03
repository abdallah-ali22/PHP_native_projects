<?php include "includes/db.php"; ?>
<?php session_start() ?>
<?php

    if(isset($_POST['submit']))
    {
        $book_name = $_POST['book_name'];
        $auth_name = $_POST['auth_name'];
        $date = $_POST['date'];
        $edition = $_POST['edition'];
        $category = $_POST['category'];
        $image = $_POST['image'];

        $insert_query = "INSERT INTO books (name,author_name,date,edition,category,image)";
        $insert_query .= " VALUES ('$book_name','$auth_name','$date','$edition','$category','$image')";
        $send_ins_query = mysqli_query($connect,$insert_query);
        if(!$send_ins_query)
            die("Failed to insert " . mysqli_error($connect) );
        header("Location:admin.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php 
        if(isset($_SESSION['user_email'])):?>
        <nav>
        <a href="index.php">home</a>
        <a href="#">categories</a>
        <a href='admin.php'>Admin</a>
        <a href="register.php">register</a>
        <a href="logout.php">Logout</a>
        <a href="search.php">search</a>
        <a href="#">contact us</a>
        </nav>
        <!-- insert a book  -->
        <div class="adminForm">
        
        <form action="" method="post">

            <label for=""><b>Add a new book</b></label><br>

            <label for="book_name">Book name: </label><br>
            <input type="text" name="book_name" id="book_name"><br>

            <label for="auth_name">Author name: </label><br>
            <input type="text" name="auth_name" id="auth_name"><br>

            <label for="date">Date of submission: </label><br>
            <input type="date" name="date" id="date"><br>

            <label for="edition">Book edition: </label><br>
            <input type="text" name="edition" id="edition"><br>

            <label for="category">Book category: </label><br>
            <input type="text" name="category" id="category"><br>
            
            <label for="image">Book Image</label><br>
            <input type="file" name="image" id="image"><br><br>

            <input type="submit" name="submit" value="Add">

        </form>

        </div>
        <!-- display books -->
        
        <table>
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Book Name</th>
                    <th>Author Name</th>
                    <th>Date</th>
                    <th>Edition</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>append</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                    $display_query = "SELECT * FROM books";
                    $send_display_query = mysqli_query($connect,$display_query);
                    if(!$send_display_query)
                        die("Failed to display " . mysqli_error($connect));
                    while($row = mysqli_fetch_assoc($send_display_query))
                    {
                        $id        = $row['id'];
                        $book_name = $row['name'];
                        $auth_name = $row['author_name'];
                        $date      = $row['date'];
                        $edition   = $row['edition'];
                        $category  = $row['category'];
                        $image     = $row['image'];

                        echo "<tr>";
                        echo "<td>$id</td>";
                        echo "<td>$book_name</td>";
                        echo "<td>$auth_name</td>";
                        echo "<td>$date</td>";
                        echo "<td>$edition</td>";
                        echo "<td>$category</td>";
                        echo "<td><img src='images/$image' alt='book image' width='100' ></td>";
                        echo "<td><a href='editBook.php?up_id=$id'>Edit</a>||<a href='admin.php?del_id=$id'>Delete</a></td>";
                        echo "</tr>";
                    }
                ?>

            </tbody>
        </table>
        <!-- <footer>
        Library Management System 2022 @All right reserved.  
        </footer>   -->
        <?php else: header("Location:login.php")?>
        <?php endif; ?>

</body>
</html>
<!-- delete a book -->
<?php
    if(isset($_GET['del_id']))
    {
        $del_id = $_GET['del_id'];
        $del_query = "DELETE FROM books WHERE id = $del_id";
        $send_del_query = mysqli_query($connect,$del_query);
        if(!$send_del_query)
            die("Failed to delete " . mysqli_error($connect));
        header("Location:admin.php");
    }
?>