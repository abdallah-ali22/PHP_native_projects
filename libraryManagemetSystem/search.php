<?php include "includes/db.php"; ?>
<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
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
    <br><br>
    <!-- search -->
    <div class="search">
    <form action="" method="post">
        <label for="name">Enter book name: </label><br>
        <input type="text" name="name" id="name"><br><br>
        <input type="submit" name="submit" value="Search">
    </form>    
    </div>            
    <?php
    if(isset($_POST['submit']))
    {
        $book_name = mysqli_real_escape_string($connect,$_POST['name']);
        if(isset($book_name) && !empty($book_name)){
        $select_query = "SELECT * FROM books WHERE name LIKE '%$book_name%'";
        $send_selc_query = mysqli_query($connect,$select_query);
        if(!$send_selc_query)
            die("Failed to search " . mysqli_error($connect));
    ?>
    <?php if(mysqli_num_rows($send_selc_query) > 0): ?>
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
            </tr>
        </thead>
    <tbody>
    <?php endif;?>
    <?php
        while($row = mysqli_fetch_assoc($send_selc_query))
        {
            $id          = $row['id'];
            $name        = $row['name'];
            $author_name = $row['author_name'];
            $date        = $row['date'];
            $edition     = $row['edition'];
            $category    = $row['category'];
            $image       = $row['image'];
    ?>
    <tr>
        <td><?php echo $id; ?></td>
        <td><?php echo $name; ?></td>
        <td><?php echo $author_name; ?></td>
        <td><?php echo $date; ?></td>
        <td><?php echo $edition; ?></td>
        <td><?php echo $category; ?></td> 
        <td><img src="images/<?php echo $image?>" alt="book image" width="100"></td> 
    </tr>
    <?php  }  }} ?>
            </tbody>
        </table>
    <footer>
        Library Management System 2022 @All right reserved.  
    </footer> 
</body>
</html>