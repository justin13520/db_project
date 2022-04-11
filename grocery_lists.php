<?php
// session_start();
// echo session_id();
// require('connect_db.php');
require('header.php');

$list_of_GL = getAllGL($_SESSION['id']);
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add")
    {
        makeGL();
        $list_of_GL = getAllGL($_SESSION['id']);
    }
}
?>

<body>
<div class="container">
  <h1>Grocery List Directory</h1>

  <form name="mainForm" action="grocery_list.php" method="post">
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
        title="insert a friend" />
  <input type="submit" value="Confirm Update" name="btnAction" class="btn btn-dark"
        title="confirm update a friend" />
</form>

<hr/>
<h2>List of grocery_list</h2>
<!-- <div class="row justify-content-center">   -->
<table class="w3-table w3-bordered w3-card-4">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="25%">ID</th>
    <th width="25%">Date</th>
    <th width="20%">Num of Items</th>
    <th width="12%">Update ?</th>
    <th width="12%">Delete ?</th>
  </tr>
  </thead>
  <?php 
    foreach ($list_of_GL as $grocery_list):  ?>
    <tr>
      <td><?php echo $grocery_list['grocery_list_id']; ?></td>
      <td><?php echo $grocery_list['date']; ?></td>
      <td><?php echo $grocery_list['num_of_items']; ?></td>
      <td>
          <form action = "grocery_list.php" method = "POST">
              <input type="submit" value="Update" name="btnAction" class="btn btn-primary"/>
              <input type = "hidden" name = "friend_to_update" value = "<?php echo $friend['name']?>"/>
          </form>
      </td>
      <td>
          <form action = "grocery_list.php" method = "POST">
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