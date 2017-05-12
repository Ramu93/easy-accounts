<?php 
session_start();
require('../dbconfig.php'); 
$finaloutput = array();
if(!$_POST) {
	$action = $_GET['action'];
}
else {
	$action = $_POST['action'];
}
switch($action){
    case 'add_category':
        $finaloutput = addCategoryToDb();
        echo json_encode($finaloutput);
    break;
    case 'update_category':
        $finaloutput = updateCategoryInDb();
        echo json_encode($finaloutput);
    break;
    case 'delete_category':
        $finaloutput = deleteCategoryFromDb();
        echo json_encode($finaloutput);
    break;
    default:
        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}



function getUniqueCategoryId(){
  global $dbc;
  $table_name = $_SESSION['username'] . "_categories";
  $curr_id = 1;
  $prefix = "CAT_";
  $query = "SELECT cat_id FROM $table_name ORDER BY created_date DESC LIMIT 1";
  $result = mysqli_query($dbc, $query);
  if(mysqli_num_rows($result)>0){
    $row = mysqli_fetch_assoc($result);
    $prev_id = explode("_", $row['cat_id']);
    $curr_id = $prev_id[1] + 1;
  }
  return $prefix.$curr_id;
}

function addCategoryToDb(){
	global $dbc;
	$table_name = $_SESSION['username'] . "_categories";
	$categoryId = getUniqueCategoryId();
	$categoryName = mysqli_real_escape_string($dbc, trim($_POST["categoryName"]));
	$categoryType = mysqli_real_escape_string($dbc, trim($_POST["categoryType"]));
	
	$query = "INSERT INTO $table_name (cat_id, category_name, category_type, created_date) VALUES ('$categoryId', '$categoryName', '$categoryType', CURRENT_TIMESTAMP())";
	if(mysqli_query($dbc, $query)){
		$output = array("infocode" => "INSERTSUCCESS", "message" => "New category added successfully.");
	}else{
		$output = array("infocode" => "INSERTFAILURE", "message" => "New category NOT added!");
	}
	return $output;
}

function updateCategoryInDb(){
	global $dbc;
	$table_name = $_SESSION['username'] . "_categories";
	$categoryId = mysqli_real_escape_string($dbc, trim($_POST["categoryId"]));
	$categoryName = mysqli_real_escape_string($dbc, trim($_POST["categoryName"]));
	$categoryType = mysqli_real_escape_string($dbc, trim($_POST["categoryType"]));
	$query = "UPDATE $table_name SET category_name='$categoryName', category_type='$categoryType' WHERE cat_id='$categoryId'";
	if(mysqli_query($dbc, $query)){
		$output = array("infocode" => "UPDATESUCCESS", "message" => "Category updated successfully.");
	}else{
		$output = array("infocode" => "UPDATEFAILURE", "message" => "Category update failure!");
	}
	return $output;
}

function deleteCategoryFromDb(){
	global $dbc;
	$table_name = $_SESSION['username'] . "_categories";
	$categoryId = mysqli_real_escape_string($dbc, trim($_POST['categoryId']));
	$query = "DELETE FROM $table_name WHERE cat_id = '$categoryId'";
    mysqli_query($dbc,$query);
    $output = array("infocode" => "DELETESUCCESS", "message" => "Category deleted successfully.");
    return $output;
}


?>