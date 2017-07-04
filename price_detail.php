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
            <h3 class="text-center">Work History Details</h3><br>

            <?php
                if (!isset($_SESSION['email'])) {
                    echo "<script>alert(\"You need to sign in first.\");</script>";
                    echo '<script>window.location.href = "signin.php";</script>';
                    exit();
                }
                // connection with mysql database
                include('./includes/connection.php');

                if ($_SESSION['isadmin']) {

                    echo '<div align="right"><a href="worksheet_add.php"><img src="./img/worksheet_add.png" width="42"></a></div>';

                    if (!isset($_SESSION['sort'])) {
                        $_SESSION['sort'] = 'asc';
                    }
                    if ($_SESSION['sort']=='asc') {
                        echo '<div align="left" style="float: left;"><h><a href="?st=desc">Show descending order</a></h></div>';
                    } else {
                        echo '<div align="left" style="float: left;"><h><a href="?st=asc">Show ascending order</a></h></div>';
                    }
                    if ($_SESSION['unpaid']) {
                        echo '<div align="right"><a href="?unpaid=0">Show All</a></div>';
                    } else {
                        echo '<div align="right"><a href="?unpaid=1">Show Unpaid</a></div>';
                    }
                    if (isset($_GET['st'])) {
                        $_SESSION['sort'] = $_GET['st'];
                        echo '<script>window.location.href = "price_detail.php";</script>';
                    }
                    if (isset($_GET['unpaid'])) {
                        $_SESSION['unpaid'] = $_GET['unpaid'];
                        echo '<script>window.location.href = "price_detail.php";</script>';
                    }

                    echo '
                        <table border="2" width="100%">
                            <thead>
                                <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    <td align="center"><b><a href="?orderBy=ispaidoff">Paid Off</a></b></td>
                                    <td align="center"><b><a href="?orderBy=invoice">Invoice #</a></b></td>
                                    <td align="center"><b><a href="?orderBy=po">P.O. #</a></b></td>
                                    <td align="center"><b><a href="?orderBy=apt">Apt #</a></b></td>
                                    <td align="center"><b><a href="?orderBy=unit">Unit #</a></b></td>
                                    <td align="center"><b><a href="?orderBy=size">Size</a></b></td>
                                    <td align="center"><b><a href="?orderBy=price">Price</a></b></td>
                                    <td align="center"><b><a href="?orderBy=price">Recieved</a></b></td>
                                    <td align="center"><b><a href="?orderBy=salary">Salary</a></b></td>
                                    <td align="center"><b><a href="?orderBy=profit">Profit</a></b></td>
                                    <td align="center"><b><a href="?orderBy=date">Date</a></b></td>
                                    <td align="center"><b><a href="?orderBy=date">Recieve</a></b></td>
                                </tr>
                            </thead>
                    ';

                    $orderBy = array('invoice', 'po', 'apt', 'unit', 'size', 'price', 'salary', 'profit', 'date', 'ispaidoff');
                    $order = 'invoice';
                    if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                        $order = $_GET['orderBy'];
                    }
                    if ($_SESSION['unpaid']) {
                        $sql = 'SELECT * FROM Worksheet WHERE ispaidoff=0 ORDER BY '.$order;
                    } else {
                        $sql = 'SELECT * FROM Worksheet ORDER BY '.$order;
                    }
                    if ($_SESSION['sort']=='desc') {
                        $sql = $sql.' DESC';
                    }
                    $result = mysqli_query($conn, $sql);
                    $totalPrice = 0;
                    $totalPaid = 0;
                    $totalSalary = 0;
                    $totalProfit = 0;

                    $isOdd = false;
                    while($row = mysqli_fetch_array($result))
                    {
                        $invoice = '7C'.$row['invoice'];
                        $apt = $row['apt'];
                        $unit = $row['unit'];
                        $totalPrice += $row['price'];
                        $totalSalary += $row['salary'];
                        $totalProfit += $row['profit'];
                        $totalPaid += $row['paid'];

                        echo '<tbody>';
                        if ($isOdd) {
                            $isOdd = false;
                            echo '<tr bgcolor="#e8fff1">';
                        } else {
                            $isOdd = true;
                            echo '<tr>';
                        }

                        if ($row['ispaidoff'] == 1) {
                            echo '<td align="center"><img src="./img/status_light_green" width="10px"></td>';
                        } else {
                            echo '<td align="center"><img src="./img/status_light_red" width="10px"></td>';
                        }

                        echo '
                                    <td align="center"><a href="invoice_detail.php?invoice_num='.$invoice.'">'.$invoice.'</a></td>
                                    <td align="center">'.$row['PO'].'</td>
                                    <td align="center"><a href="worksheet_apt.php?apt='.$apt.'">'.$apt.'</td>
                                    <td align="center">'.$unit.'</td>
                                    <td align="center">'.$row['size'].'</td>
                                    <td align="center">'.$row['price'].'</td>
                                    <td align="center">'.$row['paid'].'</td>
                                    <td align="center">'.$row['salary'].'</td>
                                    <td align="center">'.$row['profit'].'</td>
                                    <td align="center">'.$row['date'].'</td>
                                    <td align="center"><a href="recieve.php?invoice='.$invoice.'&apt='.urlencode($apt).'&unit='.$row['unit'].'&price='.$row['price'].'&paid='.$row['paid'].'">Recieve</a></td>
                        ';
                        echo '
                                </tr>
                            </tbody>
                        ';
                    }
                    echo '
                            <tbody>
                                <tr>
                        ';

                        echo '
                                    <td align="center"></td>
                                    <td align="center"></td>
                                    <td align="center"></td>
                                    <td align="center"></td>
                                    <td align="center"></td>
                                    <td align="center"></td>
                                    <td align="center"><b>'.number_format($totalPrice, 2, '.', '').'</b></td>
                                    <td align="center"><b>'.number_format($totalPaid, 2, '.', '').'</b></td>
                                    <td align="center"><b>'.number_format($totalSalary, 2, '.', '').'</b></td>
                                    <td align="center"><b>'.number_format($totalProfit, 2, '.', '').'</b></td>
                                    <td align="center"></td>
                                    <td align="center"></td>
                        ';
                        echo '

                                </tr>
                            </tbody>
                        ';
                    echo '</table>';
                }
                mysqli_close($conn);
            ?>
            <br>
            <input type="button" value="Back" onclick="location.href='worksheet.php'"></input>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
