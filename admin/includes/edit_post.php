<?php 
    if (isset($_GET['p_id'])) {
        $post_id = $_GET['p_id'];
        $query = "SELECT * FROM posts WHERE post_id = $post_id";
        $result = mysqli_query($connection, $query); 
        if(!$result) die(mysqli_error($connection));
        $row = mysqli_fetch_assoc($result);
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_author = $row['post_author'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $page_1 = $row['page_1'];
        $page_2 = $row['page_2']; 
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" value="<?php echo $post_title; ?>" class="form-control" name="post_title">
    </div>
    <div class="form-group">
        <select name="post_category_id">   
            <?php
                $query = "SELECT * FROM categories";
                $result = mysqli_query($connection, $query);
                if (!$result) die(mysqli_error($connection));
                while ($row = mysqli_fetch_assoc($result)) {
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];
                    echo "<option value='$cat_id'>$cat_title</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input type="text" value="<?php echo $post_author; ?>" class="form-control" name="post_author">
    </div>    
    <div class="form-group">
        <select name="post_status">
            <?php echo "<option value='$post_status'>$post_status</option>"; ?>
            <?php
                if ($post_status == 'draft') echo "<option value='published'>publish</option>";
                else echo "<option value='draft'>draft</option>";
            ?>
        </select>
    </div>    
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <img src="../images/<?php echo $post_image; ?>" width="100" name="post_image" alt="image">
        <input type="file" name="image">
    </div>    
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" value="<?php echo $post_tags; ?>" class="form-control" name="post_tags">
    </div>   
    <div class="form-group">
        <label for="page_1">Post Content - Page 1</label>
        <textarea type="text" class="form-control" name="page_1" cols="30" rows="10"><?php echo $page_1; ?></textarea>
        <label for="page_2">Post Content - Page 2</label>
        <textarea type="text" class="form-control" name="page_2" cols="30" rows="10"><?php echo $page_2; ?></textarea>
    </div>   
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Edit Post" name="btn_edit_post">
    </div>
</form>

<?php } ?>
<?php 
    if (isset($_POST['btn_edit_post'])) {
        $post_id = $_GET['p_id'];
        $post_title = $_POST['post_title'];
        $post_category_id = $_POST['post_category_id'];
        $post_author = $_POST['post_author'];
        $post_status = $_POST['post_status'];
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        $post_tags = $_POST['post_tags'];
        $page_1 = mysqli_real_escape_string($connection, $_POST['page_1']);
        $page_2 = mysqli_real_escape_string($connection, $_POST['page_2']);
        
        move_uploaded_file($post_image_temp, "../images/$post_image");
        if (empty($post_image)) {
            $query = "SELECT post_image FROM posts WHERE post_id = $post_id";
            $result = mysqli_query($connection, $query); 
            if(!$result) die(mysqli_error($connection));
            else {
                $row = mysqli_fetch_assoc($result);
                $post_image = $row['post_image'];
            }
        }
        
        $query = "UPDATE posts SET ";
        $query .= "post_title = '$post_title', ";
        $query .= "post_category_id = $post_category_id, ";
        $query .= "post_date = now(), ";
        $query .= "post_author = '$post_author', ";
        $query .= "post_status = '$post_status', ";
        $query .= "post_tags = '$post_tags', ";
        $query .= "page_1 = '$page_1', ";
        $query .= "page_2 = '$page_2', ";
        $query .= "post_image = '$post_image' ";
        $query .= "WHERE post_id=$post_id";
        
        $result = mysqli_query($connection, $query); 
        if(!$result) die(mysqli_error($connection));
        else  echo "<p class='bg-success'>Post Edited Successfully</p>";
    }     
?>