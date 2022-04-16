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

function deleteFood($food_id, $id){
	global $db;

	$queryMod = "SELECT * FROM moderators WHERE google_id = :google_id";
	$statementMod = $db->prepare($queryMod);
	$statementMod->bindValue(':google_id', $id);
	$statementMod->execute();
	$resultsMod = $statementMod->fetchAll();
	$statementMod->closeCursor();

	if(count($resultsMod) != 0){
		$query = "DELETE FROM grocery_items WHERE food_id = :food_id";
		$statement = $db->prepare($query);
		$statement->bindValue(':food_id',$food_id);
		$statement->execute();
		$statement->closeCursor();
	}else{
		echo "You have to be a moderator to do this action!";
	}

	

}

function updateFood($item_type,$price,$brand,$food_id){
   global $db;

   $queryMod = "SELECT * FROM moderators WHERE google_id = :google_id";
	$statementMod = $db->prepare($queryMod);
	$statementMod->bindValue(':google_id', $id);
	$statementMod->execute();
	$resultsMod = $statementMod->fetchAll();
	$statementMod->closeCursor();

	if(count($resultsMod) != 0){
		$query = "UPDATE grocery_items SET brand = :brand, item_type = :item_type, price = :price WHERE food_id = :food_id";
		$statement = $db->prepare($query);
		$statement->bindValue(':brand',$brand);
		$statement->bindValue(':item_type',$item_type);
		$statement->bindValue(':price',$price);
		$statement->bindValue(':food_id',$food_id);
		$statement->execute();
		$statement->closeCursor();
	}else{
		echo "You have to be a moderator to do this action!";
	}
   
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
		//print_r($results[0][1]);
		$queryExists = "SELECT list_id FROM items_in_list WHERE grocery_list_id = :grocery_list_id AND food_id = :food_id";
		$statementExists = $db->prepare($queryExists);
		$statementExists->bindValue(':grocery_list_id', $results[0][1]);
		$statementExists->bindValue(':food_id', $item_id);
		$statementExists->execute();
		$resultsExists = $statementExists->fetchAll();
		$statementExists->closeCursor();
		//print_r($resultsExists);

		if(count($resultsExists) > 0){
			//echo $resultsExists[0][0];
			$queryQuantity = "UPDATE list_info SET quantity = quantity + 1 WHERE list_id = :list_id";
			$statementQuantity = $db->prepare($queryQuantity);
			$statementQuantity->bindValue(':list_id', $resultsExists[0][0]);
			$statementQuantity->execute();
			$statementQuantity->closeCursor();
		}else{
			$query = "insert into items_in_list (grocery_list_id,food_id) values (:grocery_list_id,:food_id)";
			$statement = $db->prepare($query);
			$statement->bindValue(':food_id',$item_id);
			$statement->bindValue(':grocery_list_id', $results[0][1]);
			$statement->execute();
			$statement->closeCursor();

			$queryInfo = "insert into list_info (quantity) values (1)";
			$statementInfo = $db->prepare($queryInfo);
			$statementInfo->execute();
			$statementInfo->closeCursor();

			$queryWants = "insert into who_wants (google_id) values (:google_id)";
			$statementWants = $db->prepare($queryWants);
			$statementWants->bindValue(':google_id',$id);
			$statementWants->execute();
			$statementWants->closeCursor();
		}
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

		$query = "SELECT * FROM items_in_list WHERE grocery_list_id = :grocery_list_id";
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
	$results = $statement->fetchAll();

	$statement->closeCursor();

	return $results;
}

function getInfoGivenID($id){
	global $db;
	$query = "SELECT * FROM list_info WHERE list_id = :list_id";
	$statement = $db->prepare($query);     // 16-Mar, stopped here, still need to fetch and return the result
	$statement->bindValue(':list_id',$id);
	$statement->execute();

	// fetchAll() returns an array of all rows in the result set
	$results = $statement->fetchAll();

	$statement->closeCursor();

	return $results;
}

function getWantGivenID($id){
	global $db;
	$query = "SELECT name FROM who_wants NATURAL JOIN users WHERE list_id = :list_id";
	$statement = $db->prepare($query);     // 16-Mar, stopped here, still need to fetch and return the result
	$statement->bindValue(':list_id',$id);
	$statement->execute();

	// fetchAll() returns an array of all rows in the result set
	$results = $statement->fetchAll();

	$statement->closeCursor();

	if(count($results) == 0){
		return "-";
	}

	return $results[0]['name'];
}

