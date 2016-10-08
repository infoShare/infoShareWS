<?php

function DBConnect(){
	$username = "root";
	$password = "";
	$hostname = "localhost"; 
	$database = "infoshare";
	
	return mysqli_connect($hostname, $username, $password, $database);
}

function DBDisconnect($dbhandle){
	mysqli_close($dbhandle);
}

?>