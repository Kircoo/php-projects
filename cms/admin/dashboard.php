<?php include "includes/admin_header.php" ?>
    <?php if(!is_admin()){
        redirect('index.php');
    } 
    ?>
        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">

                    <h3 class="page-header">
                        <small>Role: <?php echo $_SESSION['user_role']; ?></small>
                            Welcome
                            <?php echo strtoupper(getUsername()); ?>
                        </h3>



                <!-- /.row -->
                
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-file-text fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">

                                          <div class='huge'><?php echo $post_counts = recordCount('posts'); ?></div>
                                                <div>Posts</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="posts.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-green">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-comments fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">

                                             <div class='huge'><?php echo $comments_counts = recordCount('comments'); ?></div>
                                              <div>Comments</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="comments.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-yellow">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-user fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">

                                            <div class='huge'><?php echo $users_counts = recordCount('users'); ?></div>
                                                <div> Users</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="users.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-red">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-list fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">

                                                <div class='huge'><?php echo $categories_counts = recordCount('categories'); ?></div>
                                                 <div>Categories</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="categories.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                <!-- /.row -->


                <?php

                $draft_counts = checkStatus('posts', 'post_status', 'draft');

                $published_counts = checkStatus('posts', 'post_status', 'published');

                $unapproved_counts = checkStatus('comments', 'comment_status', 'unapproved');

                $subscriber_counts = checkRole('users', 'user_role', 'subscriber');

                $admin_counts = checkRole('users', 'user_role', 'admin');

                ?>



                <div class="row">

                    <script type="text/javascript">
                          google.charts.load('current', {'packages':['bar']});
                          google.charts.setOnLoadCallback(drawChart);

                          function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                              ['DATA', 'Count'],


                              <?php

                              $elemets_text = ['All posts', 'Published posts','Draft posts', 'Comments', 'Pending Comments', 'Users', 'Admin', 'Subscriber', 'Categories'];
                              $elemets_count = [$post_counts, $published_counts,$draft_counts, $comments_counts, $unapproved_counts, $users_counts, $admin_counts, $subscriber_counts, $categories_counts];

                              for ($i = 0; $i < 9; $i++) {

                                echo "['{$elemets_text[$i]}'" . ", " . "{$elemets_count[$i]}],";

                              }

                              ?>
     
                            ]);

                            var options = {
                              chart: {
                                title: 'Status for:',
                                subtitle: 'Posts, comments, users, categories',
                              }
                            };

                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                          }
                    </script>
                    <div id="columnchart_material" style="width: auto; height: 500px;"></div>

                </div>



                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>


        <!-- /#page-wrapper -->


<?php include "includes/admin_footer.php" ?>

<link rel="stylesheet" type="text/css" href="css/toastr.css">
<script src="js/toastr.min.js"></script>
<script src="https://js.pusher.com/4.4/pusher.min.js"></script>


<script type="text/javascript">
    


    Pusher.logToConsole = true;

    var pusher = new Pusher('e7af85f942ea277321f3', {

        cluster: 'eu',
        encrypted: false
    });

    var notificationChannel = pusher.subscribe('notifications');

    notificationChannel.bind('new_user', function(notification){

        var message = notification.message;

        toastr.success(`${message} just registered`);

    });



</script>