function getPayGivenID($id){
	global $db;
	$query = "SELECT name FROM who_pays NATURAL JOIN users WHERE list_id = :list_id";
	$statement = $db->prepare($query);     // 16-Mar, stopped here, still need to fetch and return the result
	$statement->bindValue(':list_id',$id);
	$statement->execute();

	// fetchAll() returns an array of all rows in the result set
	$results = $statement->fetchAll();

	$statement->closeCursor();

	if(count($results) == 0){
		return "-";
	}

	return $results[0]['name'];
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
   echo $result[0];
   return $result[0];
}
//
//
//function updateFriend($name,$major,$year){
//    global $db;
//    $query = "UPDATE friends SET major = :major, year = :year WHERE name = :name";
//    $statement = $db->prepare($query);
//    $statement->bindValue(':name',$name);
////    echo $name;
//    $statement->bindValue(':major',$major);
////    echo $major;
//    $statement->bindValue(':year',$year);
////    echo $year;
//    $statement->execute();
//    $result = $statement->fetchAll();
//    $statement->closeCursor();
//    return $result;
//}
//
function deleteItemFromList($food_id,$group_name){
   global $db;
   $query = "DELETE FROM items_in_list WHERE food_id = :food_id AND grocery_list_id = :grocery_list_id";
   $statement = $db->prepare($query);
   $statement->bindValue(':food_id',$food_id);
   $statement->bindValue(':grocery_list_id',$group_name);
   $statement->execute();
   $result = $statement->fetch();
   $statement->closeCursor();
   return $result;
}

function payItemFromList($list_id,$google_id){
   global $db;
   $querySearch = "SELECT * FROM who_pays WHERE list_id = :list_id";
   $statementSearch = $db->prepare($querySearch);
   $statementSearch->bindValue(':list_id',$list_id);
   $statementSearch->execute();
   $resultSearch = $statementSearch->fetchAll();
   $statementSearch->closeCursor();


   if(count($resultSearch) == 0){
		$query = "INSERT INTO who_pays (google_id, list_id) values (:google_id,:list_id)";
		$statement = $db->prepare($query);
		$statement->bindValue(':google_id',$google_id);
		$statement->bindValue(':list_id',$list_id);
		$statement->execute();
		$statement->closeCursor();

		$querySearchBill = "SELECT * FROM pay_bill WHERE google_id = :google_id";
		$statementSearchBill = $db->prepare($querySearchBill);
		$statementSearchBill->bindValue(':google_id',$google_id);
		$statementSearchBill->execute();
		$resultSearchBill = $statementSearchBill->fetchAll();
		$statementSearchBill->closeCursor();

		if(count($resultSearchBill) == 0){
			$queryNewBill = "INSERT INTO pay_bill (google_id) values (:google_id)";
			$statementNewBill = $db->prepare($queryNewBill);
			$statementNewBill->bindValue(':google_id',$google_id);
			$statementNewBill->execute();
			$statementNewBill->closeCursor();

			$queryNewBill2 = "INSERT INTO bill (google_id) values (:google_id)";
			$statementNewBill2 = $db->prepare($queryNewBill2);
			$statementNewBill2->bindValue(':google_id',$google_id);
			$statementNewBill2->execute();
			$statementNewBill2->closeCursor();
		}

		$queryGetPrice = "SELECT price FROM grocery_items NATURAL JOIN items_in_list WHERE list_id = :list_id";
		$statementGetPrice = $db->prepare($queryGetPrice);
		$statementGetPrice->bindValue(':list_id', $list_id);
		$statementGetPrice->execute();
		$resultGetPrice = $statementGetPrice->fetchAll();
		$statementGetPrice->closeCursor();
		
		$queryBillUpdate = "UPDATE bill NATURAL JOIN pay_bill SET bill_amount = bill_amount + :amount WHERE google_id = :google_id";
		$statementBillUpdate = $db->prepare($queryBillUpdate);
		$statementBillUpdate->bindValue(':amount', $resultGetPrice[0][0]);
		$statementBillUpdate->bindValue(':google_id', $google_id);
		$statementBillUpdate->execute();
		$statementBillUpdate->closeCursor();


   }else{
		echo "Someone is already paying for this item!";
   }


   
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