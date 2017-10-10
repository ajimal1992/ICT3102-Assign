<?php
if (!isset($_SESSION)) {
    session_start();
}

$host = "localhost";
$database = "shawdb";
$user = "shawread";
$pass = "12345678";
$connection = mysqli_connect($host, $user, $pass, $database);

if (mysqli_connect_errno()) {
    die(mysqli_connect_error());
}
$timmingID = $_SESSION['timing_ID'];
$movieID = $_SESSION['movie_ID'];
$movieImage = $_SESSION['movie_image'];

$sql1 = "SELECT timing_timing from timeslots where timing_ID = '$timmingID' ";
$result2 = mysqli_query($connection, $sql1);
$get_Timing = mysqli_fetch_assoc($result2);

$sql2 = "SELECT timing_date from timeslots where timing_ID = '$timmingID' ";
$result2 = mysqli_query($connection, $sql2);
$get_timingDate = mysqli_fetch_assoc($result2);

$sql = "SELECT * FROM movies WHERE movie_ID = '$movieID'";
$result = mysqli_query($connection, $sql);
$getImages = mysqli_fetch_assoc($result);

$error = false;
$errInitial = null;
$errEmail = null;
$errNumber = null;
$errCardName = null;
$errCreditCard = null;
$errExpiryMonth = null;
$errExpiryYear = null;
$errCVV = null;
$valid = false; //First initialise valid as FALSE. 

