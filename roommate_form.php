<?php
include('header.php');
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
?>
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
<table class="w3-table w3-bordered w3-card-4">
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
</div>
</body>
</html>