<?php session_start(); ?>
<?php ob_start(); ?>
<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>

 <?php

 if(isset($_POST['liked'])) {

     $post_id = $_POST['post_id'];
     $user_id = $_POST['user_id'];

      //1 =  FETCHING THE RIGHT POST

     $query = "SELECT * FROM posts WHERE post_id=$post_id";
     $postResult = mysqli_query($connection, $query);
     $post = mysqli_fetch_array($postResult);
     $likes = $post['likes'];

     // 2 = UPDATE - INCREMENTING WITH LIKES

     mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE post_id=$post_id");

     // 3 = CREATE LIKES FOR POST

     mysqli_query($connection, "INSERT INTO Likes(user_id, post_id) VALUES($user_id, $post_id)");
     exit();


 }


 if(isset($_POST['unliked'])) {


     $post_id = $_POST['post_id'];
     $user_id = $_POST['user_id'];

     //1 =  FETCHING THE RIGHT POST

     $query = "SELECT * FROM posts WHERE post_id=$post_id";
     $postResult = mysqli_query($connection, $query);
     $post = mysqli_fetch_array($postResult);
     $likes = $post['likes'];

     //2 = DELETE LIKES

     mysqli_query($connection, "DELETE FROM Likes WHERE post_id=$post_id AND user_id=$user_id");

     //3 = UPDATE WITH DECREMENTING WITH LIKES

     mysqli_query($connection, "UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");

     exit();

 }

 ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            
            <div class="col-md-8">
               
               <?php

    if(isset($_GET['p_id'])){
    
       $the_post_id = $_GET['p_id'];

        $update_statement = mysqli_prepare($connection, "UPDATE posts SET post_views_counts = post_views_counts + 1 WHERE post_id = ?");

        mysqli_stmt_bind_param($update_statement, "i", $the_post_id);

        mysqli_stmt_execute($update_statement);

        // mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);

     if(!$update_statement) {

        die("query failed" );
    }

    if(isset($_SESSION['username']) && is_admin($_SESSION['username']) ) {

         $stmt1 = mysqli_prepare($connection, "SELECT post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_id = ?");

    } else {
        $stmt2 = mysqli_prepare($connection , "SELECT post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_id = ? AND post_status = ? ");

        $published = 'published';

    }


    if(isset($stmt1)){

        mysqli_stmt_bind_param($stmt1, "i", $the_post_id);

        mysqli_stmt_execute($stmt1);

        mysqli_stmt_bind_result($stmt1, $post_title, $post_author, $post_date, $post_image, $post_content);

      $stmt = $stmt1;

    }else {

        mysqli_stmt_bind_param($stmt2, "is", $the_post_id, $published);

        mysqli_stmt_execute($stmt2);

        mysqli_stmt_bind_result($stmt2, $post_title, $post_author, $post_date, $post_image, $post_content);

     $stmt = $stmt2;

    }

    while(mysqli_stmt_fetch($stmt)) {

        ?>

                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_post.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="/cms/images/<?php echo imagePlaceholder($post_image);?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>

                <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox"></div>

        <hr>

   <?php

        // FREEING RESULT

        mysqli_stmt_free_result($stmt);

        ?>

           <?php

                if(isLoggedIn()){ ?>

                    <div class="row">
                        <p data-toggle="tooltip"
                                data-placement="top"
                                title="<?php echo userLikePost($the_post_id) ? ' Liked' : 'Like this'; ?>" class=""><a
                                class="<?php echo userLikePost($the_post_id) ? 'unlike' : 'like'; ?>"
                                href=""><span class="glyphicon glyphicon-thumbs-up"
                                
                                ></span>
                                <?php echo userLikePost($the_post_id) ? ' Unlike' : ' Like'; ?>

                </a></p>
                    </div>

              <?php  } else { ?>

                    <div class="row">
                        <p class=" login-to-post">You need to <a href="/cms/login.php">Login</a> to like </p>
                    </div>

                <?php }

            ?>

                <div class="row">
                    <p class=" likes"><?php getPostlikes($the_post_id); ?> people likes this post.</p>
                </div>

                 <div class="clearfix"></div>

<?php }

?>

<!-- Blog Comments -->
<!-- POST COMMENT -->
<?php postComment(); ?> 

<!-- Posted Comments -->

        <!-- Comments Form -->
        <div class="well">

            <h4>Leave a Comment:</h4>

            <form action="#" method="post" role="form">

                <div class="form-group">

                    <label for="Author">Author</label>

                    <input type="text" name="comment_author" class="form-control" name="comment_author" value="<?php echo $_SESSION['username'] ?>">

                </div>

                <div class="form-group">

                    <label for="Author">Email</label>

                    <input type="email" name="comment_email" class="form-control" name="comment_email" value="<?php echo $_SESSION['email'] ?>">

                </div>

                <div class="form-group">

                    <label for="comment">Your Comment</label>

                    <textarea name="comment_content" class="form-control" rows="3"></textarea>

                </div>

                <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>

            </form>

        </div>

        <hr>
                
           <?php 


            $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
            $query .= "AND comment_status = 'approved' ";
            $query .= "ORDER BY comment_id DESC ";
            $select_comment_query = mysqli_query($connection, $query);
            if(!$select_comment_query) {

                die('Query Failed' . mysqli_error($connection));
             }

            while ($row = mysqli_fetch_array($select_comment_query)) {
            $comment_date   = $row['comment_date']; 
            $comment_content= $row['comment_content'];
            $comment_author = $row['comment_author'];
            $user_image_comment = $row['user_image'];
                
            ?>
                
            <div class="mb-5">

                <!-- Comment -->

                <div class="media">
                     
                    <a class="pull-left" href="">

                    <img class="profile-image" src='images/<?php echo imagePlaceholderUser($user_image_comment) ?>'>

                    </a>

                    <div class="media-body">

                        <h4 class="media-heading"><?php echo $comment_author;   ?>

                            <small><?php echo $comment_date;   ?></small>

                        </h4>
                        
                        <?php echo $comment_content;   ?>
 
                    </div>

                </div>

            </div>

           <?php } }    else {

            header("Location: index.php");

            }
                ?>
           
            </div>
            
            <!-- Blog Sidebar Widgets Column -->
            
            <?php include "includes/sidebar.php";?>
            
        </div>
        <!-- /.row -->

        <hr>

        </div>

<?php include "includes/footer.php";?>

        <script>
            $(document).ready(function(){

                  $("[data-toggle='tooltip']").tooltip();
                    var post_id = <?php echo $the_post_id; ?>;
                    var user_id = <?php echo loggedInUserId(); ?>;

                // LIKING

                $('.like').click(function(){
                    $.ajax({
                        url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                        type: 'post',
                        data: {
                            'liked': 1,
                            'post_id': post_id,
                            'user_id': user_id
                        }
                    });
                });

                // UNLIKING

                $('.unlike').click(function(){

                    $.ajax({

                        url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                        type: 'post',
                        data: {
                            'unliked': 1,
                            'post_id': post_id,
                            'user_id': user_id

                        }

                    });

                });

            });

        </script>




