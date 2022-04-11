<?php
// session_start();
// echo session_id();
// require('connect_db.php');
require('header.php');

$list_of_GL = getAllGL($_SESSION['id']);
$group_name = getMyGroup($_SESSION['id']);

//echo $group_name;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['btnAction']) && $_POST['btnAction'] == "Add")
    {
        makeGL();
        $list_of_GL = getAllGL($_SESSION['id']);
    }
}

$list_of_foods_in_list = getAllFoodInList($_SESSION['id']);
?>

<body>
<div class="container">
  <h1>My Grocery List</h1>
</form>

<hr/>
<h2>List of Foods in <?=$group_name?> List</h2>
<!-- <div class="row justify-content-center">   -->
<table class="w3-table w3-bordered w3-card-4" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="25%">Item Name</th>
    <th width="25%">Cost</th>
    <th width="20%">Brand</th>
    <th width="12%">Remove?</th>
  </tr>
  </thead>
  <?php 
  $page = intval($_GET['page']);

  // The number of records to display per page
  $page_size = 10;
  
  // Calculate total number of records, and total number of pages
  $total_records = count($list_of_foods_in_list);
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
  $data = array_slice($list_of_foods_in_list, $offset, $page_size);

  $page_first = $page > 1 ? 1 : '';
  $page_prev  = $page > 1 ? $page-1 : '';
  $page_next  = $page + 1;
  $page_last  = $total_pages;
  ?>

  <?php 
    foreach ($data as $food):  
    $food_data = getFoodGivenID($food[0]);
    ?>
    
    <tr>
      <td><?php echo $food_data[0]['item_type']; ?></td>
      <td><?php echo $food_data[0]['price']; ?></td>
      <td><?php echo $food_data[0]['brand']; ?></td>
      <td>
          <form action = "grocery_lists.php" method = "POST">
              <input type="submit" value="Delete" name="btnAction" class="btn btn-danger"/>
              <input type = "hidden" name = "food_to_delete" value = "<?php echo $food_data[0]['food_id']?>"/>
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