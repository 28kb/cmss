    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php?page=1">Home</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php   displayCategories();  ?>
                    <?php 
                        if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'subscriber')) {
                            echo "<li><a href='admin'><strong>Admin</strong></a></li>";
                        }
                        if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 'admin')) {
                            if (isset($_GET['p_id'])) {
                                $post_id = $_GET['p_id'];
                                echo "<li><a href='admin/posts.php?source=edit_post&p_id=$post_id'>Edit Post</a></li>";
                            }
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>