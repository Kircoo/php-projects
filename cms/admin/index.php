<?php include "includes/admin_header.php" ?>

<?php if(is_admin()){
        redirect('../index.php');
    } 
    ?>

   <?php 
   
        $post_counts = countRows(get_users_posts());
   
         $comments_counts = countRows(get_user_post_comments());

         $draft_counts = countRows(all_user_draft_posts());

         $published_counts = countRows(all_user_published_posts());

         $unapproved_counts = countRows(all_user_comments_unnaproved());

         $approved_counts = countRows(all_user_comments_aproved());
   
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
                            <div class="col-lg-6 col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-file-text fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">

                                          <div class='huge'><?php echo $post_counts; ?></div>
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
                            <div class="col-lg-6 col-md-6">
                                <div class="panel panel-green">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-comments fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">

                                             <div class='huge'><?php echo $comments_counts ?></div>
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

                        </div>
                <!-- /.row -->

                <div class="row">

                    <script type="text/javascript">
                          google.charts.load('current', {'packages':['bar']});
                          google.charts.setOnLoadCallback(drawChart);

                          function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                              ['DATA', 'Count'],


                              <?php

                              $elemets_text = ['All posts', 'Published posts','Draft posts', 'Comments', 'Approved Comments', 'Pending Comments'];
                              $elemets_count = [$post_counts, $published_counts,$draft_counts, $comments_counts, $approved_counts, $unapproved_counts];

                              for ($i = 0; $i < 6; $i++) {

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