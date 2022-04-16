<?php
// require('connect_db.php');
require('header.php');
if(!isset($_SESSION['id'])){//brings you to the home page to login
  header("Refresh:0; url=http://localhost/db_project/index.php");
}

$list_of_foods = getAllFood();
$food_to_update = NULL;
$food_to_update_id = NULL;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add")
    {
        addFood($_POST['item_type'], $_POST['price'], $_POST['brand']);
        $list_of_foods = getAllFood();
    }

    else if(!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add Item"){
        addFoodToList($_SESSION['id'], $_POST['food_to_add']);
        $list_of_foods = getAllFood();
    }

    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Update")
    {
        $food_to_update_id = $_POST['food_to_update'];
        $food_to_update = getFoodGivenID($_POST['food_to_update']);
    }
    else if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Delete"){
        deletefood($_POST['food_to_delete']);
        $list_of_foods = getAllfood();
    }
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Confirm Update")
    {
        updatefood($_POST['item_type'], $_POST['price'], $_POST['brand'], $_POST['food_to_update']);
        $list_of_foods = getAllfood();
    }
}
?>

<body>
<div class="container">
  <h1>Food directory</h1>

  <form name="mainForm" action="food.php" method="post">
  <div class="row mb-3 mx-3">
    Item_type:
    <input type="text" class="form-control" name="item_type" required value = "<?php if($food_to_update!=null) echo $food_to_update['item_type']?>"/>
  </div>
  <div class="row mb-3 mx-3">
    Price:
    <input type="number" class="form-control" name="price" required min="1" max="1000000" value = "<?php if($food_to_update!=null) echo $food_to_update['price']?>"/>
  </div>
  <div class="row mb-3 mx-3">
    Brand:
    <input type="text" class="form-control" name="brand" required value = "<?php if($food_to_update!=null) echo $food_to_update['brand']?>"/> 
    <input type = "hidden" name = "food_to_update" value = "<?php if($food_to_update_id != null) echo $food_to_update_id ?>"/>
  </div>
  <input type="submit" value="Add" name="btnAction" class="btn btn-dark"
        title="insert a food" />
  <input type="submit" value="Confirm Update" name="btnAction" class="btn btn-dark"
        title="confirm update a food" />
  <a href = 'exportData.php'>Export</a>
</form>

<hr/>
<h2>List of Food</h2>
<!-- <div class="row justify-content-center">   -->
<table class="w3-table w3-bordered w3-card-4">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="25%">Item Name</th>
    <th width="25%">Cost</th>
    <th width="20%">Brand</th>
    <th width="12%">Add to list</th>
    <th width="12%">Update</th>
    <th width="12%">Delete?</th>
  </tr>
  </thead>
  <?php 
  if(!isset($_GET['page'])){
    $_GET['page'] = '';
  }
  $page = intval($_GET['page']);

  // The number of records to display per page
  $page_size = 10;
  
  // Calculate total number of records, and total number of pages
  $total_records = count($list_of_foods);
  $total_pages   = ceil($total_records / $page_size);
  
  // Validation: Page to display can not be greater than the total number of pages
  if ($page > $total_pages) {
      $page = $total_pages;
  }
  
  // Validation: Page to display can not be less than 1
  if ($page < 1) {
      $page = 1;
  }
  
  // Calculate the position of the first record of the page to display
  $offset = ($page - 1) * $page_size;
  
  // Get the subset of records to be displayed from the array
  $data = array_slice($list_of_foods, $offset, $page_size);

  $page_first = $page > 1 ? 1 : '';
  $page_prev  = $page > 1 ? $page-1 : '';
  $page_next  = $page + 1;
  $page_last  = $total_pages;


  ?>
  <?php foreach ($data as $food):  ?>
  <tr>
    <td><?php echo $food['item_type']; ?></td>
    <td><?php echo $food['price']; ?></td>
    <td><?php echo $food['brand']; ?></td>
    <td>
        <form action = "food.php" method = "POST">
            <input type="submit" value="Add Item" name="btnAction" class="btn btn-primary"/>
            <input type = "hidden" name = "food_to_add" value = "<?php echo $food['food_id']?>"/>
        </form>
    </td>
    <td>
        <form action = "food.php" method = "POST">
            <input type="submit" value="Update" name="btnAction" class="btn btn-primary"/>
            <input type = "hidden" name = "food_to_update" value = "<?php echo $food['food_id']?>"/>
        </form>
    </td>
    <td>
        <form action = "food.php" method = "POST">
            <input type="submit" value="Delete" name="btnAction" class="btn btn-danger"/>
            <input type = "hidden" name = "food_to_delete" value = "<?php echo $food['food_id']?>"/>
        </form>
    </td>
  </tr>
  <?php endforeach; ?> 



  </table>
  <div style = "font-size:20px;text-align: center;padding-bottom:30px;padding-top:30px;">
    <a href="food.php?page=<?php echo $page_first; ?>">« First</a>
    <a href="food.php?page=<?php echo $page_prev; ?>">Prev</a>
    <a href="food.php?page=<?php echo $page_next; ?>">Next</a>
    <a href="food.php?page=<?php echo $page_last; ?>">Last »</a>
  </div>
<!-- </div>   -->


  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->

  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->

</div>
</body>
</html>