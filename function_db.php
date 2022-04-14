<?php

function addFood($item_type,$price,$brand)
{
	// db handler
	global $db;

	// write sql
	// insert into friends values('someone', 'cs', 4)";
//	$query = "insert into friends values('" . $name . "', '" . $major . "'," . $year . ")";
	$query = "insert into grocery_items (item_type,price,brand) values (:item_type,:price,:brand)";
	//echo "why not?";

	// execute the sql
//	$statement = $db->query($query);   // query() will compile and execute the sql
    $statement = $db->prepare($query);
    $statement->bindValue(':item_type',$item_type);
    $statement->bindValue(':price',$price);
    $statement->bindValue(':brand',$brand);
    $statement->execute();
	// release; free the connection to the server so other sql statements may be issued
	$statement->closeCursor();
}

function addFoodToList($id, $item_id){
	//echo $id;
	global $db;
	$queryRoommate = "SELECT * FROM roommates WHERE user_id = :user_id";
	$statementRoommate = $db->prepare($queryRoommate);
	$statementRoommate->bindValue(':user_id', $id);
	$statementRoommate->execute();
	$results = $statementRoommate->fetchAll();
	$statementRoommate->closeCursor();
	 
	
	if(count($results) == 0){
		echo "Need to join a roommate group to add items!";
	}else{
		print_r($results[0][1]);

		$query = "insert into items_in_list (grocery_list_id,grocery_item_id) values (:grocery_list_id,:grocery_item_id)";
		$statement = $db->prepare($query);
		$statement->bindValue(':grocery_item_id',$item_id);
		$statement->bindValue(':grocery_list_id', $results[0][1]);
		$statement->execute();
		$statement->closeCursor();
	}
}

function getAllFood()
{
	global $db;
	$query = "select * from grocery_items";
	$statement = $db->query($query);     // 16-Mar, stopped here, still need to fetch and return the result

	// fetchAll() returns an array of all rows in the result set
	$results = $statement->fetchAll();

	$statement->closeCursor();

	return $results;
}

function getAllFoodInList($id){
	global $db;

	$queryRoommate = "SELECT * FROM roommates WHERE user_id = :user_id";
	$statementRoommate = $db->prepare($queryRoommate);
	$statementRoommate->bindValue(':user_id', $id);
	$statementRoommate->execute();
	$results = $statementRoommate->fetchAll();
	$statementRoommate->closeCursor();

	if(count($results) == 0){
		echo "Need to join a roommate group to see your list!";
		return [];
	}else{
		//print_r($results[0][1]);

		$query = "SELECT grocery_item_id FROM items_in_list WHERE grocery_list_id = :grocery_list_id";
		$statement = $db->prepare($query);
		$statement->bindValue(':grocery_list_id', $results[0][1]);
		$statement->execute();
		$resultsFood = $statement->fetchAll();
		$statement->closeCursor();
		//print_r($resultsFood[0][0]);
		return $resultsFood;
	}
}

function getFoodGivenID($id){
	global $db;
	$query = "SELECT * FROM grocery_items WHERE food_id = :food_id";
	$statement = $db->prepare($query);     // 16-Mar, stopped here, still need to fetch and return the result
	$statement->bindValue(':food_id',$id);
	$statement->execute();

	// fetchAll() returns an array of all rows in the result set
	$results = $statement->fetch();
	
	$statement->closeCursor();

	return $results;
}

function getMyGroup($id){
	global $db;
	$queryRoommate = "SELECT * FROM roommates WHERE user_id = :user_id";
	$statementRoommate = $db->prepare($queryRoommate);
	$statementRoommate->bindValue(':user_id', $id);
	$statementRoommate->execute();
	$results = $statementRoommate->fetchAll();
	$statementRoommate->closeCursor();
	if(count($results) == 0){
	}else{
		return $results[0][1];
	}
}

function addUser($name,$email,$google_id,$profile_image)
{
	// db handler
	global $db;

	// write sql
	// insert into friends values('someone', 'cs', 4)";
//	$query = "insert into friends values('" . $name . "', '" . $major . "'," . $year . ")";
	$query = "insert into users (name,email,google_id,profile_image) values (:name,:email,:google_id,:profile_image)";

	// execute the sql
//	$statement = $db->query($query);   // query() will compile and execute the sql
	echo "why not?";
    $statement = $db->prepare($query);
    $statement->bindValue(':name',$name);
	$statement->bindValue(':email',$email);
	$statement->bindValue(':google_id',$google_id);
	$statement->bindValue(':profile_image',$profile_image);
    $statement->execute();
	// release; free the connection to the server so other sql statements may be issued
	$statement->closeCursor();
}

function getAllRoommateGroups()
{
	global $db;
	$query = "SELECT group_name, COUNT(*) as total FROM roommates GROUP BY group_name";
	$statement = $db->query($query);     // 16-Mar, stopped here, still need to fetch and return the result

	// fetchAll() returns an array of all rows in the result set
	$results = $statement->fetchAll();

	$statement->closeCursor();

	return $results;
}

