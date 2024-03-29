                    
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
                    <?php

                    include "delete_modal.php";

                    if (isset($_POST['checkBoxArray'])) {
                        
                        foreach ($_POST['checkBoxArray'] as $checkBoxesValue) {
                            
                           $bulk_options = $_POST['bulk_options'];

                           switch ($bulk_options) {
                               case 'published':
                                   
                                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$checkBoxesValue}' ";
                                    $bulk_options_publish = mysqli_query($connection, $query);

                                   break;

                                case 'draft':

                                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$checkBoxesValue}' ";
                                    $bulk_options_draft = mysqli_query($connection, $query);

                                   break;

                                case 'delete':

                                    $query = "DELETE FROM posts WHERE post_id = '{$checkBoxesValue}' ";
                                    $bulk_options_delete = mysqli_query($connection, $query);

                                   break;

                                   case 'clone':

                                   $query = "SELECT * FROM posts WHERE post_id = '{$checkBoxesValue}' ";
                                   $select_options_clone = mysqli_query($connection, $query);

                                   while ($row = mysqli_fetch_array($select_options_clone)) {
                                       $post_title = $row['post_title'];
                                       $user_id = $row['user_id'];
                                       $post_category_id = $row['post_category_id'];
                                       $post_date = $row['post_date'];
                                       $post_author = $row['post_author'];
                                       $post_status = $row['post_status'];
                                       $post_image = $row['post_image'];
                                       $post_tags = $row['post_tags'];
                                       $post_content = mysqli_real_escape_string($connection, $row['post_content']);
                                       $post_comment_count = $row['post_comment_count'];

                                       if (empty($post_tags)) {
                                           
                                            $post_tags = 'No tags';
                                       }

                                   }

                                   $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status, post_views_counts, likes, user_id) ";
                                   $query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', 0, '{$post_status}', 0, 0, '{$user_id}')";
                                   $copy_query = mysqli_query($connection, $query);
                                   if (!$copy_query) {
                                       die('QUERY FAILED' . mysqli_error($connection));
                                   }

                                   break;
                               
                               default:
                                   # code...
                                   break;
                           }


                        }

                    }

                    ?>


                    <form method="post" action="">
                        <table class="table table-bordered">


                            <div id="bulkOptionContainer" class="col-xs-4" style="margin-bottom: 5px">
                                

                                <select class="form-control" name="bulk_options" id="">
                                    
                                    <option value="">Select Option</option>
                                    <option value="published">Publish</option>
                                    <option value="draft">Draft</option>
                                    <option value="delete">Delete</option>
                                    <option value="clone">Clone</option>

                                </select>

                            </div>

                            <div class="col-xs-4">
                                
                                <input type="submit" name="submit" class="btn btn-success" value="Apply">
                                <a class="btn btn-primary" href="posts.php?source=add_post">Add new</a>

                            </div>



                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAllBoxes"></th>
                                    <th>Id</th>
                                    <th>User</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Tags</th>
                                    <th>Comments</th>
                                    <th>Date</th>
                                    <th>Post views</th>
                                    <th>View post</th>
                                    <th>Update</th>
                                    <th>Delete</th>

                                </tr>
                            </thead>
                            <tbody>

                        <?php
                        if(is_admin()) {
                            $select_post_query = showAllPostsAdmin();
                        } else {
                        $select_post_query = showAllPosts();

                        }

                        while ($row = mysqli_fetch_array($select_post_query)) {
                            
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_category_id = $row['post_category_id'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];
                            $post_tags = $row['post_tags'];
                            $post_comment_count = $row['post_comment_count'];
                            $post_status = $row['post_status'];
                            $post_views_counts = $row['post_views_counts'];
                            $category_title = $row['cat_title'];
                            $category_id = $row['cat_id'];

                            echo "<tr>";

                            ?> 

                            <td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='<?php echo $post_id ?>'></td>

                            <?php

                            echo "<td>{$post_id}</td>";
                            echo "<td>{$post_author}</td>";
                            echo "<td>{$post_title}</td>";
                            echo "<td>{$category_title}</td>";
                            echo "<td>{$post_status}</td>";
                            echo "<td><img width='50' src='../images/$post_image'></td>";
                            echo "<td>{$post_tags}</td>";


                            $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                            $send_comment_query = mysqli_query($connection, $query);

                            $row = mysqli_fetch_array($send_comment_query);
                            $comment_id = $row['comment_id'];
                            $count_comments = mysqli_num_rows($send_comment_query);



                            echo "<td><a href='post_comments.php?id=$post_id'>{$count_comments}</a></td>";
                            echo "<td>{$post_date}</td>";
                            echo "<td><a href='posts.php?reset={$post_id}'>{$post_views_counts}</a></td>";
                            echo "<td><a class='btn btn-success' href='../post.php?p_id=$post_id'>View post</a></td>";
                            echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Update</a></td>";



                            ?>


                            <form method="post">
                            
                            <input type="hidden" name="post_id" value="<?php echo $post_id ?>">

                            <?php
                            echo "<td><input onClick=\"javascript: return confirm('Are you sure you want to delete this post?'); \" class='btn btn-danger' type='submit' value='Delete' name='delete'></td>";
                            ?>
                            </form>


                            <?php

                            // echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
                            // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this post?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";

                            echo "</tr>";
                        }

                        ?>

                            </tbody>
                        </table>
                    </form>


                        <?php


                        if (isset($_POST['delete'])) {

                                $the_post_id = escape($_POST['post_id']);

                                $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
                                $delete_query = mysqli_query($connection, $query);
                                header('location: posts.php');
                                    
                        }

                        if (isset($_GET['reset'])) {
                          
                          $the_reset_id = escape($_GET['reset']);

                          $the_reset_id = mysqli_real_escape_string($connection, $_GET['reset']);

                          $query = "UPDATE posts SET post_views_counts = 0 WHERE post_id = {$the_reset_id}";
                          $reset_query = mysqli_query($connection, $query);
                          header('location: posts.php');

                        }


                        ?>

                        <script type="text/javascript">
                          
                          $(document).ready(function(){

                            $('.delete_link').on('click', function(){

                              var id = $(this).attr('rel');

                              var delete_url = "posts.php?delete="+ id +" ";

                              $(".modal_delete_link").attr("href", delete_url);

                              $("#myModal").modal('show');

                            });

                          });

                        </script>