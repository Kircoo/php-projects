<?php include "includes/admin_header.php" ?>

<?php

if (!is_admin($_SESSION['username'])) {
    
    header('Location: index.php');
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

                <?php

                if (isset($_GET['source'])) {
                    
                    $source = escape($_GET['source']);
                } else {

                    $source = '';
                }

                switch ($source) {
                    case 'add_user':
                        include 'includes/add_user.php';
                        break;

                    case 'edit_user':
                        include 'includes/edit_user.php';
                        break;

                    case 'value':
                        # code...
                        break;
                    
                    default:
                        include "includes/view_all_users.php";
                        break;
                }

                ?>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>

<!-- /#page-wrapper -->

<?php include "includes/admin_footer.php" ?>