<?php
$host = "localhost";
$database = "shawdb";
$user = "root";
$pass = "9448073SF";
$connection = mysqli_connect($host, $user, $pass, $database);
if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Shaw Threatre -- Home for cinema --</title>

        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/customCss.css" rel="stylesheet" type="text/css"/>

        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
        <script src="js/init.js"></script>
    </head>

    <body background-color: white>
        <?php include "header.php" ?>
        <br><br><br><br><br>
        <div class="container">
            <div class="col-lg-12">
                <div class='searchtext'>
                    Find promotions and location associated with the movies here! Simply key in either the movie name/cast member name/director name! 
                    <form action="" method="post">
                        Movie Name: <input type="text" name="name"><br>
                        Movie Cast: <input type="text" name="cast"><br>
                        Movie Director: <input type="text" name="director"><br>
                        </div>
                        <input type="submit" name="Submit"> <br>
                    </form>
                </div>

            </div>
            <?php
            if (isset($_POST['Submit'])) {
                if (isset($_POST['name'])) {
                    $moviename = $_POST['name'];
                }
                if (isset($_POST['cast'])) {
                    $moviecast = $_POST['cast'];
                }
                if (isset($_POST['director'])) {
                    $moviedirector = $_POST['director'];
                }
                $sql = "SELECT movie_name, movie_cast,movie_director,movie_synopsis,movie_runningtime,movie_screeningdate,movie_location,promotion_name,promotion_description,cinema_bus,cinema_train,cinema_address FROM movies,promotion,cinema WHERE movie_name LIKE '%$moviename%' OR movie_cast LIKE '%$moviecast%' OR movie_director LIKE '%$moviedirector%' ";

                $result = mysqli_query($connection, $sql);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?> 
                        RESULTS:
                        Movie title: <?php echo $row['movie_name']; ?> <br>
                        Movie Cast: <?php echo $row['movie_cast']; ?> <br>
                        Movie Director:<?php echo $row['movie_director']; ?> <br>
                        Movie Synopsis:<?php echo $row['movie_synopsis']; ?> <br>
                        Movie Runtime:<?php echo $row['movie_runningtime']; ?> <br> 
                        Movie Screendate:<?php echo $row['movie_screeningdate'] ?>; <br>
                        Movie Location:<?php echo $row['movie_location']; ?><br>
                        Cinema Address: <?php echo $row['cinema_address']; ?><br>
                        Nearby Trains: <?php echo $row['cinema_train']; ?><br>
                        Nearby Bus: <?php echo $row['cinema_bus']; ?><br>
                        Promotion applicable: <?php echo $row['promotion_name']; ?><br>
                        Promotion Description: <?php echo $row['promotion_description']; ?> <?php
                        echo'<br>';
                    }
                }
            }
            ?>

            <footer>© Copyright 2015 Shaw Organisation. All rights reserved</footer>
    </body>
</html>