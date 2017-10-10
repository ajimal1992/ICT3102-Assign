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

<!doctype html>
<html lang="en">
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
                        //$_SESSION['hello'] = $_POST['movie_ID'];
//                       echo $_SESSION['hello'];
                        if (isset($_POST['movie_ID'])) {
                            $movieID = $_POST['movie_ID'];
                            $sql = "SELECT * FROM movies WHERE movie_ID = '$movieID'";
                            $result = mysqli_query($connection, $sql);
                            $row = mysqli_fetch_assoc($result);
                            echo '<h1 class="BookingDetailsfontColor">' . $row['movie_name'] . '</h1>';
                            echo '<hr>';
                            echo '<img src="pictures/movies/'.$row['movie_ID'].$row['movie_image'] . '"class="img-rounded img-responsive" alt="" width="500px" style="float:left; margin-right:10px;" />';
                            echo '<h2 class="BookingDetailsfontColor"><u>Details </u></h2>';
                            echo '<h3 class="BookingDetailsfontColor"> Cast: </h3>';
                            echo '<p class="BookingDetailsfontColor">' . $row['movie_cast'] . '</p> ';
                            echo '<h3 class="BookingDetailsfontColor"> Director: </h3>';
                            echo '<p class="BookingDetailsfontColor">' . $row['movie_director'] . '</p> ';
                            echo '<h3 class="BookingDetailsfontColor"> Running Time: </h3>';
                            echo '<p class="BookingDetailsfontColor">' . $row['movie_runningtime'] . '</p> ';
                            echo '<h3 class="BookingDetailsfontColor"> Screening Time: </h3>';
                            echo '<p class="BookingDetailsfontColor">' . $row['movie_screeningdate'] . '</p> ';
                            echo '<h3 class="BookingDetailsfontColor"> Synopsis: </h3>';
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
                        <div class="col-md-4">
                            <a href="#" class="list-group-item disabled">
                                <span class="glyphicon glyphicon-map-marker"></span><b> Select a cinema</b>
                            </a>
                            <?php
                            $sql1 = "SELECT * FROM cinema";
                            $result1 = mysqli_query($connection, $sql1);
                            while ($row = mysqli_fetch_assoc($result1)) {
                                echo '<form method="POST" action="' . $_SERVER['PHP_SELF'] . '?q=' . $row['cinema_location'] . '">
                                    <input type="hidden" id="movie_ID" name="movie_ID" value="' . $_POST['movie_ID'] . '"/>  
                                    <input type="hidden" id="cinema_location" name="cinema_location" value="' . $row['cinema_location'] . '"/>';

                                if (isset($_GET['q'])) {
                                    if ($row['cinema_location'] == $_GET['q']) {
                                        echo '<button type="submit" name="submit" class="list-group-item active" value="submit">' . $row['cinema_location'] . '</button>';
                                    } else {
                                        echo '<button type="submit" name="submit" class="list-group-item" value="submit">' . $row['cinema_location'] . '</button>';
                                    }
                                } else {
                                    echo '<button type="submit" name="submit" class="list-group-item" value="submit">' . $row['cinema_location'] . '</button>';
                                }
                                echo '</form>';
                            }
                            ?>
                        </div>
                        <div class="col-md-8">
                            <a href="#" class="list-group-item disabled">
                                <span class="glyphicon glyphicon-time"></span><b> Select a timing for the movie</b>
                            </a>
                            <?php
                            if (isset($_POST['cinema_location']) && isset($_POST['movie_ID'])) {
                                $cinema_location = $_POST['cinema_location'];
                                $movieID = $_POST['movie_ID'];
                                $sql2 = "SELECT * FROM timeslots INNER JOIN cinema ON timeslots.cinema_ID = cinema.cinema_ID "
                                        . "INNER JOIN movies ON timeslots.movie_ID = movies.movie_ID WHERE "
                                        . "cinema.cinema_location = '$cinema_location' AND timeslots.movie_ID = '$movieID' "
                                        . "ORDER BY timeslots.timing_date, timeslots.timing_timing";
                                $result2 = mysqli_query($connection, $sql2);
                                $previous_date = NULL;
                                while ($row = mysqli_fetch_assoc($result2)) {
                                    if(!($previous_date == $row['timing_date'])){
                                        echo '<form method="POST" action="seats.php" class="list-group-item BookingDetailsTimingBackground">
                                        <h4>' . date("d-m-y", strtotime($row['timing_date'])) . '</h4>
                                         <input type="hidden" id="movie_ID" name="movie_ID" value="' . $_POST['movie_ID'] . '"/> 
                                         <input type="hidden" id="movie_name" name="movie_name" value="' . $row['movie_name'] . '"/> 
                                         <input type="hidden" id="movie_image" name="movie_image" value="' . $row['movie_image'] . '"/> 
                                         <input type="hidden" id="cinema_location" name="cinema_location" value="' . $_POST['cinema_location'] . '"/>
                                         <input type="hidden" id="timing_ID" name="timing_ID" value="' . $row['timing_ID'] . '"/>   
                                         <input type="hidden" id="timing_date" name="timing_date" value="' . $row['timing_date'] . '"/>    
                                         <button type="submit" name="timing_timing" class="btn btn-primary" value="'. $row['timing_timing'].'">' . $row['timing_timing'] . '</button>';
                                         $previous_date = $row['timing_date']; 
                                    }
                                    else{
                                        echo '<form method="POST" action="seats.php">
                                         <input type="hidden" id="movie_ID" name="movie_ID" value="' . $_POST['movie_ID'] . '"/> 
                                         <input type="hidden" id="movie_name" name="movie_name" value="' . $row['movie_name'] . '"/>
                                             <input type="hidden" id="movie_image" name="movie_image" value="' . $row['movie_image'] . '"/>
                                         <input type="hidden" id="cinema_location" name="cinema_location" value="' . $_POST['cinema_location'] . '"/>
                                         <input type="hidden" id="timing_ID" name="timing_ID" value="' . $row['timing_ID'] . '"/>   
                                         <input type="hidden" id="timing_date" name="timing_date" value="' . $row['timing_date'] . '"/>    
                                         <button type="submit" name="timing_timing" class="btn btn-primary" style="position: relative; margin-left:100px; margin-top:-75px;" value="'. $row['timing_timing'].'">' . $row['timing_timing'] . '</button>';
                                    }
                                    echo '</form>';
                                }
                            } 
                            else {
                                echo '<p class="BookingDetailsfontColor"">Please choose a cinema to view movie timing</p>';
                            }
                            ?>      
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