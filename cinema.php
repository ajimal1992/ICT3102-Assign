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
                            $sql = "SELECT * FROM cinema";
                            $result = mysqli_query($connection, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                if($counter==3){
                                    break;
                                }
                                if ($counter == 0) {
                                    echo '<div class = "item active">
                                        
                                            <img src = "pictures/cinema/'.$row['cinema_ID'].$row['cinema_image'] .'" class = "img-responsive img-rounded" alt = "cinema' . $row['cinema_ID'] . '"/>
                                        </div>';
                                    $counter++;
                                }   else {
                                    echo'<div class="item">
                                        <img src="pictures/cinema/'.$row['cinema_ID'].$row['cinema_image'] .'" class="img-responsive img-rounded" alt="cinema' . $row['cinema_ID'] . '"/>
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
                    <div class="row hidden-xs" style="padding-top: 40px;">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="google-maps">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d127639.06815987824!2d103.80343705317406!3d1.343883082422793!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sShaw+Theatres!5e0!3m2!1sen!2ssg!4v1446129263892"  frameborder="0" style="width:100%" height="350" allowfullscreen >
                                </iframe>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding-top: 10px;">
                    <?php
                    $sql = "SELECT * FROM cinema";
                    $result = mysqli_query($connection, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" style="padding-top: 40px;">
                            <center><button type="button" class="btn-link img-responsive" data-toggle="modal" data-target="#cinema' . $row['cinema_ID'] . '"><img src="pictures/cinema/'.$row['cinema_ID'] . $row['cinema_image'] . '" class="img-rounded img-responsive" alt=""/></button></center>
                            <p class="aligning"><button type="button" class="btn-link" data-toggle="modal" data-target="#cinema' . $row['cinema_ID'] . '">' . $row['cinema_location'] . '</button></p>
                            <div id="cinema' . $row['cinema_ID'] . '" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h3 class="modal-title">' . $row['cinema_location'] . '</h3></div>
                                        <div class="modal-body">
                                            <p class="cinemaDescription">Location:</p>
                                            ' . $row['cinema_address'] . '
                                            <p class="cinemaDescription">via MRT:</p>
                                            ' . $row['cinema_train'] . '
                                            <p class="cinemaDescription">via Buses:</p>
                                            ' . $row['cinema_bus'] . '
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                    ?>
                      
                    </div>                    
                </div>
                <?php include "footer.php" ?>
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