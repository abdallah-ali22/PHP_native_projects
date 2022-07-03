
<form action="" method="post">
<div class="form-group">
    <label for="cat_title_update">Update Category</label>
    <?php
        if(isset($_GET['edit']))
        {
            $cat_id_update = $_GET['edit'];
            $query = "SELECT * FROM categories where cat_id = $cat_id_update";
            $select_categories = mysqli_query($connect,$query);
            while($row = mysqli_fetch_assoc($select_categories))
            {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
            }?>
            <input value="<?php if(isset($cat_title)) echo $cat_title; ?>" type="text" name="cat_title" class="form-control" id="cat_title_update">
    <?php }?>
    <?php
    if(isset($_POST['update_category']))
    {
        $cat_title = $_POST['cat_title'];
        $query = "UPDATE categories SET cat_title = '$cat_title' WHERE cat_id = $cat_id";
        $update_query = mysqli_query($connect,$query);
    }
    
    ?>

    
</div>
<div class="form-group">
    <input type="submit" name="update_category" class="btn btn-primary" value="Update Categories">
</div>
</form>



