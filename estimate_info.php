<?php 
	session_start(); 
	date_default_timezone_set('Etc/UTC');
?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Make Estimate</h3><br>

            <?php
                // connection with mysql database
                include('./includes/connection.php');
                if (isset($_GET['desc_edited_estm'])) {
                    $_SESSION['estm_arr'][$_GET['index_edited_estm']][0] = $_GET['desc_edited_estm'];
                }
                if (isset($_GET['qty_edited_estm'])) {
                    $_SESSION['estm_arr'][$_GET['index_edited_estm']][1] = $_GET['qty_edited_estm'];
                }
                if (isset($_GET['price_edited_estm'])) {
                    $_SESSION['estm_arr'][$_GET['index_edited_estm']][2] = $_GET['price_edited_estm'];
                }
                if ($_POST['description'] !== null) {
                    $_SESSION['estm_arr'][$_SESSION['i_estm']][0] = $_POST['description'];
                }
                if ($_POST['price'] !== null) {
                    $_SESSION['estm_arr'][$_SESSION['i_estm']][1] = $_POST['qty'];
                }
                if ($_POST['qty'] !== null) {
                    $_SESSION['estm_arr'][$_SESSION['i_estm']][2] = $_POST['price'];
                }

                if (isset($_POST['submit'])) {
                    $_SESSION['i_estm']++;
                }

                echo '
                    
                    <form action="estimate_info.php" method="post">
                        <table border="2" width="100%">
                            <colgroup>
                                <col width="70%">
                                <col width="10%">
                                <col width="10%">
                                <col width="5%">
                                <col width="5%">
                            </colgroup>
                            <thead>
                                <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    <td align="center"><b>Description</b></td>
                                    <td align="center"><b>Qty</b></td>
                                    <td align="center"><b>Price</b></td>
                                    <td colspan="2"></td>
                                </tr>
                            </thead>
                            <tbody id="pdf_table">
                                <tr>
                                    <td><input style="border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;" type="text" name="description" size="10" required></td>
                                    <td><input style="border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;" type="text" name="qty" size="10"></td>
                                    <td><input style="border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;" type="text" name="price" size="10"></td>
                                    <td colspan="2" align="center"><input type="submit" name="submit" value="Add"></td>
                                </tr>
                ';
                for ($i = 0; $i < sizeof($_SESSION['estm_arr']); $i++) {
                    if ($_SESSION['estm_arr'][$i][0] !== null) {
                        echo '<tr bgcolor="#c4daff"><td>'.$_SESSION['estm_arr'][$i][0].'</td>';
                    }
                    if ($_SESSION['estm_arr'][$i][1] !== null) {
                        echo '<td>'.$_SESSION['estm_arr'][$i][1].'</td>';
                    }

                    if ($_SESSION['estm_arr'][$i][2] !== null) {
                        echo '<td>'.$_SESSION['estm_arr'][$i][2].'</td>';
                    }
                    if ($_SESSION['estm_arr'][$i][0] !== null) {
                        echo '<td align="center"><button><a href="edit_estimate_detail.php?description='.$_SESSION['estm_arr'][$i][0].' &qty='.$_SESSION['estm_arr'][$i][1].' &price='.$_SESSION['estm_arr'][$i][2].' &index='.$i.'">Edit</a></button></td>';
                    }
                    if ($_SESSION['estm_arr'][$i][0] !== null) {
                        echo '<td align="center"><button><a href="edit_estimate_detail.php?index_deleted='.$i.'">Delete</a></button></td></tr>';
                    }
                }

                echo '
                            </tbody>
                        </table>
                        <br>
                    </form>
                    <form action="create_estimate.php" method="post">
                        <table border="2" width="50%">
                            <colgroup>
                                <col width="40%">
                                <col width="20%">
                                <col width="30%">
                                <col width="10%">
                            </colgroup>
                            <tr style="border: 2px double black;" align="center" bgcolor="#c9c9c9">
	                            <td><label><b>Company</b></label></td>
                                <td><label><b>Apartment</b></label></td>
	                            <td><label><b>Unit</b></label></td>
	                            <td><label><b>Size</b></label></td>
                                <td><label><b>Date</b></label></td>
                            </tr>
                            <tr align="center">
                                <td><input style="border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;" type="text" name="company" value="" size="20"></td>
                                <td><input style="border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;" type="text" name="apt" value="" size="20"></td>
                                <td><input style="border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;" type="text" name="unit" value="" size="10"></td>
                                <td><input style="border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;" type="text" name="size" value="" size="10"></td>
                                <td><input style="border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;" type="date" name="date" id="theDate" value="" size="8"></td>
                            </tr>
                        </table>
                ';
            ?>
            <br>
            <input type="submit" value="Create PDF"></input>
            <input type="button" value="Back" onclick="location.href='worksheet.php'"></input>
            </form>

        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
