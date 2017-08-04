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
            <h3 class="text-center">Make Estimate</h3>

            <form name="info" action="#">
                <table id="main_data" border="3" width="50%">
                    <colgroup>
                        <col width="40%">
                        <col width="20%">
                        <col width="30%">
                        <col width="10%">
                    </colgroup>
                  <thead id="HeadRow">
                        <tr style="border: 2px double black;" align="center" bgcolor="#c9c9c9">
                            <th>Company</th>
                            <th>Apt</th>
                            <th>Unit #</th>
                            <th>Size</th>
                            <th>Date</th>
                        </tr>
                  </thead>
                  <tbody>
                        <tr align="center">
                            <td tableHeadData="Company"><input class="textInput" type="text" name="company" id="company" value="" size="20"></td>
                            <td tableHeadData="Apt"><input class="textInput" type="text" name="apt" id="apt" value="" size="20"></td>
                            <td tableHeadData="Unit #"><input class="textInput" type="text" name="unit" id="unit" value="" size="10"></td>
                            <td tableHeadData="Size"><input class="textInput" type="text" name="size" id="size" value="" size="10"></td>
                            <td tableHeadData="Date"><input class="textInput" type="date" name="date" id="theDate" value="" size="8"></td>
                        </tr>
                  </tbody>
                </table>
                <br>
                <table id="data_table" border="3" width="100%">
                    <colgroup>
                        <col width="70%">
                        <col width="7%">
                        <col width="7%">
                        <col width="16%">
                    </colgroup>
                    <thead id="HeadRow">
                        <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                            <th>Description</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody id="pdf_table">
                        <tr>
                            <td tableHeadData="Description"><input class="textInput" type="text" name="description" id="new_description"></td>
                            <td tableHeadData="Qty"><input class="textInput" type="text" name="qty" id="new_quantity"></td>
                            <td tableHeadData="Price"><input class="textInput" type="text" name="price" id="new_price"></td>
                            <td colspan="2" align="center"><input type="button" class="add" onclick="add_row()" value="Add"></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <button type="button" name="submit" onclick="pass_data(5, 'create_estimate.php')" formtarget="_blank">Create PDF</button>
                <button type="button" onclick="location.href='worksheet.php'">Back</button>
            </form>

        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
