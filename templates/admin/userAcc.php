<?php include "templates/include/header.php" ?>

      <div id="adminHeader">
        <h2>Admin</h2>
        <p>You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>. <a href="admin.php?action=logout">Log out</a></p>
      </div>
      <form action="admin.php?page=admin" method="post" enctype="multipart/form-data">
        
        <input type="text" name="user" placeholder="username example" required autofocus maxlength="20" value="" />
      </form>
<?php include "templates/include/footer.php" ?>

