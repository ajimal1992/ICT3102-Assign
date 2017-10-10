<?php

require( "config.php" );
session_start();
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";

if ( $action != "login" && $action != "logout" && !$username ) {
  login();
  exit;
}

//if(isset($_GET['page'])){
//    if($_GET['page'] == "admin"){
//    require(TEMPLATE_PATH . "/admin/userAcc.php");
//    exit();
//    }
//}
switch ( $action ) {
  case 'login':
    login();
    break;
  case 'logout':
    logout();
    break;
  case 'newArticle':
    newArticle();
    break;
  case 'editArticle':
    editArticle();
    break;
  case 'deleteArticle':
    deleteArticle();
    break;
  default:
    listArticles();
}
function login() {

  $results = array();
  $results['pageTitle'] = "Admin Login";

  if ( isset( $_POST['login'] ) ) {

    // User has posted the login form: attempt to log the user in

    if ( $_POST['username'] == ADMIN_USERNAME && $_POST['password'] == ADMIN_PASSWORD ) {

      // Login successful: Create a session and redirect to the admin homepage
      $_SESSION['username'] = ADMIN_USERNAME;
      header( "Location: admin.php" );

    } else {

      // Login failed: display an error message to the user
      $results['errorMessage'] = "Incorrect username or password. Please try again.";
      require( TEMPLATE_PATH . "/admin/loginForm.php" );
    }

  } else {

    // User has not posted the login form yet: display the form
    require( TEMPLATE_PATH . "/admin/loginForm.php" );
  }

}


function logout() {
  unset( $_SESSION['username'] );
  header( "Location: admin.php" );
}


//function admin() {
//  $results = array();
//  require( TEMPLATE_PATH . "/admin/editMovie.php" );
//
//}

function newArticle() {
  $results = array();
    $page = isset( $_GET['page'] ) ? $_GET['page'] : "";
  switch($page){
      case 'cinema':
          //echo "<script>alert('hit1');</script>";
        $results['pageTitle'] = "New Cinema";
        $results['formAction'] = "newArticle";
          break;
      case 'promotion':
  $results['pageTitle'] = "New Promotion";
  $results['formAction'] = "newArticle";
          break;
      default:
          //echo "<script>alert('hit2');</script>";
          $page = "movie";
  $results['pageTitle'] = "New Movie";
  $results['formAction'] = "newArticle";
          break;
  }
  
  
    if ( isset( $_POST['saveChanges'] ) ) {
      // User has posted the article edit form: save the new article
      if ( isset( $_FILES['image'] ) ){
          if($page=="movie"){
          $movie = Movie::insertMovies($_POST, $_FILES['image']);
          $movie->storeUploadedImage( $_FILES['image'] );
          }
          if($page=="cinema"){
                    $movie = Cinema::insertMovies($_POST, $_FILES['image']);
          $movie->storeUploadedImage( $_FILES['image'] );
          }
          if($page=="promotion"){
                    $movie = Promotion::insertMovies($_POST, $_FILES['image']);
          $movie->storeUploadedImage( $_FILES['image'] );
          }
      }
      else{
          if($page=="movie"){
             Movie::insertMovies($_POST);
          }
          if($page=="cinema"){
              Cinema::insertMovies($_POST);
          }
          if($page=="promotion"){
              Promotion::insertMovies($_POST);
          }
 
      }
      header( "Location: admin.php?status=changesSaved&page=$page" );
    } 
  elseif ( isset( $_POST['cancel'] ) ) {
    // User has cancelled their edits: return to the article list
    header( "Location: admin.php" );
  } 
  else {
    // User has not posted the article edit form yet: display the form
      
    
    $movie = new Movie();
    $results['article'] = $movie->getRow();
    require( TEMPLATE_PATH . "/admin/editMovie.php" );
  }

}

function editArticle() {
  $results = array();
  $page = isset( $_GET['page'] ) ? $_GET['page'] : "";
  switch($page){
      case 'cinema':
          //echo "<script>alert('hit1');</script>";
          $results['formAction'] = "editArticle";
          $results['pageTitle'] = "Edit Cinemas";
          break;
      case 'promotion':
          $results['formAction'] = "editArticle";
          $results['pageTitle'] = "Edit Promotions";
          break;
      default:
          //echo "<script>alert('hit2');</script>";
          $page = "movie";
          $results['formAction'] = "editArticle";
          $results['pageTitle'] = "Edit Movies";
          break;
  }
  
  if ( isset( $_POST['saveChanges'] ) ) {

    // User has posted the article edit form: save the article changes
    if($page=="cinema"){
        $rowData = Cinema::getRowById( (int)$_POST['articleId']);
        $movie = new Cinema($rowData);
    }
    else if($page=="promotion"){
        $rowData = Promotion::getRowById( (int)$_POST['articleId']);
        $movie = new Promotion($rowData);
    }
    else{
        $rowData = Movie::getRowById( (int)$_POST['articleId']);
        $movie = new Movie($rowData);
    }
    if ( isset( $_FILES['image'] ) ){
        $movie->deleteImages();
        $movie->storeUploadedImage( $_FILES['image'] );
        $movie->updateMovies($_POST,$_FILES['image']);
    }
    else{
        $movie->updateMovies($_POST);
    }
    header( "Location: admin.php?status=changesSaved&page=$page" );

  } 
  elseif ( isset( $_POST['cancel'] ) ) {

    // User has cancelled their edits: return to the article list
    header( "Location: admin.php?page=$page" );
  } 
  else {

    // User has not posted the article edit form yet: display the form
    if($page=="cinema")
        $results['article'] = Cinema::getRowById( (int)$_GET['articleId'] );
    else if($page=="promotion")
        $results['article'] = Promotion::getRowById( (int)$_GET['articleId'] );
    else
        $results['article'] = Movie::getRowById( (int)$_GET['articleId'] );
    require( TEMPLATE_PATH . "/admin/editMovie.php" );
  }

}


function deleteArticle() {

  $articleData = Movie::getRowByID((int)$_GET['articleId']);
  $article = new Movie($articleData);
  $article->deleteImages();
  $article->deleteMovie();
  header( "Location: admin.php?status=articleDeleted" );
}


function listArticles() {
  $results = array();
  $page = isset( $_GET['page'] ) ? $_GET['page'] : "";
  switch($page){
      case 'cinema':
          //echo "<script>alert('hit1');</script>";
          $data = Cinema::getAllCinemaObject();
          $results['articles'] = $data;
          $results['pageTitle'] = "All Cinemas";
          break;
      case 'promotion':
          $data = Promotion::getAllPromotionObject();
          $results['articles'] = $data;
          $results['pageTitle'] = "All Promotions";
          break;
      default:
          //echo "<script>alert('hit2');</script>";
          $page = "movie";
          $data = Movie::getAllMoviesObject();
          $results['articles'] = $data;
          $results['pageTitle'] = "All Movies";
          break;
  }

  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "articleNotFound" ){
        $results['errorMessage'] = "Error: Article not found.";
    }
  }
  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ){ 
        $results['statusMessage'] = "Your changes have been saved.";
    }
    if ( $_GET['status'] == "articleDeleted" ) {
        $results['statusMessage'] = "Article deleted.";
    }
  }

  require( TEMPLATE_PATH . "/admin/listMovies.php" );
}

?>
