<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Description</h3><br>
                    <?php
                        // connection with mysql database
                        include('./includes/connection.php');
                        if (isset($_GET['invoice'])) {
                        	$invoice = $_GET['invoice'];
                        }  
                        echo '<table width="200" align="center">
                                <colgroup>
                                    <col width="50%">
                                    <col width="50%">
                                </colgroup>';
                    	echo ' <tr>
                            <td><b>Invoice # : </b></td>
                            	<td>'."7C".$_GET['invoice'].'</td>
                    		</tr>
                            <tr>
                                <td><b>Apartment : </b></td>
                                <td>'.$_GET['apt'].'</td>
                            </tr>
                            <tr>
                                <td><b>Unit # : </b></td>
                                <td>'.$_GET['unit'].'</td>
                            </tr>
                            <td><b>Size : </b></td>
                            	<td>'.$_GET['size'].'</td>
                    		</tr>
                        </table>
                        <table border="3" width="100%">
							<colgroup>
								<col width="5%">
                                <col width="10%">
                                <col width="10%">
                                <col width="75%">

                            </colgroup>
                            <thead>
                                <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    <td align="center"><b>#</b></td>
                                    <td align="center"><b>Quantity</b></td>
                                    <td align="center"><b>Price</b></td>
                                    <td align="center"><b>Description</b></td>
                                </tr>
                            </thead>
	                        ';
                        
                        $sql = "SELECT * FROM worksheet_description WHERE invoice='$invoice'";
                        
                        $result = mysqli_query($conn, $sql);
                        $isOdd = false;
                        $i = 0;
                        while($row = mysqli_fetch_array($result))
                        {	
                        	$i++;
                        	$quantity = $row['quantity'];
                            echo '<tbody>';
                            if ($isOdd) {
                                $isOdd = false;
                                echo '<tr bgcolor="#e8fff1">';
                            } else {
                                $isOdd = true;
                                echo '<tr>';
                            }
                            if ($quantity == 0) {
                            	$quantity = '';
                            }
                        	echo '<td align="center">'.$i.'</td>
                                        <td align="center">'.$quantity.'</td>
                                        <td align="center">'.$row['price'].'</td>
                                        <td align="center">'.$row['description'].'</td>
                                    </tr>
                                </tbody>
                            ';
	
                        }
                        echo '</table>';
                    ?>
                <br>
                <?php if (isset($_GET['from_company'])): ?>
                    <input type="button" value="Back" onclick="location.href='worksheet_company.php'"></input>
                <?php elseif (isset($_GET['from_apt'])): ?>
                	<input type="button" value="Back" onclick="location.href='worksheet_apt.php'"></input>
                <?php elseif (isset($_GET['from_manager'])): ?>
                    <input type="button" value="Back" onclick="location.href='worksheet_manager.php'"></input>
                <?php else: ?>
                    <input type="button" value="Back" onclick="location.href='worksheet.php'"></input>
                <?php endif; ?>

        </div>
        <br><br><br><br><br>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>