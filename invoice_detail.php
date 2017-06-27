<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <!-- Body -->
        <div class="container">
            <h3 class="text-center">Invoice Details</h3><br>

            <div class="row" align="center">

                <form action="pedit.php" method="post">
                    <?php
                        // connection with mysql database
                        include('./includes/connection.php');
                        if (isset($_GET['invoice_num'])) {
                            $i_detail = $_GET['invoice_num'];
                            $_SESSION['invoice'] = str_replace('7C', '', $i_detail);
                        } else {
                            $i_detail = '7C'.$_SESSION['invoice'];
                        }
                    
                        echo '<b>Invoice # : '.$i_detail.'</b>';

                        if (!isset($_SESSION['sort'])) {
                            $_SESSION['sort'] = 'asc';
                        }
                        if ($_SESSION['sort']=='asc') {
                            echo '<div align="left"><h><a href="?st=desc">Show descending order</a></h></div>';
                        } else {
                            echo '<div align="left"><h><a href="?st=asc">Show ascending order</a></h></div>';
                        }
                        if (isset($_GET['st'])) {
                            $_SESSION['sort'] = $_GET['st'];
                            echo '<script>window.location.href = "invoice_detail.php";</script>';
                        }
                        $i_detail = str_replace('7C', '', $i_detail);
                        $_SESSION['invoice'] = $i_detail;
                        echo '
                                <table border="2" width="1000">
                                    <thead>
                                        <tr>
                                            <td align="center"><b><a href="?orderBy=isworkdone">Status</a></b></td>
                                            <td align="center"><b><a href="?orderBy=A.first">Name</a></b></td>
                                            <td align="center"><b>Message</b></td>
                                            <td align="center"><b>Comment</b></td>
                                            <td align="center"><b>Price</b></td>
                                            <td align="center"><b><a href="?orderBy=B.date">Date</a></b></td>
                                            <td align="center"><b>Edit</b></td>
                                        </tr>
                                    </thead>';
                            $orderBy = array('A.first', 'A.email', 'B.date', 'B.isworkdone');
                            $order = 'B.date';
                            if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                                $order = $_GET['orderBy'];
                            }
                            $sql = "SELECT * FROM
                            	(SELECT users.first, users.last, users.email from users) AS A
    							INNER JOIN
    							(SELECT * FROM SubWorksheet WHERE invoice='$i_detail') AS B
    							ON A.email=B.email ORDER BY ".$order;
                            if ($_SESSION['sort']=='desc') {
                                $sql = $sql.' DESC';
                            }
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_array($result))
                            {
                                $message = $row['message'];
                                $comment = $row['comment'];
                                $email = $row['email'];
                                $price = $row['price'];
                                $id = $row['id'];
                                echo '
                                    <tbody>
                                        <tr>
                                ';
                                            if ($row['isworkdone'] == 1) {
                                                echo '<td align="center"><img src="./img/status_light_green" width="10px"></td>';
                                            } else {
                                                echo '<td align="center"><img src="./img/status_light_red" width="10px"></td>';
                                            }
                                echo '
                                            <td align="center">'.$row['first'].' '.$row['last'].'</td>
                                            <td align="center">'.$row['message'].'</td>
                                            <td align="center">'.$row['comment'].'</td>
                                            <td align="center">'.$row['price'].'</td>
                                            <td align="center">'.$row['date'].'</td>
                                            <td align="center"><a href="pedit.php?invoice='.urlencode($i_detail).' &email='.urlencode($email).' &id='.urlencode($id).' &price='.urlencode($price).' &comment='.urlencode($comment). ' &message='.urlencode($message).'">Edit</a></td>
                                        </tr>
                                    </tbody>
                                ';
                            }
                            echo '</table>';
                        mysqli_close($conn);
                    ?>
                </form>
                <br>
                <input type="button" value="Back" onclick="location.href='worksheet.php'"></input>
            </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
