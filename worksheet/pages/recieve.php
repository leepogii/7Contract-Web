<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

    <?php 
        include('./includes/head_tag.html'); 

        include('./includes/connection.php');
        unset($_SESSION['invoice']);
        unset($_SESSION['unit']);
        unset($_SESSION['price']);
        unset($_SESSION['apt']);
        unset($_SESSION['paid']);
        if (isset($_GET['invoice'])) {
            $_SESSION['invoice'] = str_replace('7C', '', $_GET['invoice']);
            $_SESSION['unit'] = $_GET['unit'];
            $_SESSION['apt'] = $_GET['apt'];
            $_SESSION['price'] = $_GET['price'];
            $_SESSION['paid'] = $_GET['paid'];
        } else {
             echo '<script>alert("Something is not valid.");</script>';
             echo '<script>window.location.href="worksheet.php";</script>';
             exit();
        }
        $sql = "SELECT * FROM worksheet WHERE invoice=".$_SESSION['invoice'].";";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $_SESSION['remaining'] = $_SESSION['price'] - $row['paid'];
            }
        }
    ?>

    <body>
        <div id="wrapper">
            <?php include("./includes/nav_bar.php"); ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Receive</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                DataTables Advanced Tables
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <form action="recieve_process.php" method="POST">
                                    <table width="100%" class="table table-striped table-bordered table-hover">
                                        <colgroup>
                                            <col width="20%">
                                            <col width="80%">
                                        </colgroup>
                                        <tr>
                                            <td align="right"><b><h5>Invoice</h5></b></td>
                                            <td align="left"><h5 style="font-weight: normal"><?php echo isset($_SESSION['invoice']) ? "7C".$_SESSION['invoice'] : '-' ?></h5></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>Apt</h5></b></td>
                                            <td align="left"><h5 style="font-weight: normal"><?php echo isset($_SESSION['apt']) ? $_SESSION['apt'] : '-' ?></h5></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>Unit</h5></b></td>
                                            <td align="left"><h5 style="font-weight: normal"><?php echo isset($_SESSION['unit']) ? $_SESSION['unit'] : '-' ?></h5></td>
                                        </tr>
                                            <td align="right"><b><h5>Price</h5></b></td>
                                            <td align="left"><h5 style="font-weight: normal"><?php echo isset($_SESSION['price']) ? "$ ".$_SESSION['price']  : '-' ?></h5></td>
                                        </tr>
                                        </tr>
                                            <td align="right"><b><h5>Remaining Balance</h5></b></td>
                                            <td align="left"><h5 style="font-weight: normal"><?php echo isset($_SESSION['remaining']) ? "$ ".number_format((float)$_SESSION['remaining'], 2, '.', '') : '-' ?></h5></td>
                                        </tr>
                                        </tr>
                                            <td align="right"><b><h5>Recieved Amount</h5></b></td>
                                            <td align="left"><input class="form-control" type="text" name="recieve"></td>
                                        </tr>
                                    </table>
                                    <div class="row">
                                        <div class="col-sm-offset-5 col-sm-2 text-center">
                                            <div class="text-center btn-group">
                                                <button class="btn btn-primary" type="submit">Recieved</button>
                                                <button class="btn btn-primary" type="button" onclick="location.href='price_detail.php'">Back</button>
                                            </div>  
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="../vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../dist/js/sb-admin-2.js"></script>

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>
    </body>
</html>

