<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title">
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
        <input type="text" class="form-control" name="post_author">
    </div>
    <div class="form-group">
        <select name="post_status">   
            <option>Select an Option</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content_excerpt">Post Content Excerpt</label>
        <textarea type="text" class="form-control" name="post_content_excerpt" cols="30" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="page_1">Post Content - Page 1</label>
        <textarea type="text" class="form-control" name="page_1" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <label for="page_2">Post Content - Page 2</label>
        <textarea type="text" class="form-control" name="page_2" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Add Post" name="btn_add_post">
    </div>
</form>
<?php
    if (isset($_POST['btn_add_post'])) {
        $post_title = $_POST['post_title'];
        $post_category_id = $_POST['post_category_id'];
        $post_author = $_POST['post_author'];
        $post_status = $_POST['post_status'];
        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];
        $post_tags = $_POST['post_tags'];
        $post_content_excerpt = mysqli_real_escape_string($connection, $_POST['post_content_excerpt']);
        $page_1 = mysqli_real_escape_string($connection, $_POST['page_1']);
        $page_2 = mysqli_real_escape_string($connection, $_POST['page_2']);
        move_uploaded_file($post_image_temp, "../images/$post_image");
        
        $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content_excerpt, page_1, page_2, post_tags, post_status) ";
        $query .= "VALUES($post_category_id,'$post_title','$post_author',now(),'$post_image','$post_content_excerpt','$page_1','$page_2','$post_tags','$post_status')";
        $result = mysqli_query($connection, $query); 
        if(!$result) die(mysqli_error($connection));
        else {
            $created_post_id = mysqli_insert_id($connection);
            echo "<p class='bg-success'>Post Is Added Successfully</p>";
        }
    }
?>