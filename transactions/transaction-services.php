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
    case 'add_transaction':
        $finaloutput = addTransactionToDb();
        echo json_encode($finaloutput);
    break;
    case 'get_accounts':
    	//returns data in HTML format
        $finaloutput = getAccountsFromDb();
        echo $finaloutput;
    break;
    case 'get_categories':
    	//returns data in HTML format
        $finaloutput = getCategoriesFromDb();
        echo $finaloutput;
    break;
    case 'get_transactions':
    	//returns data in HTML format
        $finaloutput = getTransactionsFromDb();
        echo $finaloutput;
    break;
     case 'get_transaction_details':
    	//returns data in HTML format
        $finaloutput = getTransactionDetailsFromDb();
        echo $finaloutput;
    break;
    case 'update_transaction':
        $finaloutput = updateTransactionInDb();
        echo json_encode($finaloutput);
    break;
    case 'delete_transaction':
        $finaloutput = deleteTransactionFromDb();
        echo json_encode($finaloutput);
    break;
    default:
        $finaloutput = array("infocode" => "INVALIDACTION", "message" => "Irrelevant action");
}



function getUniqueTransactionId(){
  global $dbc;
  $table_name = $_SESSION['username'] . "_transactions";
  $curr_id = 1;
  $prefix = "TRA_";
  $query = "SELECT tra_id FROM $table_name ORDER BY created_date DESC LIMIT 1";
  $result = mysqli_query($dbc, $query);
  if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $prev_id = explode("_", $row['tra_id']);
    $curr_id = $prev_id[1] + 1;
  }
  return $prefix.$curr_id;
}

function getCategoryName($categoryId){
	global $dbc;
	$table_name = $_SESSION['username'] . "_categories";
	$query = "SELECT * FROM $table_name WHERE cat_id='$categoryId'";
	$result = mysqli_query($dbc, $query);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);
		$categoryName = $row['category_name'];
	}
	return $categoryName;
}

function getAccountInfo($accountId){
	global $dbc;
	$table_name = $_SESSION['username'] . "_accounts";
	$query = "SELECT * FROM $table_name WHERE acc_id='$accountId'";
	$result = mysqli_query($dbc, $query);
	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_assoc($result);
		$accountInfo = array("availableBalance" => $row['current_balance'], "accountName" => $row['acc_name']);
	}
	return $accountInfo;
}

function updateCurrentBalanceInDb($accountId, $remainingBalance){
	global $dbc;
	$table_name = $_SESSION['username'] . "_accounts";
	$query = "UPDATE $table_name SET current_balance='$remainingBalance' WHERE acc_id='$accountId'";
	mysqli_query($dbc, $query);
}


function addTransactionToDb(){
	global $dbc;
	$table_name = $_SESSION['username'] . "_transactions";
	$transactionId = getUniqueTransactionId();
	$payee = mysqli_real_escape_string($dbc, trim($_POST["payee"]));
	$transactionType = mysqli_real_escape_string($dbc, trim($_POST["transactionType"]));
	$amount = mysqli_real_escape_string($dbc, trim($_POST["amount"]));
	$transactionDate = mysqli_real_escape_string($dbc, trim($_POST["transactionDate"]));
	$description = mysqli_real_escape_string($dbc, trim($_POST["description"]));


	if($transactionType != 'Transfer'){
		$categoryId = mysqli_real_escape_string($dbc, trim($_POST["categoryId"]));
		$accountId = mysqli_real_escape_string($dbc, trim($_POST["accountId"]));
		$accountInfo = getAccountInfo($accountId);
		$availableBalance = $accountInfo['availableBalance'];

		switch($transactionType){
			case 'Expense':
				$remainingBalance = $availableBalance - $amount;
			break;
			case 'Income':
				$remainingBalance = $availableBalance + $amount;
			break;
		}

		$query = "INSERT INTO $table_name (tra_id, payee, transaction_type, amount, category, account, transaction_date, description, after_bal_account, created_date) VALUES ('$transactionId', '$payee', '$transactionType', '$amount','$categoryId', '$accountId', '$transactionDate', '$description', '$remainingBalance', CURRENT_TIMESTAMP())";

		if(mysqli_query($dbc, $query)){
			updateCurrentBalanceInDb($accountId, $remainingBalance);
			$output = array("infocode" => "INSERTSUCCESS", "message" => "New transaction added successfully.");
		} else {
			$output = array("infocode" => "INSERTFAILURE", "message" => "New transaction NOT added!");
		}
	} else {
		$fromAccountId = mysqli_real_escape_string($dbc, trim($_POST["fromAccountId"]));
		$toAccountId = mysqli_real_escape_string($dbc, trim($_POST["toAccountId"]));

		$fromAccountInfo = getAccountInfo($fromAccountId);
		$fromAccountAvailableBalance = $fromAccountInfo['availableBalance'];
		$toAccountInfo = getAccountInfo($toAccountId);
		$toAccountAvailableBalance = $toAccountInfo['availableBalance'];

		$fromAccountRemainingBalance = $fromAccountAvailableBalance - $amount;
		$toAccountRemainingBalance = $toAccountAvailableBalance + $amount;

		$query = "INSERT INTO $table_name (tra_id, payee, transaction_type, amount, from_account, to_account, transaction_date, description, after_bal_from_account, after_bal_to_account, created_date) VALUES ('$transactionId', '$payee', '$transactionType', '$amount','$fromAccountId', '$toAccountId', '$transactionDate', '$description', '$fromAccountRemainingBalance', '$toAccountRemainingBalance', CURRENT_TIMESTAMP())";

		if(mysqli_query($dbc, $query)){
			updateCurrentBalanceInDb($fromAccountId, $fromAccountRemainingBalance);
			updateCurrentBalanceInDb($toAccountId, $toAccountRemainingBalance);
			$output = array("infocode" => "INSERTSUCCESS", "message" => "New transaction added successfully.");
		} else {
			$output = array("infocode" => "INSERTFAILURE", "message" => "New transaction NOT added!");
		}
	}
	return $output;
}

