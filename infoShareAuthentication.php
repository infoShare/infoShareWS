<?php

abstract class AUTHENTICATION_STATUS
{
    const NOT_REGISTERED = 0;
	const WRONG_CREDENTIALS = -1;
	const NOT_CONFIRMED = -2;
}

abstract class REGISTRATION_STATUS
{
    const SUCCESS = 0;
	const ALREADY_REGISTERED = 1;
}

function authenticateUser($dbhandle, $email, $password){
	if(getUserByEmail($dbhandle, $email) == null){
		return AUTHENTICATION_STATUS::NOT_REGISTERED;
	}
	$sql = "SELECT * FROM users WHERE email = '".$email."' AND password = '".$password."' limit 1";
	$query = mysqli_query($dbhandle, $sql) or die(mysqli_error());
	$user = mysqli_fetch_object($query);
	if($user == null){
		return AUTHENTICATION_STATUS::WRONG_CREDENTIALS;
	}else if($user->confirmed){
		return $user->id;
	}else{
		return AUTHENTICATION_STATUS::NOT_CONFIRMED;
	}
}

function registerUser($dbhandle, $email, $password, $date){
	if(getUserByEmail($dbhandle, $email) != null){
		return REGISTRATION_STATUS::ALREADY_REGISTERED;
	}
	$hash = hashPassword($password);
	$sql = "INSERT INTO users (email, password, registrationDate) VALUES ('".$email."','".$hash."','".$date."')";
	mysqli_query($dbhandle, $sql) or die(mysqli_error());
	sendEmail($email);
	return REGISTRATION_STATUS::SUCCESS;
}

function getUserByEmail($dbhandle, $email){
	$sql = "SELECT * FROM users WHERE email = '".$email."' limit 1";
	$query = mysqli_query($dbhandle, $sql) or die(mysqli_error());
	return mysqli_fetch_object($query);
}

function confirmUserByEmail($dbhandle, $email){
	$sql = "UPDATE users SET confirmed=1 WHERE email ='".$email."'";
	return mysqli_query($dbhandle, $sql) or die(mysqli_error());
}

function hashPassword($password){
	return md5($password);
}


?>