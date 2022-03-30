<?php

function addFood($item_type,$price,$brand)
{
	// db handler
	global $db;

	// write sql
	// insert into friends values('someone', 'cs', 4)";
//	$query = "insert into friends values('" . $name . "', '" . $major . "'," . $year . ")";
	$query = "insert into grocery_items (item_type,price,brand) values (:item_type,:price,:brand)";

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

//function getFriend_byName($name){
//    global $db;
//    $query = "select * from friends where name = :name";
//    $statement = $db->prepare($query);
//    $statement->bindValue(':name',$name);
//    $statement->execute();
//    $result = $statement->fetch();
//    $statement->closeCursor();
//    return $result;
//}
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
//?>