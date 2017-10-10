<?php include "templates/include/header.php" ?>

      <div id="adminHeader">
        <h2>Welcome, Admin</h2>
        <p>You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>. <a href="admin.php?action=logout"?>Log out</a></p>
      </div>

    <div class="nav">
      <ul>
        <li class="home"><a <?php if($page=="movie"){echo ' class="active" ';}?> href="admin.php?page=movie">Movies</a></li>
        <li class="tutorials"><a <?php if($page=="cinema"){echo ' class="active" ';}?> href="admin.php?page=cinema">Cinema</a></li>
        <li class="about"><a <?php if($page=="promotion"){echo ' class="active" ';}?> href="admin.php?page=promotion">Promotions</a></li>
        <!--<li class="about"><a href="admin.php?page=admin">Admin</a></li>-->
      </ul>
    </div>


      <h1>All Items</h1>

<?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>


<?php if ( isset( $results['statusMessage'] ) ) { ?>
        <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
        
<?php } ?>

<?php if($page=="movie"){ ?>
      <table>
          
        <tr>
          <th>Movie ID</th>
          <th>Movie Name</th>
        </tr>

<?php foreach ( $results['articles'] as $movie) { ?>
        
        <tr onclick="location='admin.php?action=editArticle&amp;articleId=<?php echo $movie->getRow()["movie_ID"]?>&amp;page=<?php echo $page?>'">
          <td><?php echo $movie->getRow()["movie_ID"]?></td>
          <td>
            <?php echo $movie->getRow()["movie_name"]?>
          </td>
        </tr>
<?php } ?>
      </table>

      <p><?php echo sizeof($results['articles'])+1?> movies in total.</p>

      <p><a href="admin.php?action=newArticle">Add a New Movie</a></p>
<?php } ?>

<?php if($page=="promotion"){ ?>
      <table>
        <tr>
          <th>Movie ID</th>
          <th>Movie Name</th>
        </tr>

<?php foreach ( $results['articles'] as $movie) { ?>
        
        <tr onclick="location='admin.php?action=editArticle&amp;articleId=<?php echo $movie->getRow()["promotion_ID"]?>&amp;page=<?php echo $page?>'">
          <td><?php echo $movie->getRow()["promotion_ID"]?></td>
          <td>
            <?php echo $movie->getRow()["promotion_name"]?>
          </td>
        </tr>
<?php } ?>
      </table>

      <p><?php echo sizeof($results['articles'])+1?> movies in total.</p>

      <p><a href="admin.php?action=newArticle">Add a New Movie</a></p>
<?php } ?>

      
<?php if($page=="cinema"){ ?>
      <table>
        <tr>
          <th>Cinema ID</th>
          <th>Cinema Name</th>
        </tr>

<?php foreach ( $results['articles'] as $movie) { ?>
        <tr onclick="location='admin.php?action=editArticle&amp;articleId=<?php echo $movie->getRow()["cinema_ID"]?>&amp;page=<?php echo $page?>'">
          <td><?php echo $movie->getRow()["cinema_ID"]?></td>
          <td>
            <?php echo $movie->getRow()["cinema_location"]?>
          </td>
        </tr>
<?php } ?>
      </table>

      <p><?php echo sizeof($results['articles'])+1?> cinemas in total.</p>

      <p><a href="admin.php?action=newArticle">Add a New cinema</a></p>
<?php } ?>

<?php include "templates/include/footer.php" ?>