function getAccountsFromDb(){
	global $dbc;
	$table_name = $_SESSION['username'] . "_accounts";
	$query = "SELECT * FROM $table_name";
	$result = mysqli_query($dbc,$query);
	$output = "<option value=''>Select account</option>";
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			$output .= '<option value="'.$row['acc_id'].'">'.$row['acc_name'].'</option>';
		}
	}
	return $output . "<script>selectAccount();</script>";
	//selectAccount() will be executed only in edit-transaction.php and is defined in edit-transaction.php itself
}

function getCategoriesFromDb(){
	global $dbc;
	$table_name = $_SESSION['username'] . "_categories";
	$transactionType = mysqli_real_escape_string($dbc, trim($_POST['transactionType']));
	$query = "SELECT * FROM $table_name WHERE category_type='$transactionType'";
	$result = mysqli_query($dbc,$query);
	$output = "<option value=''>Select category</option>";
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			$output .= '<option value="'.$row['cat_id'].'" >'.$row['category_name'].'</option>';
		}
	}
	return $output . "<script>selectCategory();</script>";
	//selectCategory() will be executed only in edit-transaction.php and is defined in edit-transaction.php itself
}

function getTransactionsFromDb(){
	global $dbc;
	$transactions_table_name = $_SESSION['username'] . "_transactions";
	$accounts_table_name = $_SESSION['username'] . "_accounts";
	$categories_table_name = $_SESSION['username'] . "_categories";
	$fromDate = mysqli_real_escape_string($dbc, trim($_GET["fromDate"]));
	$toDate = mysqli_real_escape_string($dbc, trim($_GET["toDate"]));
	$transactionType = mysqli_real_escape_string($dbc, trim($_GET["transactionType"]));
	
	if($transactionType !== 'Transfer'){
		$query = "SELECT * FROM $transactions_table_name,$accounts_table_name,$categories_table_name WHERE transaction_date >= '$fromDate' AND transaction_date <= '$toDate' AND transaction_type = '$transactionType' AND account=acc_id AND category=cat_id";
		$output = "<table class=\"table table-bordered\" id=\"".$transactionType."_table\">
            <thead>
              <tr>
                <th>Payee</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Category</th>
                <th>Account</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>";
    } else {
    	$query = "SELECT * FROM $transactions_table_name WHERE transaction_date >= '$fromDate' AND transaction_date <= '$toDate' AND transaction_type = '$transactionType'";
    	$output = "<table class=\"table table-bordered\" id=\"".$transactionType."_table\">
            <thead>
              <tr>
                <th>Payee</th>
                <th>Date</th>
                <th>Amount</th>
                <th>From Account</th>
                <th>To Account</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>";
    } 
    $result = mysqli_query($dbc,$query);
	if($transactionType != 'Transfer'){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$output .= '<tr>
					<td>' . $row['payee'] . '</td>
					<td>' . date('d-m-Y',strtotime($row['transaction_date'])) . '</td>
					<td>' . $row['amount'] . '</td>
					<td>' . $row['category_name'] . '</td>
					<td>' . $row['acc_name'] . '</br><span style="opacity: 0.5;">Bal. Rs. ' . $row['after_bal_account'] . '</span></td>
					<td><button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="View details"  onclick="viewDetails(\''.$row['tra_id'].'\');" ><i class="glyphicon glyphicon-new-window"></i></button> <a href="' . HOMEURL . 'transactions/edit-transaction.php?transactionId='.$row['tra_id'].'"><button class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit transaction"  type="button"><i class="glyphicon glyphicon-pencil"></i></button></a> <button class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete transaction" onclick="deleteTransaction(\''. $row['tra_id']. '\')" type="button"><i class="glyphicon glyphicon-remove"></i></button></td>
				</tr>';
			}
		} 
	} else {
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$fromAccountInfo = getAccountInfo($row['from_account']);
				$toAccountInfo = getAccountInfo($row['to_account']);
				$output .= '<tr>
					<td>' . $row['payee'] . '</td>
					<td>' . date('d-m-Y',strtotime($row['transaction_date'])) . '</td>
					<td>' . $row['amount'] . '</td>
					<td>' . $fromAccountInfo['accountName'] . '</br><span style="opacity: 0.5;">Bal. Rs. ' . $row['after_bal_from_account'] . '</span></td>
					<td>' . $toAccountInfo['accountName'] . '</br><span style="opacity: 0.5;">Bal. Rs. ' . $row['after_bal_to_account'] . '</span></td>
					<td><button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="View details"  onclick="viewDetails(\''.$row['tra_id'].'\');" ><i class="glyphicon glyphicon-new-window"></i></button> <a href="' . HOMEURL . 'transactions/edit-transaction.php?transactionId='.$row['tra_id'].'"><button class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit transaction"  type="button"><i class="glyphicon glyphicon-pencil"></i></button></a> <button class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete transaction" onclick="deleteTransaction(\''. $row['tra_id']. '\')" type="button"><i class="glyphicon glyphicon-remove"></i></button></td>
				</tr>';
			}
		}
	}
	$output .= "</tbody></table>
	 <script>$(document).ready(function(){
        $('#" . $transactionType . "_table').DataTable();
     });</script>";
	return $output;
}

