<?php
    ini_set( "display_errors", true ); //Set to false when live
    date_default_timezone_set( "Asia/Singapore" );  // http://www.php.net/manual/en/timezones.php
    define( "DB_DSN", "mysql:host=localhost;dbname=shawdb" );
    define( "DB_USERNAME", "shawread" );
    define( "DB_PASSWORD", "12345678" );
    define( "CLASS_PATH", "classes" );
    define( "TEMPLATE_PATH", "templates" );
    //define( "HOMEPAGE_NUM_ARTICLES", 5 );
    define( "ADMIN_USERNAME", "admin" );
    define( "ADMIN_PASSWORD", "mypass" );
    require( CLASS_PATH . "/movies.php" );
    require( CLASS_PATH . "/cinemas.php" );
    require( CLASS_PATH . "/promotions.php" );
    function handleException( $exception ) {
      echo "Sorry, a problem occurred. Please try later.";
      error_log( $exception->getMessage() );
    }

    set_exception_handler( 'handleException' );
    
    
 ?>