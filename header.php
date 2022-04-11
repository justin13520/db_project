<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">

  <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--
  Bootstrap is designed to be responsive to mobile.
  Mobile-first styles are part of the core framework.

  width=device-width sets the width of the page to follow the screen-width
  initial-scale=1 sets the initial zoom level when the page is first loaded
  -->

  <meta name="author" content="Justin Liu and Khoi Pham">
  <meta name="description" content="CS4750 Database project">

  <title>DB project</title>

  <!-- 3. link bootstrap -->
  <!-- if you choose to use CDN for CSS bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <!-- you may also use W3's formats -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

  <!--
  Use a link tag to link an external resource.
  A rel (relationship) specifies relationship between the current document and the linked resource.
  -->

  <!-- If you choose to use a favicon, specify the destination of the resource in href -->
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />

  <!-- if you choose to download bootstrap and host it locally -->
  <!-- <link rel="stylesheet" href="path-to-your-file/bootstrap.min.css" /> -->

  <!-- include your CSS -->
  <!-- <link rel="stylesheet" href="custom.css" />  -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
<style>
body {background-color: powderblue;}
h1   {color: blue;}
p    {color: red;}
div {
  /* padding-top: 50px; */
  /* padding-right: 30px;
  padding-bottom: 50px;
  padding-left: 80px; */
}
table{width:100%};

/* table   {color: white;} */
</style>

</head>
<body>
  <nav class="navbar navbar navbar-expand-lg bg-info">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">Grocery List Project</a>
    </div>
        <?php
        
            include("redirect.php");
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                $link = "https";
            else $link = "http";
              
            // Here append the common URL characters.
            $link .= "://";
              
            // Append the host(domain name, ip) to the URL.
            $link .= $_SERVER['HTTP_HOST'];
              
            // Append the requested resource location to the URL
            $link .= $_SERVER['REQUEST_URI'];
              
            // Print the link
            if(!isset($_SESSION['id']) && $link != 'http://localhost/db_project/index.php'){//brings you to the home page to login
              header("Refresh:0; url=http://localhost/db_project/index.php");
            }
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['name'])) {

                echo '<h1 class ="text-success" style=color:blue;font-size:20px;"> Welcome, ' .  $_SESSION["name"] . '</h1>';
                echo '<ul class="nav navbar-nav">';
                    // echo '<li class="active"><h1 class ="text-success" style=color:blue;font-size:20px;"> Welcome, ' .  $_SESSION["name"] . '</h1> </li>';
                    echo '<li class="active"><a href="index.php">Home</a></li>';
                    echo '<li><a href="food.php?page=">Food Directory</a></li>';
                    echo '<li><a href="roommate_form.php">Roommate Groups</a></li>';
                    echo '<li><a href="grocery_lists.php?page=">Your Grocery Lists</a></li>';
                    echo '<li><a href="logout.php">Logout</a></li>';
                echo '</ul>';
            } else {
                echo "Please log in first to use this website.";
                echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
            }
        ?>
    </div>
  </nav>
</body>