if (isset($_POST['Submit'])) {
    $initial = trim($_POST['initial']);
    $email = trim($_POST['email']);
    $contact_number = trim($_POST['contact_number']);
    $card_name = trim($_POST['card_name']);
    $credit_card = trim($_POST['credit_card']);
    $expiry_year = trim($_POST['expiry_year']);
    $expiry_month = trim($_POST['expiry_month']);
    //echo "<script>alert($expiry_month)</script>";
    $cvv = trim($_POST['cvv']);

    if (empty($initial)) {
        $errInitial = 'Please enter your initials.';
        $error = true;
    } else if (preg_match('#[0-9]#', $initial)) {
        $errInitial = 'Initials should not contain numbers!';
        $error = true;
    }
    if (empty($email)) {
        $errEmail = 'Please enter your email.';
        $error = true;
    } else if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errEmail = 'Please enter a valid email address';
        $error = true;
    }
    if (empty($contact_number)) {
        $errNumber = 'Please enter your number.';
        $error = true;
    } else if (!is_numeric($contact_number)) {
        $errNumber = 'Only numbers are allowed';
        $error = true;
    } else if (strlen($contact_number) != 8) {
        $errNumber = 'The number need to be 8 digits.';
        $error = true;
    } else if ($contact_number[0] != 9 && $contact_number[0] != 8 && $contact_number[0] != 6) {
        $errNumber = 'This number does not exist';
        $error = true;
    }

    if (empty($card_name)) {
        $errCardName = 'Please enter your name.';
        $error = true;
    } else if (preg_match("/^[a-zA-Z -]+$/", $_POST['card_name']) == 0) {
        $errCardName = 'Your name must only include letters, dashes, or spaces';
        $error = true;
    }
    if (empty($credit_card)) {
        $errCreditCard = 'Please fill in your credit card no';
        $error = true;
    } else if (strlen($credit_card) != 16) {
        $errCreditCard = 'Please enter 16 digits';
        $error = true;
    }
    if ($expiry_year == "13") {
        $errExpiryYear = 'Please select the year';
        $error = true;
    }
    if ($expiry_month == "13") {
        //echo "<script>alert($expiry_month)</script>";
        $errExpiryMonth = 'Please select the month';
        $error = true;
    }
    if (empty($cvv)) {
        $errCVV = 'Please enter your CVV';
        $error = true;
    } else if (strlen($cvv) < 3) {
        $errCVV = 'Please enter 3 digits';
        $error = true;
    }
    if (!empty($initial) && !empty($email) && !empty($contact_number) && !empty($card_name) && !empty($credit_card) && !empty($expiry_year) && !empty($expiry_month) && !empty($cvv) && $error == false) {
        /* Credit card validation onwards */
        //This takes in the card no after the user has entered.
        //this put under a if statement where all three are filled and requirements are matched.
        $initial = $_POST['initial'];
        $email = $_POST['email'];
        $contact_number = $_POST['contact_number'];
        $card_name = $_POST['card_name'];
        $card_number = $_POST['credit_card'];
        $expiry_year = $_POST['expiry_year'];
        $expiry_month = $_POST['expiry_month'];
        $cvv_value = $_POST['cvv'];
        //Split 16 digits into 4 by 4
        $card_array = str_split($card_number, 4);
        //Add the numbers up
        $card_total = array_sum($card_array);
        //concat and convert to int to add to card number
        $expiry_value = $expiry_month . $expiry_year;
        $card_sum = (int) $card_total + $expiry_value;
        $first_3 = substr($card_sum, 0, 3);
        if (strcmp($first_3, $cvv_value) == 0) {
            //echo "<script>alert('valid')</script>";
            //Remind dylan to add payment name for credit card nameecho "
            //echo "<script>swal('message')</script>";
            //here
            $valid = true;
            $sql10 = "INSERT INTO payment(creditCardName,payment_number,payment_expiry,payment_cvv)VALUES('$card_name','$card_number','$expiry_value','$cvv')";
            $sql = "INSERT INTO customer(customer_name,customer_phone,customer_email)VALUES('$initial','$contact_number','$email')";


            if ($connection->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $connection->error;
            }
            
            if ($connection->query($sql10) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql10 . "<br>" . $connection->error;
            }

            $connection->close();
        } else {
            echo "<script>alert('invalid credit card')</script>";
        }
        
        //echo "<script>alert($expiry_month)</script>";}
    }
}
?>
<html>
    <head> 
        <meta charset="utf-8">
        <title>Shaw Theater -- Home for cinema --</title>

        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/customCss.css" rel="stylesheet" type="text/css"/>

        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.4.min.js"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
        <script src="js/init.js"></script>
        <script src="js/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/sweetalert.css"/>

    </head>
    <body>
        <?php include "header.php" ?>
        <!-- Section #1 -->
        <section class="row hidden-xs" id="intro" data-speed="6" data-type="background">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <img class="img-rounded img-responsive img-booking-details" alt="" width="500px" src="pictures/movies/<?php echo $movieID.$movieImage ?>" />
                            <table>     
                                <tr><td><h3 class="BookingDetailsfontColor">Movie: <?php echo $_SESSION['movie_name']; ?></h3></td></tr>
                                <tr><td><h3 class="BookingDetailsfontColor">Cinema: <?php echo $_SESSION['cinema_location']; ?></h3></td></tr>
                                <tr><td><h3 class="BookingDetailsfontColor">Date: <?php echo date("d-m-y", strtotime($_SESSION['timing_date'])) ?></h3></td></tr>
                                <tr><td><h3 class="BookingDetailsfontColor">Timing: <?php echo $get_Timing['timing_timing']; ?></h3></td></tr>
                                <tr><td><h3 class="BookingDetailsfontColor">No of tickets: <?php echo $_SESSION['seatsBooked']; ?></h3></td></tr>
                                <tr><td><h3 class="BookingDetailsfontColor">Total price: $<?php echo $_SESSION['totalPrice']; ?></h3></td></tr>
                            </table>
                    </div>

                </div>

            </div>
        </section>
        <!-- Section #2 -->
        <section id="home" data-speed="4" data-type="background">
            <div class="container-fluid translucentbg">
                <div class="container-fluid">
                    <div class="row">
                        <?php if (!$valid) { ?>  <!--Here is the php code. What i did here is to check if valid is FALSE then executed. The following code. Do note the open curly bracket. Just remmeber its here. So if not valid it will execute-->
                            <div class="col-md-12">
                                <center><h2 class="BookingDetailsfontColor">Personal details</h2></center>
                                <form name="paymentForm" class="form-horizontal" action="payment.php" method="POST">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 BookingDetailsfontColor " for="initial">Initials:</label>
                                        <div class='col-md-5'>
                                            <input type="text" name="initial" class="form-control" placeholder="Initials" id="initial" value="<?php if ($error) echo $initial; ?>"/>
                                            <?php
                                            if ($error) {
                                                echo "<p class='text-danger'>$errInitial</p>";
                                            } else
                                                echo"<p>"
                                                ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 BookingDetailsfontColor" for="email">Email:</label>
                                        <div class='col-md-5'>
                                            <input type="text" name="email" class="form-control" placeholder="Email" id="email" value="<?php if ($error) echo $email; ?>"/>
                                            <?php
                                            if ($error) {
                                                echo "<p class='text-danger'>$errEmail</p>";
                                            } else
                                                echo"<p>"
                                                ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 BookingDetailsfontColor" for="contact_number">Contact number:</label>
                                        <div class='col-md-5'>
                                            <input type="text" name="contact_number" class="form-control" maxlength="8" placeholder="Contact No" id="contact_number" value="<?php if ($error) echo $contact_number; ?>"/>
                                            <?php
                                            if ($error) {
                                                echo "<p class='text-danger'>$errNumber</p>";
                                            } else
                                                echo"<p>"
                                                ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 BookingDetailsfontColor" for="card_name">Name:</label>
                                        <div class='col-md-5'>
                                            <input type="text" name="card_name" class="form-control" placeholder="As it is on the card" id="card_name" value="<?php if ($error) echo $card_name; ?>"/>
                                            <?php
                                            if ($error) {
                                                echo "<p class='text-danger'>$errCardName</p>";
                                            } else
                                                echo"<p>"
                                                ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 BookingDetailsfontColor" for="credit_card">Card number:</label>
                                        <div class='col-md-5'>
                                            <input type="text" name="credit_card" class="form-control" maxlength="16" id="credit_card" placeholder="No dashes or spaces"value="<?php if ($error) echo $credit_card; ?>"/>
                                            <?php
                                            if ($error) {
                                                echo "<p class='text-danger'>$errCreditCard</p>";
                                            } else
                                                echo"<p>"
                                                ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label BookingDetailsfontColor" for="expiry_month">Expiration Date:</label>
                                        <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <select class="form-control col-sm-2 " name="expiry_month" id="expiry_month" placeholder="Month"value="<?php if ($error) echo $expiry_month; ?>"/>
                                                    <option value="13">Month</option> 
                                                    <option value="01">Jan</option>
                                                    <option value="02">Feb</option>
                                                    <option value="03">Mar</option>
                                                    <option value="04">Apr</option>
                                                    <option value="05">May</option>
                                                    <option value="06">June</option>
                                                    <option value="07">July</option>
                                                    <option value="08">Aug</option>
                                                    <option value="09">Sep</option>
                                                    <option value="10">Oct</option>
                                                    <option value="11">Nov</option>
                                                    <option value="12">Dec</option>
                                                    </select>
                                                    <?php
                                                    ///echo "<script>alert('".$errExpiryMonth."')</script>";
                                                    if ($error) {
                                                        echo "<p class='text-danger'>$errExpiryMonth</p>";
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-xs-3">
                                                    <select class="form-control" name="expiry_year" id= "expiry_year" placeholder="Year" value="<?php if ($error) echo $expiry_year; ?>"/>
                                                    <option value="13">Year</option> 
                                                    <option value="15">2015</option>
                                                    <option value="16">2016</option>
                                                    <option value="17">2017</option>
                                                    <option value="18">2018</option>
                                                    <option value="19">2019</option>
                                                    <option value="20">2020</option>
                                                    <option value="21">2021</option>
                                                    <option value="22">2022</option>
                                                    <option value="23">2023</option>
                                                    <option value="24">2024</option>
                                                    <option value="25">2025</option>
                                                    </select>
                                                    <?php
                                                    ///echo "<script>alert('".$errExpiryMonth."')</script>";
                                                    if ($error) {
                                                        echo "<p class='text-danger'>$errExpiryYear</p>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 BookingDetailsfontColor" for="cvv">CVV:</label>
                                        <div class='col-xs-2'>
                                            <input type="text" name="cvv" maxlength="3"  class="form-control" id="cvv" placeholder="CVV" value="<?php if ($error) echo $cvv; ?>"/>
                                            <?php
                                            if ($error) {
                                                echo "<p class='text-danger'>$errCVV</p>";
                                            } else
                                                echo"<p>"
                                                ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-md-5">
                                            <center><input type="submit" name="Submit" class="btn btn-info" style="padding-left: 38px; padding-right: 38px;"/></center>
                                        </div>
                                        <input type="hidden" name="cinema_location" />
                                        <input type="hidden" name="cinema_timing"/>
                                        <input type="hidden" name="movie_name"/>
                                        <input type="hidden" name="ticket_quantity"/>
                                    </div>  
                                </form>
                            </div
                            
                            <input type="hidden" id="movie_ID" name="movie_ID" value="' . $_POST['movie_ID'] . '"/>  
                            <input type="hidden" id="cinema_location" name="cinema_location" value="' .$_POST['cinema_location']. '"/>  
                            <input type="hidden" id="timing_ID" name="timing_ID" value="' . $_POST['timing_ID'] . '"/>   
                            
                            <?php }
                        else {
                            ?> 
                            <script>swal('Seats Booking Success', 'Please check your email. Have a pleasant day, <?php echo $_POST['initial']?>!','success')</script>
                            <h1 class="BookingDetailsfontColor">Booking details</h1>
                            <h3 style="color: green;">Movie: <?php echo $_SESSION['movie_name']?></h3>
                            <h3 style="color: green;">Location: <?php echo $_SESSION['cinema_location']?></h3>
                            <h3 style="color: green;">Date: <?php echo date("d-m-y", strtotime($_SESSION['timing_date'])) ?></h3>
                            <h3 style="color: green;">Timing: <?php echo $_SESSION['timing_timing']?></h3>
                            <h3 style="color: green;">No of tickets: <?php echo $_SESSION['seatsBooked']?></h3>
                            <h3 style="color: green;">Total Price: $<?php echo $_SESSION['totalPrice']?></h3>
                            <meta http-equiv="refresh" content="10;URL='index.php'" />
                        <?php ;} ?>
                        <?php
                        if(isset($_POST['Submit'])) {
                            require 'email/PHPMailerAutoload.php';

                            $mail = new PHPMailer;
                            $mail->isSMTP();                                      // Set mailer to use SMTP
                            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                            $mail->SMTPAuth = true;                               // Enable SMTP authentication
                            $mail->Username = 'ShawTeam17@gmail.com';                 // SMTP username
                            $mail->Password = 'sh@wteam17';                           // SMTP password
                            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                            $mail->Port = 587;                                    // TCP port to connect to

                            $mail->setFrom('from@example.com', 'Shaw Theatres');
                            $mail->addAddress(''.$_POST['email'].'');     // Add a recipient

                            $mail->isHTML(true);                                  // Set email format to HTML

                            $mail->Subject = ''.$_SESSION['movie_name'].' seats successfully booked!';
                            $mail->Body = '<p>Dear '.$_POST['initial'].',</p>
                                    <p>Please be informed that your transaction is confirmed and payment has been debited from your account.</p>
                                    <p><b><u>Booking Details</u></b>
                                    <p>Booked Date: '. date("d-m-y", strtotime($_SESSION['timing_date'])).'</p> 
                                    <p>Booked Time: '.$_SESSION['timing_timing'].'</p>
                                    <p>'.$_SESSION['seatsBooked'].' ticket(s) with a total price of $'.$_SESSION['totalPrice'].'</p>';
                            if(!$mail->send()) {
                                echo 'Booking Details could not be sent.';
                                echo 'Mailer Error: ' . $mail->ErrorInfo;
                            } else {
                                 echo 'Booking details has been sent';
                            }
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