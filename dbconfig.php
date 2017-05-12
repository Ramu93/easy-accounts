<?php
///if(!defined('TIMEZONE'))
	//define('TIMEZONE', 'America/Toronto');
if(!defined('HOMERURL'))
	define('HOMEURL', 'http://localhost:8888/easy-accounts/');

//date_default_timezone_set(TIMEZONE);
// This file establishes a connection to MySQL 
// and selects the database.

//Set the configuration of your MySQL server
$db_servername = 'localhost';
$db_username = 'root';
$db_password = 'root';
$db_name = 'easy_accounts';

// Connect to MySQL:
$dbc = mysqli_connect ($db_servername,$db_username,$db_password,$db_name);

// Confirm the connection and select the database:

if (mysqli_connect_errno()) {
    echo "Could not establish database connection!<br>";
    exit();
}

?>
