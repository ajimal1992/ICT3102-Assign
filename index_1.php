<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
   require( "config.php" );
   //$data = Movie::getAllMoviesObject();
//   foreach($data as $movie){
//       $row = $movie->getRow();
//       print_r($row);
//   }
   //print_r($data[0]->getValue("movie_name"));
  // echo "</br>";
  // print_r(Movie::getRowByID(2));
   //$movie = new Movie(Movie::getRowByID(9));
   //$movie->deleteMovie();
   //$movie->updateMovies("I", "LOVE", "PIZZA", "WOHOO", "I must be bored", "yup im bored");
   //Movie::insertMovies("WAKAKAKA", "itsme", "Dad", "i was wondering", "if after all this years", "you", "adele.jpg");
   //$data2 = new Movie($data);
   //$data = array(0=>"ssd",2=>"asa");
   //echo "<script>alert( 'List: " . implode( ',', $data->tableColumns) . "' );</script>";
//   $test = null;
//   if($test){
//       echo "lol";
//   }
   
//   $arr = array("lol"=>10, "omg"=>20, "wow"=>40);
//   $arr = array("lol"=>20,"omg"=>30);
//   print_r($arr);
   
     if (isset( $_POST['saveChanges'] ) ) {
         if ( isset( $_FILES['image'] ) ){
             //$image = strtolower( strrchr( $_FILES['image']['name'], '.' ) );
             //print_r($image);
            //$newMovie = Movie::insertMovies("WEEEBBaaaaaaaaaaA", "itsmjjkhe", "Dajhd", "i was wondeijiring", "if after all thkis years", "adele.jpg",$_FILES["image"]);
            //$newMovie->storeUploadedImage($_FILES['image']);
            $newMovie = new Movie(Movie::getRowByID(27));
            $newMovie->deleteImages();
         }
     }
   
?>

<form action="index.php" method="post" enctype="multipart/form-data">
    <ul>
    <li>
      <label for="image">New Image</label>
      <input type="file" name="image" id="image" placeholder="Choose an image to upload" maxlength="255" />
      <input type="submit" name="saveChanges" value="Save Changes" />
    </li>
    </ul>
</form>
<!--
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>
-->