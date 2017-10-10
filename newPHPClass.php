<?php
// Always at the VERY TOP of the page.
// The opening php tag above has to be the
// VERY FIRST thing in your page, NO blank lines,
// no NOTHING EVER, or it will NOT work. Yes, really!
require 'captcha.php';

// Now $captchaimg and $captchawav are set and we can introduce 
// those links wherever we like in the page. We can also
// access the captcha code as $_SESSION['captchacode']
// and verify what the user enters in our form, as shown
// below.

// Where to send the messages users enter in the contact form
// (change to your address if you really use this)
$myaddress = 'localhost.com';
?>

<?php
if ($_POST['send']) {
  $errors = array();
  if ($_POST['captcha'] != $_SESSION['captchacode']) {
    $errors[] = "You did not enter the letters shown in the image.";
  } 
  if (!sizeof($errors)) {
    // IMPORTANT: If you don't call this the 
    // user will keep getting the SAME code!
    captchaDone();
    $message = $_POST['message'];
    mail($myaddress, 'Contact Form Submission', $message);
    // Notice we can shift in and out of "HTML mode"
    // to display certain HTML only when the 
    // user passes the test
?>
<html>
<head>
<title>Message Sent</title>
</head>
<body>
<h1>Message Sent</h1>
Thank you for using our handy contact form.
<p>
<!-- Generate a link back to ourselves -->
<a href="<?php echo $SERVER['SCRIPT_URL']?>">Contact Us Again</a>
</body>
</html>
<?php
    // Exit now to prevent the original form from
    // appearing again
    exit(0);
  }
}
?>
<html>
<head>
<title>Contact Us</title>
</head>
<body>
<h1>Contact Us</h1>
<?php
foreach ($errors as $error) {
  echo("<p>$error<p>\n");
}
?>
<p>
<form method="POST" action="<?php echo $SERVER['SCRIPT_URL']?>"> 
<p>
<b>Verification Code</b>
<p>
To prove you are a human being, you must enter the lowercase letters shown
below in the field on the right. Thank you for your understanding!
<p>
<img style="vertical-align: middle" src="<?php echo captchaImgUrl()?>">&nbsp;&nbsp;<input name="captcha" size="8"/> 
<a href="<?php echo captchaWavUrl()?>">Listen To This</a>
<p>
Please enter your message in the text field below. Then click
"Send Your Message."
<p>
<textarea name="message" rows="10" cols="60">
</textarea>
<p>
<input type="submit" name="send" value="Send Your Message"/>
</form>
</body>
</html>