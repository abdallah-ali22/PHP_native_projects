<?php include "includes/db.php"; ?>
<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <a href="index.php">home</a>
        <a href="#">categories</a>
        <?php if(isset($_SESSION['username'])) echo "<a href='admin.php'>Admin</a>" ?>
        <a href="register.php">register</a>
        <?php if(!isset($_SESSION['username'])) echo "<a href='login.php'>Login</a>" ?>
        <?php if(isset($_SESSION['username'])) echo "<a href='logout.php'>Logout</a>" ?>
        <a href="search.php">search</a>
        <a href="#">contact us</a>
    </nav>
    <!-- display books that in db -->
    <?php 
        $selc_query      = "SELECT * FROM books";
        $send_selc_query = mysqli_query($connect,$selc_query);
        if(!$send_selc_query)
            die("Failed to display " . mysqli_error($send_selc_query));
        while($row = mysqli_fetch_assoc($send_selc_query))
        {
            $book_name = $row['name'];
            $auth_name = $row['author_name'];
            $edition   = $row['edition'];
            $category  = $row['category'];
            $image     = $row['image'];
    ?>
    <div class="gallery">
            <a href="admin.php">
            <div class="img">
                <img src="images/<?php echo $image ?>" alt="image" width="400">
            </div>
            </a>
            <div class="desc">
                <?php echo "<b>" . $book_name . "</b>" . "<br> <b>Author: </b>" . $auth_name . "<br> <b>Edition: </b>" . $edition . "<br> <b>Category: </b>" . $category;?>
            </div>
    </div>
    <?php } ?>
    
    




        <footer>
        Library Management System 2022 @All right reserved.  
        </footer>        
</body>
</html>