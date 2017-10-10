<?php

/**
 * Class to handle articles
 */

class Promotion{
    public $tableName = "promotion";
    public $tableColumns = array("promotion_ID" => null,"promotion_image" => null,"promotion_description" => null,"promotion_name" => null,"promotion_subname"=> null); //if there are changes in  table, remember to change in the static methods,
    public function __construct($data=null) {
        //echo "<script>alert('as');</script>";
        //print_r($data);
        if($data!=null){
            foreach(array_keys($this->tableColumns) as $column){
                if(isset($data[$column])){
                    $this->tableColumns[$column] = $data[$column];
                }
            }
        }
        //echo "<script>alert( 'List: " . $this->tableName . "' );</script>";
    }
    
//    public function storeFormValues ( $params ) {
//        $this->__construct( $params );
//    }
    
    public function getValue($columnName){
        return $this->tableColumns[$columnName];
    }
    
    public function getRow() {
        //print_r("enterned here");
        return $this->tableColumns;
    }

    public static function getRowByID($id){ //Change the movie columns and table here
        //print_r($id);
        $tableColumns = array("promotion_ID" => null,"promotion_image" => null,"promotion_description" => null,"promotion_name" => null,"promotion_subname"=> null); //if there are changes in  table, remember to change in the static methods
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        //echo "<script>alert( 'List: " . $this->tableName . " );</script>";
        $sql = "SELECT * FROM promotion WHERE promotion_ID = :id";
        $st = $conn->prepare( $sql );
        $st->bindValue( ":id", $id, PDO::PARAM_INT );
        //$st->bindValue( ":tableName", "promotion", PDO::PARAM_STR );
        
        $st->execute();
        $row = $st->fetch();
        foreach(array_keys($tableColumns) as $column){
            if(isset($row[$column])){
                $tableColumns[$column] = $row[$column];
            }
        }
        $conn = null;
        if ( $row ){
            return $tableColumns;
        }
        else{
            return FALSE;
        }
    }
    
    public static function insertMovies($post, $imageObj=null){ //Change the columns and table here
        $name = $post["promotion_description"];
        $cast = $post["promotion_name"];
        $director = $post["promotion_subname"];
        if($imageObj != null)
            $image = strtolower( strrchr( $imageObj['name'], '.' ) );
        else
            $image = null;
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO promotion (promotion_image, promotion_description, promotion_name, promotion_subname) "
                           . "VALUES (:image, :name, :cast, :director)";
        $st = $conn->prepare ( $sql );
        if($image){
           $st->bindValue( ":image", $image, PDO::PARAM_STR ); 
        }
        else{   
           $st->bindValue( ":image", $image, PDO::PARAM_INT ); 
        }
        $st->bindValue( ":name", $name, PDO::PARAM_STR );
        $st->bindValue( ":cast", $cast, PDO::PARAM_STR );
        $st->bindValue( ":director", $director, PDO::PARAM_STR );
        $st->execute();
        //$this->id = $conn->lastInsertId();
        $id = $conn->lastInsertId();
        //print_r($id);
        $conn = null;
        return new Promotion(Promotion::getRowByID($id));
    }
    
   // public function updateMovies($name, $cast, $director, $synopsis, $runTime, $screenDate, $imageObj=null){ //Change the columns and table here
    public function updateMovies($post, $imageObj=null){
        $name = $post["promotion_description"];
        $cast = $post["promotion_name"];
        $director = $post["promotion_subname"];
        if($imageObj != null)
            $image = strtolower( strrchr( $imageObj['name'], '.' ) );
        else
            $image = null;
        $this->tableColumns = array("promotion_ID"=>$this->tableColumns["promotion_ID"],"promotion_image" => $image,"promotion_description" => $name,"promotion_name" => $cast,"promotion_subname"=> $director);
        
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        
        $sql = "UPDATE promotion SET promotion_image=:image, promotion_description=:name, promotion_name=:cast, promotion_subname=:director WHERE promotion_ID=:id";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":id", $this->tableColumns["promotion_ID"], PDO::PARAM_INT );
        if($image){
           $st->bindValue( ":image", $image, PDO::PARAM_STR ); 
        }
        else{
           $st->bindValue( ":image", $image, PDO::PARAM_INT ); 
        }
        $st->bindValue( ":name", $name, PDO::PARAM_STR );
        $st->bindValue( ":cast", $cast, PDO::PARAM_STR );
        $st->bindValue( ":director", $director, PDO::PARAM_STR );
        $st->execute();
        //$this->id = $conn->lastInsertId();
        $conn = null;
    }
    
    public function deleteMovie(){
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $st = $conn->prepare ( "DELETE FROM promotion WHERE promotion_ID = :id LIMIT 1" );
        $st->bindValue( ":id", $this->tableColumns["promotion_ID"], PDO::PARAM_INT );
        $st->execute();
        $conn = null;
    }
    
    
    public function deleteImages() {

        // Delete all fullsize images for this article
        foreach (glob( "pictures/promo images/" . $this->tableColumns["promotion_ID"] . ".*") as $filename) {
          if ( !unlink( $filename ) ) 
              trigger_error( "Article::deleteImages(): Couldn't delete image file.", E_USER_ERROR );
        }
        // Remove the image filename extension from the object
        $this->tableColumns["promotion_image"] = null;
   }
    
    
    public function storeUploadedImage($image){
        if ( $image['error'] == UPLOAD_ERR_OK ){
            //$this->deleteImages();
            $movieExtension = strtolower( strrchr( $image['name'], '.' ) );
            $tempFilename = trim( $image['tmp_name'] );
            if ( is_uploaded_file ( $tempFilename ) ) {
                    if ( !( move_uploaded_file( $tempFilename, "pictures/promo images/".  $this->tableColumns["promotion_ID"] . $movieExtension) ) ){
                        trigger_error( "Article::storeUploadedImage(): Couldn't move uploaded file.", E_USER_ERROR );
                    }
                    if ( !( chmod( "pictures/promo images/".  $this->tableColumns["promotion_ID"] . $movieExtension, 0666 ) ) ){
                        trigger_error( "Article::storeUploadedImage(): Couldn't set permissions on uploaded file.", E_USER_ERROR );
                    }
            }
        }
    }
    
    public static function getAllPromotionObject($limit = 100000){ //Change the table name here
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM promotion LIMIT :numRows";
        //ORDER BY " . mysql_escape_string($order) . " LIMIT :numRows";
        $st = $conn->prepare( $sql );
        $st->bindValue( ":numRows", $limit, PDO::PARAM_INT );
        $st->execute();
        $list = array();
        while ( $row = $st->fetch() ) {
//          print_r($row);
//          echo "</br></br>";
          $promotion = new Promotion( $row );
          $list[] = $promotion;
        }
        $conn = null;
        return $list;
    }
    
}

?>