function getTransactionDetailsFromDb(){
	global $dbc;
	$table_name = $_SESSION['username'] . "_transactions";
	$transactionId = mysqli_real_escape_string($dbc, trim($_POST["transactionId"]));
	$query = "SELECT * FROM $table_name WHERE tra_id='$transactionId'";
	$output = "<table class=\"table table-bordered\"><tbody>";
	$result = mysqli_query($dbc,$query);
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			$output .= "<tr><td>" . $row['description'] . "</td></tr>";
		}
	}
	return $output;
}

function revertTransaction($transactionId){
	global $dbc;
	$table_name = $_SESSION['username'] . "_transactions";
	$query = "SELECT * FROM $table_name WHERE tra_id='$transactionId'";
	$result = mysqli_query($dbc,$query);
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			if($row['transaction_type'] != 'Transfer'){
				revertAvailableBalanceForNonTransfers($row['account'], $row['amount'], $row['transaction_type']);
			} else {
				revertAvailableBalanceForTransfers($row['from_account'], $row['to_account'], $row['amount']);
			}
		}
	}
}

function getCurrentBalance($accountId){
	global $dbc;
	$table_name = $_SESSION['username'] . "_accounts";
	$query = "SELECT * FROM $table_name WHERE acc_id='$accountId'";
	$result = mysqli_query($dbc,$query);
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			$currentBalance = $row['current_balance'];
		}
	}
	return $currentBalance;
}

function revertAvailableBalanceForNonTransfers($accountId, $amount, $transactionType){
	$currentBalance = getCurrentBalance($accountId);
	if($transactionType == 'Expense'){
		$remainingBalance = $currentBalance + $amount;
	} else if($transactionType == 'Income'){
		$remainingBalance = $currentBalance - $amount;
	}
	updateCurrentBalanceInDb($accountId, $remainingBalance);
}


