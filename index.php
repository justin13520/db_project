<body>
<div class="header">
  <h1>Grocery List: A Database Project</h1>
    <?php
      include("header.php");
      if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['name'])) {
        echo 'Welcome, ';
        echo $_SESSION['name'];

        echo '! <br><a href="food.php">Click to add food items      </a>';
        echo '<a href="roommate_form.php">Click add roommates            </a>';
        echo '<a href="grocery_lists.php">Your Grocery Lists</a>';
        echo '<a href="logout.php">Logout</a>';
        // session_destroy();
      } else {
        echo "Please log in first to see this page.";
        echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
      }
      ?>
  <p>My supercool header</p>
</div>
<div class="container">
  <h1>Hello World!</h1>
  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->

  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->

</div>
</body>
</html>