<?php
$host = "localhost";
$database = "shawdb";
$user = "root";
$pass = "";
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

    <body>

        <?php include "header.php" ?>
        <!-- Section #1 -->
        <section class="row hidden-xs" id="intro" data-speed="6" data-type="background">
            <div class="container">
                <div class="col-lg-12">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators img-responsive">
                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#myCarousel" data-slide-to="1"></li>
                            <li data-target="#myCarousel" data-slide-to="2"></li>
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                           <?php
                            $counter = 0;
                            $sql = "SELECT * FROM promotion";
                            $result = mysqli_query($connection, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                if($counter==3){
                                    break;
                                }
                                if ($counter == 0) {
                                    echo '<div class = "item active">
                                        
                                            <img src = "pictures/promo images/'.$row['promotion_ID'].$row['promotion_image'] .'" class = "img-responsive img-rounded" alt = "promotion' . $row['promotion_ID'] . '"/>
                                        </div>';
                                    $counter++;
                                }   else {
                                    echo'<div class="item">
                                        <img src="pictures/promo images/'.$row['promotion_ID'].$row['promotion_image'] .'" class="img-responsive img-rounded" alt="movie' . $row['promotion_ID'] . '"/>
                                        </div>';
                                    $counter++;
                                }
                            }
                            ?>
                        </div>
                        <!-- Left and right controls -->
                        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>

                    </div>
                </div>                    
            </div>
        </section>

        <!-- Section #2 -->
        <section id="home" data-speed="4" data-type="background">
            <div class="container-fluid translucentbg">
                <div class="container img-rounded">
                    <div class="row" style="padding-top: 10px;">
                        <?php
                        $sql = "SELECT * FROM promotion";
                        $result = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" style="padding-top: 40px;">
                            <center><button type="button" class="btn-link img-responsive" data-toggle="modal" data-target="#promo' . $row['promotion_ID'] . '"><img src="pictures/promo images/'.$row['promotion_ID'].$row['promotion_image'] .'" class="img-rounded img-responsive" alt=""/></button></center>
                                <p class="aligning"><button type="button" class="btn-link" data-toggle="modal" data-target="#promo' . $row['promotion_ID'] . '">' . $row['promotion_name'] . '</button></p>
                                <div id="promo' . $row['promotion_ID'] . '" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h3 class="modal-title">' . $row['promotion_name'] . '</h3></div>
                                            <div class="modal-body">
                                                <p class="subheader">' . $row['promotion_subname'] . '</p>
                                                <p>' . $row['promotion_description'] . '</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>';
                        }
                        ?>


                    </div>                    
                </div>
                <footer>© Copyright 2015 Shaw Organisation. All rights reserved</footer>
            </div>  
        </section>


        <span id="top-link-block" class="hidden">
            <a href="#top" class="well well-sm"  onclick="$('html,body').animate({scrollTop: 0}, 'slow');
                    return false;">
                <i class="glyphicon glyphicon-chevron-up"></i>
            </a>
        </span><!-- /top-link-block -->

    </body>

</html>