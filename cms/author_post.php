<?php session_start(); ?>
<?php ob_start(); ?>
<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

    <!-- Navigation -->
    <?php include 'includes/navigation.php'; ?>

    <!-- Page Content -->
    <div class="container">

        <?php

                if (isset($_GET['p_id'])) {
                    
                $the_post_id     = escape($_GET['p_id']);
                $the_post_author = escape($_GET['author']);
                }

                $query = "SELECT * FROM posts WHERE post_author = '{$the_post_author}' ";
                $select_all_posts_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_array($select_all_posts_query)) {
                
                $post_id = $row['post_id'];
                $post_author = $row['post_author'];

                }

        ?>

        <h1>All post by <?php echo $post_author; ?></h1>

        <div class="row">

            <!-- Blog Entries Column -->

            <div class="col-md-8">

                <?php

                if (isset($_GET['p_id'])) {
                    
                    $the_post_id     = escape($_GET['p_id']);
                    $the_post_author = escape($_GET['author']);
                }

                $query = "SELECT * FROM posts WHERE post_author = '{$the_post_author}' ";
                $select_all_posts_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_array($select_all_posts_query)) {
                    
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_content = $row['post_content'];
                    $post_image = $row['post_image'];

                    ?>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>

                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id; ?>">
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                </a>
                <hr>
                <p><?php echo $post_content; ?></p>

                <hr>


                   <?php } ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php' ?>

        </div>
        <!-- /.row -->

        <hr>
</div>

<?php include "includes/footer.php" ?>