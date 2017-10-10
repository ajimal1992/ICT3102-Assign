<?php include "templates/include/header.php" ?>

      <script>

      // Prevents file upload hangs in Mac Safari
      // Inspired by http://airbladesoftware.com/notes/note-to-self-prevent-uploads-hanging-in-safari

      function closeKeepAlive() {
        if ( /AppleWebKit|MSIE/.test( navigator.userAgent) ) {
          var xhr = new XMLHttpRequest();
          xhr.open( "GET", "/ping/close", false );
          xhr.send();
        }
      }

      </script>

      <div id="adminHeader">
        <h2>Admin</h2>
        <p>You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>. <a href="admin.php?action=logout">Log out</a></p>
      </div>

      <h1><?php echo $results['pageTitle']?></h1>

      <form action="admin.php?action=<?php echo $results['formAction']?>&amp;page=<?php echo $page?>" method="post" enctype="multipart/form-data" onsubmit="closeKeepAlive()">

<?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>

        <ul>
        <?php if($page=="movie"){ ?>
          <input type="hidden" name="articleId" value="<?php echo $results['article']["movie_ID"]?>"/>
          <li>
            <label for="movie_name">Movie Name</label>
            <input type="text" name="movie_name" id="movie_name" placeholder="Name of the movie" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']["movie_name"])?>" />
          </li>
          <li>
            <label for="movie_cast">Movie Cast</label>
            <input type="text" name="movie_cast" id="movie_cast" placeholder="Name of the cast" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']["movie_cast"])?>" />
          </li>
          <li>
            <label for="movie_director">Movie Director</label>
            <input type="text" name="movie_director" id="movie_name" placeholder="Name of the director" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']["movie_director"])?>" />
          </li>
          <li
            <label for="movie_synopsis">Movie synopsis</label>
            <textarea name="movie_synopsis" id="movie_synopsis" placeholder="Movie synopsis" required maxlength="1000" style="height: 5em;"><?php echo htmlspecialchars( $results['article']["movie_synopsis"])?></textarea>
          </li>
          <li
            <label for="movie_screeningdate">Screening date</label>
            <input type="text" name="movie_screeningdate" id="movie_name" placeholder="Movie screening date" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']["movie_screeningdate"])?>" />
          </li>
          <li>
            <label for="movie_runningtime">Movie running time</label>
            <input type="text" name="movie_runningtime" id="movie_name" placeholder="movie running time" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']["movie_runningtime"])?>" />
          </li>
          <li>
            <label>Current Image</label>
            <img id="articleImage" src="<?php echo "pictures/movies/".$results['article']["movie_ID"].$results['article']["movie_image"]?>" alt="Article Image" />
          </li>
          <?php }?>
        <?php if($page=="cinema"){ ?>
          <input type="hidden" name="articleId" value="<?php echo $results['article']["cinema_ID"]?>"/>
          <li>
            <label for="cinema_location">Cinema Location</label>
            <input type="text" name="cinema_location" id="cinema_location" placeholder="Name of the movie" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']["cinema_location"])?>" />
          </li>
          <li>
            <label for="cinema_address">Cinema Address</label>
            <input type="text" name="cinema_address" id="cinema_address" placeholder="Name of the cast" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']["cinema_address"])?>" />
          </li>
          <li>
            <label for="cinema_bus">Cinema Bus</label>
            <input type="text" name="cinema_bus" id="movie_name" placeholder="Name of the director" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']["cinema_bus"])?>" />
          </li>
          <li
            <label for="cinema_seats">Cinema seats</label>
            <input type="text" name="cinema_seats" id="movie_name" placeholder="Movie screening date" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']["cinema_seats"])?>" />
          </li>
          <li>
            <label for="cinema_train">Cinema Train</label>
            <input type="text" name="cinema_train" id="movie_name" placeholder="movie running time" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']["cinema_train"])?>" />
          </li>
          <li>
            <label>Current Image</label>
            <img id="articleImage" src="<?php echo "pictures/cinema/".$results['article']["cinema_ID"].$results['article']["cinema_image"]?>" alt="Article Image" />
          </li>
          <?php }?>
        <?php if($page=="promotion"){ ?>
          <input type="hidden" name="articleId" value="<?php echo $results['article']["promotion_ID"]?>"/>
          <li>
            <label for="promotion_name">Promotion Name</label>
            <input type="text" name="promotion_name" id="cinema_location" placeholder="Promotion name" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']["promotion_name"])?>" />
          </li>
          <li>
            <label for="promotion_subname">Promotion subname</label>
            <input type="text" name="promotion_subname" id="promotion_subname" placeholder="promotion subname" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']["promotion_subname"])?>" />
          </li>
          <li
            <label for="promotion_description">Promotion Description</label>
            <textarea name="promotion_description" id="promotion_description" placeholder="promotion_description" required maxlength="1000" style="height: 5em;"><?php echo htmlspecialchars( $results['article']["promotion_description"])?></textarea>
          </li>
          <li>
            <label>Current Image</label>
            <img id="articleImage" src="<?php echo "pictures/promo images/".$results['article']["promotion_ID"].$results['article']["promotion_image"]?>" alt="Article Image" />
          </li>
          <?php }?>
          <li>
            <label for="image">New Image</label>
            <input type="file" name="image" id="image" placeholder="Choose an image to upload" maxlength="255" />
          </li>

        </ul>

        <div class="buttons">
          <input type="submit" name="saveChanges" value="Save Changes" />
          <input type="submit" formnovalidate name="cancel" value="Cancel" />
        </div>

      </form>

<?php if ( isset($results['article']["movie_ID"]) && $page=="movie" ) { ?>
      <p><a href="admin.php?action=deleteArticle&amp;articleId=<?php echo $results['article']["movie_ID"] . '&amp;page='.$page?>" onclick="return confirm('Delete This Article?')">Delete This Article</a></p>
<?php } ?>
<?php if ( isset($results['article']["cinema_ID"]) && $page=="cinema" ) { ?>
      <p><a href="admin.php?action=deleteArticle&amp;articleId=<?php echo $results['article']["cinema_ID"] . '&amp;page='.$page?>" onclick="return confirm('Delete This Article?')">Delete This Article</a></p>
<?php } ?>
<?php if ( isset($results['article']["promotion_ID"]) && $page=="promotion" ) { ?>
      <p><a href="admin.php?action=deleteArticle&amp;articleId=<?php echo $results['article']["promotion_ID"] . '&amp;page='.$page?>" onclick="return confirm('Delete This Article?')">Delete This Article</a></p>
<?php } ?>
<?php include "templates/include/footer.php" ?>

