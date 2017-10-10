<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<?php
$host = "localhost";
$database = "shawdb";
$user = "shawread";
$pass = "12345678";
$connection = mysqli_connect($host, $user, $pass, $database);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}
?>
<!doctype html>
<html lang="en">
    <head>

        <title>Shaw Theatre -- Home for cinema</title>
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/customCss.css" rel="stylesheet" type="text/css"/>

        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
        <script src="js/init.js"></script>
        <script>

            function reserveSeats() {

                var selectedList = getSelectedList('Reserve Seats');
                if (selectedList) {
                    if (confirm('Do you want to reserve selected seat(s) ' + selectedList + '?')) {
                        document.forms[0].oldStatusCode.value = 0;
                        document.forms[0].newStatusCode.value = 1;
                        document.forms[0].action = 'bookseats.php';
                        document.forms[0].submit();
                    } else {
                        //clearSelection();
                        document.forms[0].action = 'index.php';
                    }
                }

            }

            function getSelectedList(actionSelected) {

                // get selected list
                var obj = document.forms[0].elements;
                var selectedList = '';
                for (var i = 0; i < obj.length; i++) {
                    if (obj[i].checked && obj[i].name == 'seats[]') {
                        selectedList += obj[i].value + ', ';
                    }
                }
                // no selection error
                if (selectedList == '') {
                    alert('Please select a seat before clicking ' + actionSelected);
                    return false;
                } else {
                    return selectedList;
                }

            }


        </script>
        <script type="text/javascript">
            var verifyCallback = function (response) {
                alert(response);
            };
            var onloadCallback = function () {
                // Renders the HTML element with id 'example1' as a reCAPTCHA widget.
                // The id of the reCAPTCHA widget is assigned to 'widgetId1'.
                grecaptcha.render('example3', {
                    'sitekey': '6LcuFBITAAAAAHZONK_muOGH-eluSXgQEe7PV1Lp',
                    'callback': verifyCallback,
                    'theme': 'dark'
                });
            };
        </script>
    </head>
    <body>
        <?php include "header.php" ?>

        <!-- Section #1 -->
        <section class="row hidden-xs" id="intro" data-speed="6" data-type="background">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if (isset($_POST['movie_ID'])) {
                            $movieID = $_POST['movie_ID'];
                            $sql = "SELECT * FROM movies WHERE movie_ID = '$movieID'";
                            $result = mysqli_query($connection, $sql);
                            $row = mysqli_fetch_assoc($result);
                            echo '<h1 class="BookingDetailsfontColor">' . $row['movie_name'] . '</h1>';
                            echo '<hr>';
                            echo '<img src="pictures/movies/'. $row['movie_ID'] .$row['movie_image'] . '"class="img-rounded img-responsive img-booking-details" alt="" width="500px"/>';
                            echo '<h2 class="BookingDetailsfontColor"><u>Details </u></h2>';
                            echo '<h3 class="BookingDetailsfontColor"> Cast: </h2>';
                            echo '<p class="BookingDetailsfontColor">' . $row['movie_cast'] . '</p> ';
                            echo '<h3 class="BookingDetailsfontColor"> Director: </h2>';
                            echo '<p class="BookingDetailsfontColor">' . $row['movie_director'] . '</p> ';
                            echo '<h3 class="BookingDetailsfontColor"> Running Time: </h2>';
                            echo '<p class="BookingDetailsfontColor">' . $row['movie_runningtime'] . '</p> ';
                            echo '<h3 class="BookingDetailsfontColor"> Screening Time: </h2>';
                            echo '<p class="BookingDetailsfontColor">' . $row['movie_screeningdate'] . '</p> ';
                            echo '<h3 class="BookingDetailsfontColor"> Synopsis: </h2>';
                            echo '<p class="BookingDetailsfontColor">' . $row['movie_synopsis'] . '</p> ';
                        } else {
                            echo '<p class="BookingDetailsfontColor">Please choose another movie ';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section #2 -->
        <section id="home" data-speed="4" data-type="background">
            <div class="container-fluid translucentbg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            echo '<table width="100%" border="0"> <tr><td width="100%" align="center"> '
                            . '<p class="BookingDetailsfontColor">You have selected <h1 class="BookingDetailsfontColor">' . $row['movie_name'] . '</h1></p>' .
                            '<p class="BookingDetailsfontColor">at <h1 class="BookingDetailsfontColor">' . $_POST['cinema_location'] . '('.date("d-m-y", strtotime($_POST['timing_date'])).', '.$_POST['timing_timing'].')</h1></p>';
                            echo '<p class="BookingDetailsfontColor">You will receive a confirmation number at the end of your transaction. </br>'
                            . 'To select, please click on the individual seat(s). The total ticket price will be updated automatically.</p>';
                            echo '<hr class="BookingDetailsfontColor"> </td></tr>
                     
                       </table>';
                            ?>
                            <form action="bookseats.php" method="POST" >

                                <input type="hidden" name="oldStatusCode" value=""/>
                                <input type="hidden" name="newStatusCode" value=""/>
                                <input type="hidden" id="cinema_location" name="cinema_location" value="' .$_POST['cinema_location']. '"/>
                                <input type="hidden" id="movie_ID" name="movie_ID" value="' . $_POST['movie_ID'] . '"/> 
                                 <input type="hidden" id="movie_name" name="movie_name" value="' . $_POST['movie_name'] . '"/> 
                                 <input type="hidden" id="movie_image" name="movie_image" value="' . $_POST['movie_image'] . '"/>
                                <input type="hidden" id="timing_date" name="timing_date" value="' . $_POST['timing_date'] . '"/> 
                                <input type="hidden" id="timing_ID" name="timing_ID" value="' . $_POST['timing_ID'] . '"/> 
                                <input type="hidden" id="timing_timing" name="timing_timing" value="' . $_POST['timing_timing'] . '"/> 
                                <?php
                                $_SESSION['movie_ID'] = $_POST['movie_ID'];
                                $_SESSION['movie_name'] = $_POST['movie_name'];
                                $_SESSION['movie_image'] = $_POST['movie_image'];
                                $_SESSION['cinema_location'] = $_POST['cinema_location'];
                                $_SESSION['timing_ID'] = $_POST['timing_ID'];
                                $_SESSION['timing_date'] = $_POST['timing_date'];
                                $_SESSION['timing_timing'] = $_POST['timing_timing'];
                   
                                $linkID = mysqli_connect($host, $user, $pass, $database);
                                /* Create and execute query. */
                                if (isset($_POST['timing_ID'])) {
                                    $timmingID = $_POST['timing_ID'];
                                    $query = "SELECT rowId, columnId, status from seats where timing_ID = '$timmingID' order by rowId, columnId asc";
                                    $result = mysqli_query($query);
                                    $prevRowId = null;
                                    $seatColor = null;
                                    $tableRow = false;
                                    echo "<table width='100%' border='0' cellpadding='3' cellspacing='3'>";
                                    while (list($rowId, $columnId, $status) = mysql_fetch_row($result)) {
                                        if ($prevRowId != $rowId) {
                                            if ($rowId != 'A') {
                                                echo "</tr></table></td>";
                                                echo "\n</tr>";
                                            }
                                            $prevRowId = $rowId;
                                            echo "\n<tr><td align='center'><table border='0' cellpadding='30' cellspacing='8'><tr>";
                                            echo"\n <tr><td>&nbsp;</td></tr>";
                                        } else {
                                            $tableRow = false;
                                        }
                                        if ($status == 0) {
                                            $seatColor = "lightgreen";
                                        } else {
                                            $seatColor = "red";
                                        }

                                        echo "\n<td bgcolor='$seatColor' align='center'>";
                                        echo "$rowId$columnId";
                                        if ($status == 0) {
                                            echo "<input type='checkbox' name='seats[]' value='$rowId$columnId'></checkbox>";
                                        } else {
                                            echo "<input type='checkbox' disabled name='seats[]' value='$rowId$columnId'></checkbox>";
                                        }
                                        echo "</td>";
                                        if (($rowId == 'A' && $columnId == 10) ||
                                                ($rowId == 'B' && $columnId == 10) || ($rowId == 'C' && $columnId == 10) || ($rowId == 'D' && $columnId == 10) || ($rowId == 'E' && $columnId == 10) || ($rowId == 'F' && $columnId == 10) || ($rowId == 'G' && $columnId == 10) || ($rowId == 'H' && $columnId == 10) || ($rowId == 'I' && $columnId == 10) || ($rowId == 'J' && $columnId == 10)) {
                                            // This fragment is for adding a blank cell which represent the "center aisle"
                                            echo "<td>&nbsp;</td>";
                                        }
                                    }

                                    echo "</tr></table></td>";
                                    echo "</tr>";
                                    echo "</table>";
                                }

                                /* Close connection to database server. */
                                mysql_close();
                                ?>
                                </td></tr>
                                <tr><td>&nbsp;</td></tr>
                                <table width='100%' border='0'>
                                    <tr><td width="100%" align="center">
                                            <table border="1" cellspacing="8" cellpadding="8">
                                                <tr>
                                                    <td bgcolor='lightgreen'>Available</td>
                                                    <td bgcolor='red'>Reserved </td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    <tr><td>&nbsp;</td></tr>

                                    <tr><td align='center'>
                                            <div id="example3"></div>
                                            <input type='submit' value='Reserve Seats' onclick='reserveSeats()'  />
                                        </td></tr>

                                </table>

                            </form>
                            <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
                                    async defer>
                            </script>
                        </div>
                    </div>
                </div>

                <?php include "footer.php" ?>

        </section>
        <span id="top-link-block" class="hidden">
            <a href="#top" class="well well-sm"  onclick="$('html,body').animate({scrollTop: 0}, 'slow');
                    return false;">
                <i class="glyphicon glyphicon-chevron-up"></i>
            </a>
        </span><!-- /top-link-block -->

    </body>
</html>

