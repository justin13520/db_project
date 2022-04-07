<?php

function addFood($item_type,$price,$brand)
{
	// db handler
	global $db;

	// write sql
	// insert into friends values('someone', 'cs', 4)";
//	$query = "insert into friends values('" . $name . "', '" . $major . "'," . $year . ")";
	$query = "insert into grocery_items (item_type,price,brand) values (:item_type,:price,:brand)";
	echo "why not?";

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
	echo $id;
	echo $group_name;
	$query = "insert into roommates (user_id,group_name,num_of_ppl) values (:user_id,:group_name,:num_of_ppl)";
	$statement = $db->prepare($query);
	$statement->bindValue(":user_id",$id);
	$statement->bindValue(":group_name",$group_name);
	$statement->bindValue(":num_of_ppl",1);
	$statement->execute();
	$statement->closeCursor();
}


function joinRoommateGroup(){
	
}

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
//function deleteFriend($name){
//    global $db;
//    $query = "DELETE FROM friends WHERE name = :name";
//    $statement = $db->prepare($query);
//    $statement->bindValue(':name',$name);
//    $statement->execute();
//    $result = $statement->fetch();
//    $statement->closeCursor();
//    return $result;
//}
//

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
	$query = "select * from grocery_list where google_id = :GL_User_ID";
	$statement = $db->prepare($query);
	$statement->bindValue(':GL_User_ID',$google_id);
	$statement->execute();
	$result = $statement->fetch();
	$statement->closeCursor();
	return $result;
}




?>