function revertAvailableBalanceForTransfers($fromAccountId, $toAccountId, $amount){
	$fromAccountCurrentBalance = getCurrentBalance($fromAccountId);
	$toAccountCurrentBalance = getCurrentBalance($toAccountId);
	
	$fromAccountRemainingBalance = $fromAccountCurrentBalance + $amount;
	$toAccountRemainingBalance = $toAccountCurrentBalance - $amount;
	
	updateCurrentBalanceInDb($fromAccountId, $fromAccountRemainingBalance);
	updateCurrentBalanceInDb($toAccountId, $toAccountRemainingBalance);
}

function updateTransactionInDb(){
	global $dbc;
	$table_name = $_SESSION['username'] . "_transactions";
	$transactionId = mysqli_real_escape_string($dbc, trim($_POST["transactionId"]));
	$payee = mysqli_real_escape_string($dbc, trim($_POST["payee"]));
	$transactionType = mysqli_real_escape_string($dbc, trim($_POST["transactionType"]));
	$amount = mysqli_real_escape_string($dbc, trim($_POST["amount"]));
	$transactionDate = mysqli_real_escape_string($dbc, trim($_POST["transactionDate"]));
	$description = mysqli_real_escape_string($dbc, trim($_POST["description"]));
	
	revertTransaction($transactionId);

	if($transactionType != 'Transfer'){
		$categoryId = mysqli_real_escape_string($dbc, trim($_POST["categoryId"]));
		$accountId = mysqli_real_escape_string($dbc, trim($_POST["accountId"]));
		$accountInfo = getAccountInfo($accountId);
		$availableBalance = $accountInfo['availableBalance'];

		switch($transactionType){
			case 'Expense':
				$remainingBalance = $availableBalance - $amount;
			break;
			case 'Income':
				$remainingBalance = $availableBalance + $amount;
			break;
		}

		$query = "UPDATE $table_name SET payee='$payee', transaction_type='$transactionType', amount='$amount', category='$categoryId', account='$accountId', transaction_date='$transactionDate', description='$description', after_bal_account='$remainingBalance' WHERE tra_id='$transactionId'";

		if(mysqli_query($dbc, $query)){
			updateCurrentBalanceInDb($accountId, $remainingBalance);
			$output = array("infocode" => "UPDATESUCCESS", "message" => "Transaction updated successfully.");
		} else {
			$output = array("infocode" => "UPDATEFAILURE", "message" => "Transaction NOT updated!");
		}
	} else {
		$fromAccountId = mysqli_real_escape_string($dbc, trim($_POST["fromAccountId"]));
		$toAccountId = mysqli_real_escape_string($dbc, trim($_POST["toAccountId"]));

		$fromAccountInfo = getAccountInfo($fromAccountId);
		$fromAccountAvailableBalance = $fromAccountInfo['availableBalance'];
		$toAccountInfo = getAccountInfo($toAccountId);
		$toAccountAvailableBalance = $toAccountInfo['availableBalance'];

		$fromAccountRemainingBalance = $fromAccountAvailableBalance - $amount;
		$toAccountRemainingBalance = $toAccountAvailableBalance + $amount;

		$query = "UPDATE $table_name SET payee='$payee', transaction_type='$transactionType', amount='$amount', from_account='$fromAccountId', to_account='$toAccountId', transaction_date='$transactionDate', description='$description', after_bal_from_account='$fromAccountRemainingBalance', after_bal_to_account='$toAccountRemainingBalance' WHERE tra_id='$transactionId'";

		if(mysqli_query($dbc, $query)){
			updateCurrentBalanceInDb($fromAccountId, $fromAccountRemainingBalance);
			updateCurrentBalanceInDb($toAccountId, $toAccountRemainingBalance);
			$output = array("infocode" => "UPDATESUCCESS", "message" => "Transaction updated successfully.");
		} else {
			$output = array("infocode" => "UPDATEFAILURE", "message" => "Transaction NOT updated!");
		}
	}
	return $output;
}

function deleteTransactionFromDb(){
	global $dbc;
	$table_name = $_SESSION['username'] . "_transactions";
	$transactionId = mysqli_real_escape_string($dbc, trim($_POST['transactionId']));
	$query = "DELETE FROM $table_name WHERE tra_id = '$transactionId'";
	revertTransaction($transactionId);
    if(mysqli_query($dbc,$query)){	
    	$output = array("infocode" => "DELETESUCCESS", "message" => "Transaction deleted successfully.");
	} else {
		$output = array("infocode" => "DELETEFAILURE", "message" => "Transaction NOT deleted.");
	}
    return $output;
}


?>