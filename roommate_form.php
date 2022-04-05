<script src="https://apis.google.com/js/platform.js" async defer></script>

<meta name="google-signin-client_id" content="624168443480-alor55af0q15l98l07c7u0rsc5fkep7t.apps.googleusercontent.com">

<!-- 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 -->
<?php
require('connect_db.php');
// include('connect-db.php');

require('function_db.php');

$list_of_users = getAllRoommateGroups();
//$friend_to_update = NULL;
//$friend_to_delete = NULL;
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add")
    {
        $list_of_users = getAllRoommateGroups();
    }
}

?>

<script>
  function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    <?php echo "tomato" ?>
    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
  }
</script>

<a href="#" onclick="signOut();">Sign out</a>
<script>
  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }
</script>
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
  <h1>User Creation</h1>
  <div class="g-signin2" data-onsuccess="onSignIn"></div>



<form name="mainForm" action="userform.php" method="post">
  <div class="row mb-3 mx-3">
    Name:
    <input type="text" class="form-control" name="name" required/>
  </div>
  <div class="row mb-3 mx-3">
    Group Name:
    <input type="text" class="form-control" name="name" required/>
    <input type="submit" value="Add" name="btnAction" class="btn btn-dark"
        title="insert a friend" />
  </div>
</form>

<hr/>
<h2>List of Roommate Groups</h2>
<!-- <div class="row justify-content-center">   -->
<table class="w3-table w3-bordered w3-card-4" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="25%">Name</th>
    <th width="12%">Update ?</th>
    <th width="12%">Delete ?</th>
  </tr>
  </thead>
  <?php foreach ($list_of_users as $user):  ?>
  <tr>
    <td><?php echo $user['name']; ?></td>
    <td>
        <form action = "roommate_form.php" method = "POST">
            <input type="submit" value="Update" name="btnAction" class="btn btn-primary"/>
            <!--<input type = "hidden" name = "friend_to_update" value = "<?php echo $friend['name']?>"/>-->
        </form>
    </td>
    <td>
        <form action = "roommate_form.php" method = "POST">
            <input type="submit" value="Delete" name="btnAction" class="btn btn-danger"/>
            <!--//<input type = "hidden" name = "friend_to_delete" value = "<?php echo $friend['name']?>"/>-->
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