function makeRoommmateGroup($id,$group_name){
	global $db;
	echo $group_name;
	echo $id;

	$num_of_exist = "SELECT * FROM roommates WHERE group_name = :group_name";
	$statement1 = $db->prepare($num_of_exist);
	$statement1->bindValue(":group_name",$group_name);
	$result = $statement1->fetch();	
	$statement1->closeCursor();
	if(empty($result)){//makes sure the name is unique, dont want two groups with the same group names
		echo "empty";
		$query = "INSERT INTO roommates (user_id,group_name) VALUES (:user_id,:group_name)";
		$statement = $db->prepare($query);
		$statement->bindValue(":user_id",$id);
		$statement->bindValue(":group_name",$group_name);
		$statement->execute();
		$statement->closeCursor();
	}
}

function joinRoommateGroup($id,$group_name){
	global $db;
	//phase 1: check if the user already joined
	$is_user_already_in_group_query = "SELECT * FROM roommates WHERE user_id = :user_id";
	$checking_statement = $db->prepare($is_user_already_in_group_query);
	$checking_statement->bindValue(":user_id",$id);
	// $checking_statement->bindValue(":group_name",$group_name);
	$checking_statement->execute();
	$checking_result = $checking_statement->fetchAll();
	$checking_statement->closeCursor();

	if(empty($checking_result)){//phase 2: if empty, join the group by inserting into the table
		$insert_query = "insert into roommates (user_id,group_name) values (:user_id,:group_name)";
		$insert_statement = $db->prepare($insert_query);
		$insert_statement->bindValue(":user_id",$id);
		$insert_statement->bindValue(":group_name",$group_name);
		$insert_statement->execute();
		$insert_statement->closeCursor();
		
	}
}

function leaveRMGroup($id,$group_name){
	global $db;
   	$query = "DELETE FROM roommates WHERE user_id = :user_id AND group_name = :group_name";
	$statement = $db->prepare($query); 
	$statement->bindValue(':user_id',$id);
	$statement->bindValue(':group_name',$group_name);
	$statement->execute();
	$result = $statement->fetch();
	$statement->closeCursor();
	return $result;
}

// function getRMGroupByName($group_name){
// 	global $db;
// 	$query = "select DISTINCT(*) from roommates where group_name = :group_name";
// // 1. prepare
// // 2. bindValue & execute
// 	$statement = $db->prepare($query);
// 	$statement->bindValue(':group_name', $group_name);
// 	$statement->execute();

// 	// fetch() returns a row
// 	$results = $statement->fetch();   

// 	$statement->closeCursor();

// 	return $results;
// }

function num_of_user($google_id){
   global $db;
   $query = "SELECT COUNT(*) FROM users where google_id = :google_id";
   $statement = $db->prepare($query);
   $statement->bindValue(':google_id',$google_id);
   $statement->execute();
   $result = $statement->fetch();
   $statement->closeCursor();
   return $result;
}

function deleteFood($food_id){
	global $db;

}

function updateFood($item_type,$price,$brand,$food_id){
   global $db;
//    echo "food id: " . $food_id;
   $query = "UPDATE grocery_items SET brand = :brand, item_type = :item_type, price = :price WHERE food_id = :food_id";
   $statement = $db->prepare($query);
   $statement->bindValue(':brand',$brand);
   $statement->bindValue(':item_type',$item_type);
   $statement->bindValue(':price',$price);
   $statement->bindValue(':food_id',$food_id);
   $statement->execute();
   $statement->closeCursor();
}

function deleteItemFromList($food_id,$group_name){
   global $db;
   $query = "DELETE FROM items_in_list WHERE grocery_item_id = :grocery_item_id AND grocery_list_id = :grocery_list_id";
   $statement = $db->prepare($query);
   $statement->bindValue(':grocery_item_id',$food_id);
   $statement->bindValue(':grocery_list_id',$group_name);
   $statement->execute();
   $result = $statement->fetch();
   $statement->closeCursor();
   return $result;
}


function makeGL(){
	global $db;
	$query = "INSERT INTO grocery_list (date, num_of_items) values (:date,:num)";
	$date = "SELECT CAST(GETDATE())";
	$statement = $db->prepare($query);
	$statement->bindValue(':date',$date);
	$statement->bindValue(':num',0);
	$statement->execute();
	$statement->closeCursor();
}

function getAllGL($google_id){
	global $db;
	$query = "select * from grocery_list where GL_User_ID = :GL_User_ID";
	$statement = $db->prepare($query);
	$statement->bindValue(':GL_User_ID',$google_id);
	$statement->execute();
	$result = $statement->fetchAll();
	$statement->closeCursor();
	return $result;
}




?>