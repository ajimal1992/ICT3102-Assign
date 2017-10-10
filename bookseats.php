<?php
session_start();
$host = "localhost";
$database = "shawdb";
$user = "shawread";
$pass = "12345678";
$connection = mysqli_connect($host, $user, $pass, $database);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Shaw Theatre -- Home for cinema --</title>

        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/customCss.css" rel="stylesheet" type="text/css"/>

        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
        <script src="js/init.js"></script>
    </head>
    <body>
        <?php include "header.php" ?>
        <!-- Section #1 -->
        <section class="row hidden-xs" id="intro" data-speed="6" data-type="background">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if (isset($_SESSION['movie_ID']) && isset($_SESSION['cinema_location']) && isset($_SESSION['timing_ID']) && isset($_SESSION['timing_timing'])) {
                            $movieID = $_SESSION['movie_ID'];
                            $sql1 = "SELECT * FROM movies WHERE movie_ID = '$movieID'";
                            $result1 = mysqli_query($connection, $sql1);
                            $row1 = mysqli_fetch_assoc($result1);
                            echo '<img src="pictures/movies/'.$_SESSION['movie_ID'].$_SESSION['movie_image'] . '"class="img-rounded img-responsive img-booking-details" alt="" width="500px"/>';
                            echo '<p class="BookingDetailsfontColor">You have selected <h4 class="BookingDetailsfontColor">' . $row1['movie_name'] . '</h4></p>';
                            echo '<p class="BookingDetailsfontColor">at <h4 class="BookingDetailsfontColor">' . $_SESSION['cinema_location'] . '('.date("d-m-y", strtotime($_SESSION['timing_date'])).', ' .$_SESSION['timing_timing']. ')</h4></p>';
                            echo '<p class="BookingDetailsfontColor">You will receive a confirmation number at the end of your transaction. </br>'
                            . 'To select, please click on the individual seat(s). The total ticket price will be updated automatically.</p>';
                            echo '<hr class="BookingDetailsfontColor">';
                        } else {
                            echo '<p class="BookingDetailsfontColor">Please choose another movie ';
                        }
                        ?>

                    </div>
                </div>
            </div>
        </section>
        <section id="home" data-speed="4" data-type="background">
            <div class="container-fluid translucentbg">
                <div class="container-fluid">
                    <div class="row">
                        <form action="payment.php" method="POST" >
                            <input type="hidden" name="oldStatusCode" value=""/>
                            <input type="hidden" name="newStatusCode" value=""/>
                            <input type="hidden" id="cinema_location" name="cinema_location" value="' .$_POST['cinema_location']. '"/>
                            <input type="hidden" id="movie_ID" name="movie_ID" value="' . $_POST['movie_ID'] . '"/>  
                            <input type="hidden" id="movie_name" name="movie_name" value="' . $_POST['movie_name'] . '"/>  
                            <input type="hidden" id="timing_date" name="timing_date" value="' . $_POST['timing_date'] . '"/>  
                            <input type="hidden" id="timing_ID" name="timing_ID" value="' . $_POST['timing_ID'] . '"/> 
                            <input type="hidden" id="timing_timing" name="timing_timing" value="' . $_POST['timing_timing'] . '"/> 
                            <center>
                                <?php
                                if (isset($_POST['seats']) && isset($_SESSION['timing_ID'])) {
                                    $timmingID = $_SESSION['timing_ID'];

                                    $newStatusCode = $_POST['newStatusCode'];
                                    $oldStatusCode = $_POST['oldStatusCode'];

                                    // open database connection
                                    $linkID = @ mysql_connect("localhost", "shawread", "12345678") or die("Could not connect to MySQL server");
                                    @ mysql_select_db("shawdb") or die("Could not select database");

                                    // prepare select statement
                                    $selectQuery = "SELECT rowId, columnId from seats where ( timing_ID = '$timmingID' and";
                                    $count = 0;
                                    foreach ($_POST['seats'] AS $seat) {
                                        if ($count > 0) {
                                            $selectQuery .= " || ";
                                        }
                                        $selectQuery .= " ( rowId = '" . substr($seat, 0, 1) . "'";
                                        $selectQuery .= " and columnId = " . substr($seat, 1) . " ) ";
                                        $count++;
                                    }
                                    $selectQuery .= " ) and status = $oldStatusCode";

                                    //echo $selectQuery;
                                    // execute select statement
                                    $result = mysql_query($selectQuery);
                                    //echo $result;

                                    $selectedSeats = mysql_num_rows($result);
                                    //echo "<br/>" . $selectedSeats;

                                    if ($selectedSeats != $count) {
                                        $problem = "<h3>There was a problem executing your request. No seat(s) were updated.</h3>";
                                        $problem .= "Possible problems are:";
                                        $problem .= "<ul>";
                                        $problem .= "<li>There was a problem connecting to the database.</li>";
                                        $problem .= "</ul>";
                                        $problem .= "<a href='index.php'>View Seat Plan</a>";
                                        die($problem);
                                    }

                                    // prepare update statement
                                    $newStatusCode = $_POST['newStatusCode'];
                                    $oldStatusCode = $_POST['oldStatusCode'];

                                    $updateQuery = "UPDATE seats set status=$newStatusCode where ( timing_ID = '$timmingID' and ";
                                    $count = 0;
                                    foreach ($_POST['seats'] AS $seat) {
                                        if ($count > 0) {
                                            $updateQuery .= " || ";
                                        }
                                        $updateQuery .= " ( rowId = '" . substr($seat, 0, 1) . "'";
                                        $updateQuery .= " and columnId = " . substr($seat, 1) . " ) ";
                                        $count++;
                                    }

                                    $updateQuery .= " ) and status = $oldStatusCode";

                                    // perform update
                                    $result = mysql_query($updateQuery);
                                    $updatedSeats = mysql_affected_rows();

                                    if ($result && $updatedSeats == $count) {
                                        //$mysql->commit();
                                        echo "<h3 class='BookingDetailsfontColor'>";
                                        echo "You have booked $updatedSeats seat/s: ";
                                        echo "[";
                                        foreach ($_POST['seats'] AS $seat) {
                                            $rowId = substr($seat, 0, 1);
                                            $columnId = substr($seat, 1);
                                            //echo $rowId . $columnId . ", ";	
                                            echo ' <input type="hidden" id="seatNumber" name="seatNumber" value="' . $rowId . $columnId . '"/>';
                                        }
                                        echo $count;
                                        echo "]";
                                        echo "</h3>";
                                    } else {
                                        //$mysql->rollback();
                                        echo "<h3>There was a problem executing your request. No seat(s) were updated.</h3>";
                                        echo "Possible problems are:";
                                        echo "<ul>";
                                        echo "<li>Another process was able to book the same seat while you were still browsing.</li>";
                                        echo "<li>There was a problem connecting to the database.</li>";
                                        echo "</ul>";
                                    }
                                    $sql2 = "SELECT ticket_price from timeslots where timing_ID = '$timmingID' ";
                                    $result2 = mysqli_query($connection, $sql2);
                                    $row2 = mysqli_fetch_assoc($result2);
                                    $totalPrice = $row2['ticket_price'] * $updatedSeats;
                                    echo '<p class="BookingDetailsfontColor">You have to pay $' . $totalPrice . ' amount</p>';
                                    echo '<input type="hidden" id="ticketCost" name="ticketCost" value="' . $totalPrice . '"/>';
                                    mysql_close();
                                }
                                $_SESSION['totalPrice'] = $totalPrice;
                                $_SESSION['seatsBooked'] = $updatedSeats;
                                ?>
                                <br/>
                                <input type='submit' value='Make payment'  value="submit"  />
                            </center>
                        </form>
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

