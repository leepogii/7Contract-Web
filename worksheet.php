<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    $_SESSION['i_pdf'] = 0;
    $_SESSION['i_estm'] = 0;
    $_SESSION['i'] = 0;
    unset($_SESSION['unpaid']);
    unset($_SESSION['arr']);
    unset($_SESSION['estm_arr']);
    unset($_SESSION['edit_arr']);
	unset($_SESSION['pdf_arr']);
?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <!-- Body -->
        <div class="primary" align="center">

            <?php
				// connection with mysql database
                include('./includes/connection.php');

                if (!isset($_SESSION['email'])) {
                    echo "<script>alert(\"You need to sign in first.\");</script>";
                    echo '<script>window.location.href = "signin.php";</script>';
                    exit();
                } else {
                	echo '<h3 class="text-center">Worksheet</h3>';

                	include('./includes/data_range.html');

					if (isset($_SESSION['isadmin'])) {
						if ($_SESSION['isadmin'] > 0) {
							echo '
								<div align="center" id="btn_worksheet">
									<button onclick="location.href=\'view_estimate.php\'">View Estimate</button>
									<button onclick="location.href=\'estimate_info.php\'">Make Estimate</button>
									<button onclick="location.href=\'worksheet_add.php\'">Add Worksheet</button>
							';
							if ($_SESSION['isadmin'] == 2) {
								echo '<button onclick="location.href=\'price_detail.php\'">Show Detail</button>';
							}
							echo '</div>';

                            include('./includes/sort.php');
                            if (isset($_GET['st'])) {
						        $_SESSION['sort'] = $_GET['st'];
						        echo '<script>window.location.href = "worksheet.php";</script>';
						    }

							echo '
								<table id="ResponsiveTable" border="3" width="100%">
									<thead id="HeadRow">
										<tr style="border: 2px double black;" bgcolor="#c9c9c9">
											<td align="center"><b><a href="?orderBy=isworkdone">Status</a></b></td>
											<td align="center"><b><a href="?orderBy=invoice">Invoice #</a></b></td>
											<td align="center"><b><a href="?orderBy=po">P.O.</a></b></td>
											<td align="center"><b><a href="?orderBy=company">Company</a></b></td>
											<td align="center"><b><a href="?orderBy=apt">Apt</a></b></td>
											<td align="center"><b><a href="?orderBy=manager">Manager</a></b></td>
											<td align="center"><b><a href="?orderBy=unit">Unit #</a></b></td>			
											<td align="center"><b><a href="?orderBy=price">Price</a></b></td>
											<td align="center"><b>Description</b></td>
											<td align="center"><b><a href="?orderBy=date">Date</a></b></td>
											<td align="center"><b>Assign</b></b></td>
											<td align="center"><b>Edit</b></b></td>
										</tr>
									</thead>
							';
							$orderBy = array('invoice', 'po', 'apt', 'unit', 'size', 'price', 'date', 'isworkdone');
							$order = 'date';
							if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
								$order = $_GET['orderBy'];
							}
							$sql = 'SELECT * FROM Worksheet ';
							if (isset($_POST['date']) && isset($_POST['end_date'])) {
								$start_date = $_POST['date'];
								$end_date = $_POST['end_date'];
								if (strlen($end_date) > 0) {
									$sql .= "WHERE DATE(date) >= '$start_date' AND DATE(date) <= '$end_date' ";
								} else {
									$sql .= "WHERE DATE(date) >= '$start_date' ";
								}
							}

							$sql .= 'ORDER BY '.$order;
							if ($_SESSION['sort']=='desc') {
								$sql = $sql.' DESC';
							}
							$result = mysqli_query($conn, $sql);

							$isOdd = false;
							while($row = mysqli_fetch_array($result))
							{
								$temp_invoice = '7C'.$row['invoice'];

                                $temp_po = $row['PO'];
                                if ($temp_po == null) $temp_po = '-';

								$temp_company = $row['company'];
                                if ($temp_company == null) $temp_company = '-';

								$temp_apt = $row['apt'];
                                if ($temp_apt == null) $temp_apt = '-';

								$temp_manager = $row['manager'];
                                if ($temp_manager == null) $temp_manager = '-';

								$temp_unit = $row['unit'];
                                if ($temp_unit == null) $temp_unit = '-';

                                $temp_size = $row['size'];
                                if ($temp_size == null) $temp_size = '-';

                                $temp_price = number_format($row['price']);
                                if ($temp_price == null) $temp_price = '-';

                                $temp_description = $row['description'];
                                if ($temp_description == null) $temp_description = '-';

                                $temp_date = $row['date'];
                                $temp_date = substr($temp_date, 0, 11);
                                if ($temp_date == null) $temp_date = '-';

								echo '<tbody>';
								if ($isOdd) {
									$isOdd = false;
									echo '<tr bgcolor="#e8fff1">';
								} else {
									$isOdd = true;
									echo '<tr>';
								}

								if ($row['isworkdone'] == 2) {
									echo '<td tableHeadData="Status" align="center"><img src="./img/status_light_green" width="10px"></td>';
								} else if ($row['isworkdone'] == 1) {
									echo '<td tableHeadData="Status" align="center"><img src="./img/status_light_yellow" width="10px"></td>';
								} else {
									echo '<td tableHeadData="Status" align="center"><img src="./img/status_light_red" width="10px"></td>';
								}

								echo '
											<td tableHeadData="Invoice #" align="center"><a href="invoice_detail.php?invoice_num='.$temp_invoice.'">'.$temp_invoice.'</a></td>
											<td tableHeadData="P.O." align="center">'.$temp_po.'</td>
											<td tableHeadData="Company" align="center"><a href="worksheet_company.php?company='.$temp_company.'">'.$temp_company.'</a></td>
											<td tableHeadData="Apt" align="center"><a href="worksheet_apt.php?apt='.$temp_apt.'&company='.$temp_company.'">'.$temp_apt.'</a></td>
											<td tableHeadData="Manager" align="center"><a href="worksheet_manager.php?manager='.$temp_manager.'">'.$temp_manager.'</a></td>
											<td tableHeadData="Unit" align="center">'.$temp_unit.'</td>
											<td tableHeadData="Price" align="center">'.$temp_price.'</td>
											<td tableHeadData="Description" align="left"><a class="lineBreak" href="worksheet_description.php?invoice='.$temp_invoice.'&apt='.$temp_apt.'&unit='.$temp_unit.'&size='.$temp_size.'">'.$temp_description.'</a></td>
											<td tableHeadData="Date" align="center">'.$temp_date.'</td>
											<td tableHeadData="Assign" align="center">
												<button onclick="location.href=\'assign.php?invoice_num='.$temp_invoice.' &apt='.$temp_apt.' &unit_num='.$temp_unit.'\'">Send</button>
											</td>
											<td tableHeadData="Edit" align="center"><button onclick="location.href=\'edit_admin.php?invoice_num='.$temp_invoice.'\'">Edit</button></td>
										</tr>
									</tbody>
								';
							}
							echo '</table>';
						} else {

							include('./includes/sort.php');

							echo '
								<table id="ResponsiveTable" border="3" width="100%">
									<thead id="HeadRow">
										<tr style="border: 2px double black;" bgcolor="#c9c9c9">
											<td align="center"><b><a href="?orderBy=isworkdone">Status</a></b></td>
											<td align="center"><b><a href="?orderBy=apt">Apt</a></b></td>
											<td align="center"><b><a href="?orderBy=unit">Unit #</a></b></td>
											<td align="center"><b>Message</b></td>
											<td align="center"><b><a href="?orderBy=date">Date</a></b></td>
											<td align="center"><b>Comment</b></td>
											<td align="center"><b>Process</b></td>
										</tr>
									</thead>
							';

							$orderBy = array('apt', 'unit', 'date', 'isworkdone');
							$order = 'date';
							if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
								$order = $_GET['orderBy'];
							}
							$sql = 'SELECT * FROM SubWorksheet ';
							if (isset($_POST['date']) && isset($_POST['end_date'])) {
								$start_date = $_POST['date'];
								$end_date = $_POST['end_date'];
								if (strlen($end_date) > 0) {
									$sql .= "WHERE email =\"".$_SESSION['email']."\" AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date' ORDER BY ".$order;
								} else {
									$sql .= "WHERE email =\"".$_SESSION['email']."\" AND DATE(date) >= '$start_date' ORDER BY".$order;
								}
							}

							if ($_SESSION['sort']=='desc') {
								$sql = $sql.' DESC';
							}
							$result = mysqli_query($conn, $sql);

							$isOdd = false;
							while($row = mysqli_fetch_array($result))
							{
								$temp2_invoice = $row['invoice'];
								$temp2_email = $row['email'];
								$temp2_id = $row['id'];

                                $temp2_apt = $row['apt'];
                                if ($temp2_apt == null) $temp2_apt = '-';

                                $temp2_unit = $row['unit'];
                                if ($temp2_apt == null) $temp2_apt = '-';

                                $temp2_message = $row['message'];
                                if ($temp2_message == null) $temp2_message = '-';

                                $temp2_date = $row['date'];
                                if ($temp2_date == null) $temp2_date = '-';

								echo '<tbody>';
								if ($isOdd) {
									$isOdd = false;
									echo '<tr bgcolor="#e8fff1">';
								} else {
									$isOdd = true;
									echo '<tr>';
								}

								if ($row['isworkdone'] == 1) {
									echo '<td tableHeadData="Status" align="center"><img src="./img/status_light_green" width="10px"></td>';
								} else {
									echo '<td tableHeadData="Status" align="center"><img src="./img/status_light_red" width="10px"></td>';
								}

								echo '
											<td tableHeadData="Apt" align="center">'.$temp2_apt.'</td>
											<td tableHeadData="Unit #" align="center">'.$temp2_unit.'</td>
											<td tableHeadData="Message" align="center"><div class="lineBreak_msg">'.$temp2_message.'</div></td>
											<td tableHeadData="Date" align="center">'.$temp2_date.'</td>
											<td tableHeadData="Comment" align="center"><button onclick="location.href=\'show_comment.php?id='.$temp2_id.'&apt='.$temp2_apt.'&unit='.$temp2_unit.'\'">Show</button><button onclick="location.href=\'edit_user.php?id='.$temp2_id.'&invoice='.$temp2_invoice.'\'">Add</button></td>
											<td tableHeadData="Process" align="center"><button id="btn_workdone" onclick="location.href=\'workdone_process.php?invoice_num='.urlencode($temp2_invoice).' &email_user='.urlencode($temp2_email).' &id='.urlencode($temp2_id).'\'">Work Done</button></td>
										</tr>
									</tbody>';
							}
							echo '</table>';
						}
					}
                }
                mysqli_close($conn);
            ?>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
