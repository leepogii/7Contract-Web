<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <?php
            // connection with mysql database
            include('./includes/connection.php');

            // This is for values from deleting in estimate_info.php
            if (isset($_GET['index_deleted'])) {
                echo '<script>window.location.href="edit_admin.php";</script>';
                array_splice($_SESSION['arr'], $_GET['index_deleted'], 1);
                $_SESSION['i']--;
                exit();
            }

            // This is for values passed from editing in estimate_info.php
            if (isset($_GET['description'])) {
                $description = $_GET['description'];
            }
            if (isset($_GET['qty'])) {
                $qty = $_GET['qty'];
            }
            if (isset($_GET['price'])) {
                $price = $_GET['price'];
            }
            if (isset($_GET['index'])) {
                $index = $_GET['index'];
            }
        ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Edit Invoice Information</h3>

            <form action="edit_admin.php" method="GET">

                <table width="30%">
                    <colgroup>
                        <col width="20%">
                        <col width="5%">
                        <col width="75%">
                    </colgroup>
                    <tr>
                        <td align="right"><b>Description</b></td>
                        <td></td>
                        <td><input class="editInput" type="text" name="desc_edited_estm" value="<?php echo isset($description) ? rtrim($description," ") : '' ?>"></td>
                    </tr>
                    <tr>
                        <td align="right"><b>Qty</b></td>
                        <td></td>
                        <td><input class="editInput type="text" name="qty_edited_estm" value="<?php echo isset($qty) ? rtrim($qty," ") : '' ?>"></td>
                    </tr>
                    <tr>
                        <td align="right"><b>Price</b></td>
                        <td></td>
                        <td><input class="editInput type="text" name="price_edited_estm" value="<?php echo isset($price) ? rtrim($price," ") : '' ?>"></td>
                    </tr>
                    <tr hidden>
                        <td><b>Index</b></td>
                        <td><input type="text" name="index_edited_estm" value="<?php echo $index ?>"></td>
                    </tr>
                </table>
                <br>
                <button type="submit">Edit</button>
                <button type="button" onclick="location.href='edit_admin.php'">Back</button>
            </form>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.js'); ?>
    </body>
</html>
