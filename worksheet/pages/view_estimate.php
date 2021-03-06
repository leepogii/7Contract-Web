<?php
    session_start();
    unset($_SESSION['edit_arr']);
    $_SESSION['i'] = 0;
?>
<!DOCTYPE html>
<html lang="en">

    <?php include('./includes/head_tag.html'); ?>

    <body>
        <div id="wrapper">
            <?php include("./includes/nav_bar.php"); ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">View Estimate</h1>
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
                                <?php
                                    // connection with mysql database
                                    include('./includes/connection.php');

                                    $sql = "SELECT * FROM estimate";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_array($result);

                                    echo '
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <colgroup>
                                                <col width="5%">
                                                <col width="10%">
                                                <col width="10%">
                                                <col width="7%">
                                                <col width="5%">
                                                <col width="5%">
                                                <col width="10%">
                                                <col width="38%">
                                                <col width="10%">
                                                <col width="0%">
                                            </colgroup>
                                            <thead>
                                                <tr align="center">
                                                    <td><b>ID</b></td>
                                                    <td><b>Company</b></td>
                                                    <td><b>Apt</b></td>
                                                    <td><b>P.O</b></td>
                                                    <td><b>Unit</b></td>
                                                    <td><b>Size</b></td>
                                                    <td><b>Price</b></td>
                                                    <td><b>Description</b></td>
                                                    <td><b>Date</b></td>
                                                    <td style="display: none"></td>
                                    ';
                                    if ($_SESSION['isadmin'] == 2) echo '<td></td>';
                                    echo '</tr></thead><tbody>';
                                    
                                    $sql = "SELECT * FROM estimate";

                                    $result = mysqli_query($conn, $sql);
                                    $isOdd = false;
                                    while($row = mysqli_fetch_array($result)) {
                                        $price = str_replace(".00", "", $row['price']);

                                        if ($isOdd) {
                                            $isOdd = false;
                                            echo '<tr class="odd gradeX" align="center">';
                                        } else {
                                            $isOdd = true;
                                            echo '<tr class="even gradeX" align="center">';
                                        }

                                        echo '
                                            <td>'.$row['id'].'</td>
                                            <td><a href="estimate_company.php?company='.$row['company'].'">'.$row['company'].'</td>
                                            <td><a href="estimate_apt.php?apt='.$row['apt'].'&company='.$row['company'].'">'.$row['apt'].'</a></td>
                                            <td>'.$row['PO'].'</td>
                                            <td>'.$row['unit'].'</td>
                                            <td>'.$row['size'].'</td>
                                            <td>'.number_format($price, 2).'</td>
                                            <td align="left"><div class="lineBreak"><a href="estimate_description.php?id='.$row['id'].'&company='.$row['company'].'&apt='.$row['apt'].'&unit='.$row['unit'].'&size='.$row['size'].'&po='.$row['PO'].'">'.$row['description'].'</a></div></td>
                                            <td>'.substr($row['date'], 0, 10).'</td>
                                        ';
                                        if ($_SESSION['isadmin'] == 2) {
                                            echo '
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                                        <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a onclick="location.href=\'toWorksheet.php?id='.$row['id'].'&company='.$row['company'].'&apt='.$row['apt'].'&unit='.$row['unit'].'&size='.$row['size'].'&price='.$price.'&description='.$row['description'].'&po='.$row['PO'].'\'">Convert</a></li>
                                                            <li><a onclick="location.href=\'estimate_edit.php?id='.$row['id'].'\'">Edit</a></li>
                                                            <li><a onclick="deleteBtn('.$row['id'].')">Remove</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            ';
                                        }
                                        echo '
                                                <td style="display: none">'.$row['sort'].'</td>
                                            </tr>
                                        ';
                                    }
                                    echo '</tbody></table>';
                                    mysqli_close($conn);
                                ?>
                                
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

        <?php include('./includes/functions.js'); ?>
    </body>
</html>
