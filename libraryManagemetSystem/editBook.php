<?php include "includes/db.php"; ?>
<?php session_start() ?>
<?php

    if(isset($_GET['up_id']))
    {
        $up_id = $_GET['up_id'];
        $display_query = "SELECT * FROM books WHERE id = $up_id";
        $send_display_query = mysqli_query($connect,$display_query);
        if(!$send_display_query)
            die("Failed to display " . mysqli_error($connect));
        $row = mysqli_fetch_assoc($send_display_query);        
            $id        = $row['id'];
            $book_name = $row['name'];
            $auth_name = $row['author_name'];
            $date      = $row['date'];
            $edition   = $row['edition'];
            $category  = $row['category'];
            $image     = $row['image'];
    }
    if(isset($_POST['submit']))
    {
        // $up_id = $_GET['up_id'];
        $book_name = $_POST['book_name'];
        $auth_name = $_POST['auth_name'];
        $date      = $_POST['date'];
        $edition   = $_POST['edition'];
        $category  = $_POST['category'];
        $image     = $_POST['image'];

        if(empty($image)){
            $selc_query      = "SELECT * FROM books WHERE id = $up_id";
            $send_selc_query = mysqli_query($connect,$selc_query);
            $row = mysqli_fetch_array($send_selc_query);     
                $image = $row['image'];
        }

        $update_query = "UPDATE books SET name = '$book_name', author_name = '$auth_name',
        date = '$date', edition = '$edition', category = '$category',image = '$image' WHERE id = $id ";
        $send_up_query = mysqli_query($connect,$update_query);
        if(!$send_up_query)
            die("Failed to update " . mysqli_error($connect) );
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
        <?php if(!isset($_SESSION['username'])) echo "<a href='login.php'>Login</a>" ?>
        <a href="logout.php">Logout</a>
        <a href="#">contact us</a>
        </nav>
        <!-- insert a book  -->
        
        <div class="editForm">
        <form action="" method="post">

            <label for="">Add a new book </label><br>

            <label for="book_name">Book name: </label><br>
            <input type="text" name="book_name" value="<?php echo $book_name;?>" id="book_name"><br>

            <label for="auth_name">Author name: </label><br>
            <input type="text" name="auth_name" value="<?php echo $auth_name;?>" id="auth_name"><br>

            <label for="date">Date of submission: </label><br>
            <input type="date" name="date" value="<?php echo $date;?>" id="date"><br>

            <label for="edition">Book edition: </label><br>
            <input type="text" name="edition" value="<?php echo $edition;?>" id="edition"><br>

            <label for="category">Book category: </label><br>
            <input type="text" name="category" value="<?php echo $category;?>" id="category"><br>

            <label for="image">Book Image: </label><br>
            <img src="images/<?php echo $image?>" alt="image" width="100"><br>
            <input type="file" name="image" id="image"><br><br>

            <input type="submit" name="submit" value="Edit">

        </form>
        </div>
        
        <footer>
        Library Management System 2022 @All right reserved.  
        </footer> 
        <?php endif; ?>

</body>
</html>
