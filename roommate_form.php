<!-- <script src="https://apis.google.com/js/platform.js" async defer></script>

<meta name="google-signin-client_id" content="624168443480-alor55af0q15l98l07c7u0rsc5fkep7t.apps.googleusercontent.com"> -->

<!-- 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 -->
<?php
// require('connect_db.php');
include('redirect.php');
// require('function_db.php');

$list_of_groups = getAllRoommateGroups();
$group_to_leave = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['AddRMGroup']) && $_POST['AddRMGroup'] == "Add")
    {
      makeRoommmateGroup($_SESSION['id'],$_POST['group_name']);
      $list_of_groups = getAllRoommateGroups();
    }
    else if(!empty($_POST['joinGroup']) && $_POST['joinGroup'] == 'Join'){
      joinRoommateGroup($_SESSION['id'],$_POST['join_group']);
      $list_of_groups = getAllRoommateGroups();
    }
    else if(!empty($_POST['leaveGroup']) && $_POST['leaveGroup'] == 'Leave'){
      $group_to_leave = $_POST['leave_group'];
    }
    if(!empty($_POST['confirmLeave']) && $_POST['confirmLeave'] == "Confirm Leave"){
      leaveRMGroup($_SESSION['id'], $_POST['group_name']);
      $list_of_groups = getAllRoommateGroups();
    }
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['name'])) {
  echo 'Welcome, ';
  echo $_SESSION['name'];

  echo '!<a href="food.php">Click to add food items      </a>';
  echo '<a href="roommate_form.php">Click add roommates            </a>';
  echo '<a href="grocery_lists.php">Your Grocery Lists</a>';
  echo '<a href="index.php">Go back to home page</a>';
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
  <h1>Roommate Group Creation</h1>
  <div class="g-signin2" data-onsuccess="onSignIn"></div>



<form name="roomForm" action="roommate_form.php" method="post">
  <!-- <div class="row mb-3 mx-3"> -->
    <!-- Name:
    <input type="text" class="form-control" name="name" required/>
  </div> -->
  <div class="row mb-3 mx-3">
    Group Name:
    <input type="text" class="form-control" name="group_name" required 
      value  = "<?php if ($group_to_leave != null) echo $group_to_leave?>" 
    />
  </div>
  <div class="mb-2 mx-2">
    <input type="submit" value="Add" name="AddRMGroup" class="btn btn-dark"
        title="make a roommate group" />
    <input type="submit" value="Confirm Leave" name="confirmLeave" class="btn btn-dark" 
    title="confirm leave group" />      
  </div>
</form>

<hr/>
<h2>List of Roommate Groups</h2>

<!-- <div class="row justify-content-center">   -->
<table class="w3-table w3-bordered w3-card-4" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="25%">Roommate Group Name</th>
    <th width="25%"># of people in this group</th>
    <th width="12%">Join</th>
    <th width="12%">Leave</th>
  </tr>
  </thead>
  <?php foreach ($list_of_groups as $group):  ?>
  <tr>
    <td><?php echo $group['group_name']; ?></td>
    <td><?php echo $group['total']; ?></td>
    <td>
        <form action = "roommate_form.php" method = "POST">
            <input type="submit" value="Join" name="joinGroup" class="btn btn-primary"/>
            <input type="hidden" name="join_group" value = "<?php echo $group['group_name']?>"/>
        </form>
    </td>
    <td>
        <form action = "roommate_form.php" method = "POST">
            <input type="submit" value="Leave" name="leaveGroup" class="btn btn-danger"/>
            <input type="hidden" name="leave_group" value = "<?php echo $group['group_name']?>"/>
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