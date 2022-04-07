<?php
// require('connect_db.php');
require('redirect.php');

$list_of_foods = getAllFood();
//$friend_to_update = NULL;
//$friend_to_delete = NULL;
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add")
    {
        addFood($_POST['item_type'], $_POST['price'], $_POST['brand']);
        $list_of_foods = getAllFood();
    }
//    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update")
//    {
////
//        $friend_to_update = getFriend_byName($_POST['friend_to_update']);
////        echo "Update " . $friend_to_update;
////        updateFriend();
//    }
//    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Delete"){
//        deleteFriend($_POST['friend_to_delete']);
//        $list_of_friends = getAllFriends();
//    }
//    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm Update")
//    {
//        updateFriend($_POST['name'], $_POST['major'], $_POST['year']);
//        $list_of_friends = getAllFriends();
//    }
}

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

  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">

  <title>DB interfacing example</title>

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

</head>

<body>
<div class="container">
  <a href="index.php">Go back to home page</a>
  <h1>Food directory</h1>

  <form name="mainForm" action="food.php" method="post">
  <div class="row mb-3 mx-3">
    Item_type:
    <input type="text" class="form-control" name="item_type" required/><!--// value = "<?php if($friend_to_update!=null) echo $friend_to_update['name']?>"/> -->
  </div>
  <div class="row mb-3 mx-3">
    Price:
    <input type="number" class="form-control" name="price" required min="1" max="1000000"/> <!-- //value = "<?php if($friend_to_update!=null) echo $friend_to_update['year']?>"/> -->
  </div>
  <div class="row mb-3 mx-3">
    Brand:
    <input type="text" class="form-control" name="brand" required/><!--// value = "<?php if($friend_to_update!=null) echo $friend_to_update['major']?>"/> -->
  </div>
  <input type="submit" value="Add" name="btnAction" class="btn btn-dark"
        title="insert a food" />
  <input type="submit" value="Confirm Update" name="btnAction" class="btn btn-dark"
        title="confirm update a food" />
</form>

<hr/>
<h2>List of Food</h2>
<!-- <div class="row justify-content-center">   -->
<table class="w3-table w3-bordered w3-card-4" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="25%">Item Name</th>
    <th width="25%">Cost</th>
    <th width="20%">Brand</th>
    <th width="12%">Add to list</th>
    <th width="12%">Delete?</th>
  </tr>
  </thead>
  <?php foreach ($list_of_foods as $food):  ?>
  <tr>
    <td><?php echo $food['item_type']; ?></td>
    <td><?php echo $food['price']; ?></td>
    <td><?php echo $food['brand']; ?></td>
    <td>
        <form action = "food.php" method = "POST">
            <input type="submit" value="Update" name="btnAction" class="btn btn-primary"/>
            <input type = "hidden" name = "friend_to_update" value = "<?php echo $friend['name']?>"/>
        </form>
    </td>
    <td>
        <form action = "food.php" method = "POST">
            <input type="submit" value="Delete" name="btnAction" class="btn btn-danger"/>
            <input type = "hidden" name = "friend_to_delete" value = "<?php echo $friend['name']?>"/>
        </form>
    </td>
  </tr>
  <?php endforeach; ?>


  </table>
<!-- </div>   -->


  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->

  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->

</div>
</body>
</html>