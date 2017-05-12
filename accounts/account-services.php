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
	case 'add_account':
	$finaloutput = addAccountToDb();
	echo json_encode($finaloutput);
	break;
	case 'update_account':
	$finaloutput = updateAccountInDb();
	echo json_encode($finaloutput);
	break;
	case 'get_account_details':
	//returns HTML data
	$finaloutput = getAccountDetails();
	echo $finaloutput;
	break;
	case 'delete_account':
	$finaloutput = deleteAccountFromDb();
	echo json_encode($finaloutput);
	break;
	default:
	$finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}



function getUniqueAccountId(){
  global $dbc;
  $table_name = $_SESSION['username'] . "_accounts";
  $curr_id = 1;
  $prefix = "ACC_";
  $query = "SELECT acc_id FROM $table_name ORDER BY created_date DESC LIMIT 1";
  $result = mysqli_query($dbc, $query);
  if(mysqli_num_rows($result)>0){
    $row = mysqli_fetch_assoc($result);
    $prev_id = explode("_", $row['acc_id']);
    $curr_id = $prev_id[1] + 1;
  }
  return $prefix.$curr_id;
}

//mysqli_real_escape_string($dbc, trim());

function addAccountToDb(){
	global $dbc;
	$table_name = $_SESSION['username'] . "_accounts";
	$accId = getUniqueAccountId();
	$accName = mysqli_real_escape_string($dbc, trim($_POST["accName"]));
	$accType = mysqli_real_escape_string($dbc, trim($_POST["accType"]));
	$startingBalance = mysqli_real_escape_string($dbc, trim($_POST["startingBalance"]));
	$openDate = mysqli_real_escape_string($dbc, trim($_POST["openDate"]));
	$accHolderName = mysqli_real_escape_string($dbc, trim($_POST["accHolderName"]));
	$accNumber = mysqli_real_escape_string($dbc, trim($_POST["accNumber"]));
	$bankName = mysqli_real_escape_string($dbc, trim($_POST["bankName"]));
	$branch = mysqli_real_escape_string($dbc, trim($_POST["branch"]));
	$city = mysqli_real_escape_string($dbc, trim($_POST["city"]));
	$query = "INSERT INTO $table_name (acc_id, acc_name, acc_type, starting_balance, current_balance, open_date, acc_holder_name, acc_number, bank, branch, city, created_date) VALUES ('$accId', '$accName', '$accType', '$startingBalance', '$startingBalance', '$openDate', '$accHolderName', '$accNumber', '$bankName', '$branch', '$city' , CURRENT_TIMESTAMP())";
	if(mysqli_query($dbc, $query)){
		$output = array("infocode" => "INSERTSUCCESS", "message" => "New account added successfully.");
	}else{
		$output = array("infocode" => "INSERTFAILURE", "message" => "New account NOT added!");
	}
	return $output;
}

function updateAccountInDb(){
	global $dbc;
	$table_name = $_SESSION['username'] . "_accounts";
	$accId = mysqli_real_escape_string($dbc, trim($_POST['accId']));
	$accName = mysqli_real_escape_string($dbc, trim($_POST["accName"]));
	$accType = mysqli_real_escape_string($dbc, trim($_POST["accType"]));
	$startingBalance = mysqli_real_escape_string($dbc, trim($_POST["startingBalance"]));
	$openDate = mysqli_real_escape_string($dbc, trim($_POST["openDate"]));
	$accHolderName = mysqli_real_escape_string($dbc, trim($_POST["accHolderName"]));
	$accNumber = mysqli_real_escape_string($dbc, trim($_POST["accNumber"]));
	$bankName = mysqli_real_escape_string($dbc, trim($_POST["bankName"]));
	$branch = mysqli_real_escape_string($dbc, trim($_POST["branch"]));
	$city = mysqli_real_escape_string($dbc, trim($_POST["city"]));
	$query = "UPDATE $table_name SET acc_name='$accName', acc_type='$accType', starting_balance='$startingBalance', open_date='$openDate', acc_holder_name='$accHolderName', acc_number='$accNumber', bank='$bankName', branch='$branch', city='$city' WHERE acc_id='$accId'";
	if(mysqli_query($dbc, $query)){
		$output = array("infocode" => "UPDATESUCCESS", "message" => "Account updated successfully.");
	}else{
		$output = array("infocode" => "UPDATEFAILURE", "message" => "Account update failure!");
	}
	return $output;
}

function getAccountDetails(){
	global $dbc;
	$table_name = $_SESSION['username'] . "_accounts";
	$accId = $_POST['accId'];
	$query = "SELECT * FROM $table_name WHERE acc_id='$accId'";
	$result = mysqli_query($dbc, $query);
	$output = "<table class=\"table table-bordered\"><thead><tr><th>Account Holder</th><th>Account Number</th><th>Starting Balance</th><th>Open Date</th><th>Bank Details</th></tr></thead><tbody>";
	if(mysqli_num_rows($result)>0){
		$row = mysqli_fetch_assoc($result);
		$output .= "<td>".$row['acc_holder_name']."</td><td>".$row['acc_number']."</td><td>".$row['starting_balance']."</td><td>".date('d-m-Y',strtotime($row['open_date']))."</td><td>Name:&nbsp;".$row['bank']."<br/>Branch:&nbsp;".$row['branch']."<br/>City:&nbsp;".$row['city']."</td>";
		
	}
	$output .= "</tbody></table>";
	return $output;
}

function deleteTransactions($accountId){
	global $dbc;
	$table_name = $_SESSION['username'] . "_transactions";
	$query = "DELETE FROM $table_name WHERE account = '$accountId' OR from_account = '$accountId' OR to_account = '$accountId'";
	mysqli_query($dbc,$query);	
}

function deleteAccountFromDb(){
	global $dbc;
	$table_name = $_SESSION['username'] . "_accounts";
	$accountId = mysqli_real_escape_string($dbc, trim($_POST['accountId']));
	$query = "DELETE FROM $table_name WHERE acc_id = '$accountId'";
	deleteTransactions($accountId);
	if(mysqli_query($dbc,$query)){	
    	$output = array("infocode" => "DELETESUCCESS", "message" => "Account deleted successfully.");
	} else {
		$output = array("infocode" => "DELETEFAILURE", "message" => "Account NOT deleted.");
	}
	return $output;
}


?>