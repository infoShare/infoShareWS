<html>
 <head>
  <title>InfoShare account confirmation</title>
 </head>
 <body>
 <?php 
	require_once "dbConnector.php";
	require_once "infoShareAuthentication.php";

	function confirmUser($email){
		$dbhandle = DBConnect();
		$result = confirmUserByEmail($dbhandle, $email);
		DBDisconnect($dbhandle);	
		return $result;
	};
	
	$email = $_GET["email"];
	if(confirmUser($email)){
		echo "<h3 style='color:green;'>Successfully confirmed</h3>";
	}else{
		echo "<h3 style='color:red;'>Confirmation failure</h3>";
	}
 
 ?> 
 </body>
</html>