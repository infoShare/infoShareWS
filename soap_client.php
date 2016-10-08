<?php
require_once "lib/nusoap.php";
$client = new nusoap_client("infoShare.wsdl", true);

function joinResults($array, $property){
	$result = array();
	foreach ($array as $row) {
		$result[] = $row[$property];
	}
	return implode(", ", $result);
}


$error = $client->getError();
if ($error) {
    echo "<h1>Constructor error</h1><pre>" . $error . "</pre>";
}

$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = false;

echo "<h1>Get Informations - Lublin</h1>";

$result = $client->call("getInformations", array("category" => "Lublin"));

if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Informations - Lublin</h2><pre>";
        echo '<span style="color:green;">'.joinResults($result, 'content').'</span>';
        echo "</pre>";
    }
}

echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";

echo "<hr/>";

echo "<h1>Get Informations - Warszawa</h1>";

$result = $client->call("getInformations", array("category" => "Warszawa"));

if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Informations - Warszawa</h2><pre>";
        echo '<span style="color:green;">'.joinResults($result, 'content').'</span>';
        echo "</pre>";
    }
}

echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";

echo "<hr/>";

echo "<h1>Get Informations - No category</h1>";

$result = $client->call("getInformations", array("category" => "No category"));

if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Informations - No category</h2><pre>";
        echo '<span style="color:green;">'.joinResults($result, 'content').'</span>';
        echo "</pre>";
    }
}

echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";

echo "<hr/>";

echo "<h1>Get Categories</h1>";

$result = $client->call("getCategories", array());

if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Categories</h2><pre>";
        echo '<span style="color:green;">'.joinResults($result, 'name').'</span>';
        echo "</pre>";
    }
}

echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";

echo "<hr/>";

echo "<h1>Add Information</h1>";

$result = $client->call("addInformation", array("userId" => "1", "categoryName" => "Lublin", "content" => "WebService Input"));

if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Add information result</h2><pre>";
        echo $result==1?"<span style='color:green;'>ADDED</span>":"<span style='color:red;'>NOT ADDED</span>";
        echo "</pre>";
    }
}

echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";

echo "<hr/>";

echo "<h1>Add Category Request</h1>";

$result = $client->call("addCategoryRequest", array("userId" => "1", "name" => "Kielce"));

if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Add Category request result</h2><pre>";
        echo $result==1?"<span style='color:green;'>ADDED</span>":"<span style='color:red;'>NOT ADDED</span>";
        echo "</pre>";
    }
}

echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";

echo "<hr/>";

echo "<h1>Authenticate without user</h1>";

$result = $client->call("authenticate", array("email" => "dummy@infoShare.com", "password" => md5("dummy")));

if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Authentication result</h2><pre>";
        if($result==0){
			echo "<span style='color:green;'>NOT REGISTERED</span>";
		}else if($result==-1){
			echo "<span style='color:red;'>WRONG CREDENTIALS</span>";
		}else if($result==-2){
			echo "<span style='color:red;'>NOT CONFIRMED</span>";
		}else{
			echo "<span style='color:red;'>AUTHENTICATED - userId = ".$result."</span>";
		}
        echo "</pre>";
    }
}

echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";

echo "<hr/>";

echo "<h1>Register user - OK</h1>";

$result = $client->call("register", array("email" => "dummy@infoShare.com", "password" => "dummy"));

if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Registration result</h2><pre>";
        if($result==0){
			echo "<span style='color:green;'>SUCCESS</span>";
		}else if($result==1){
			echo "<span style='color:red;'>ALREADY REGISTERED</span>";
		}
        echo "</pre>";
    }
}

echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";

echo "<hr/>";

echo "<h1>Register already existing email</h1>";

$result = $client->call("register", array("email" => "dummy@infoShare.com", "password" => "dummy"));

if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Registration result</h2><pre>";
        if($result==0){
			echo "<span style='color:red;'>SUCCESS</span>";
		}else if($result==1){
			echo "<span style='color:green;'>ALREADY REGISTERED</span>";
		}
        echo "</pre>";
    }
}

echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";

echo "<hr/>";

echo "<h1>Authenticate not confirmed user</h1>";

$result = $client->call("authenticate", array("email" => "dummy@infoShare.com", "password" => md5("dummy")));

if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Authentication result</h2><pre>";
        if($result==0){
			echo "<span style='color:red;'>NOT REGISTERED</span>";
		}else if($result==-1){
			echo "<span style='color:red;'>WRONG CREDENTIALS</span>";
		}else if($result==-2){
			echo "<span style='color:green;'>NOT CONFIRMED</span>";
		}else{
			echo "<span style='color:red;'>AUTHENTICATED - userId = ".$result."</span>";
		}
        echo "</pre>";
    }
}

echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";

echo "<hr/>";

echo "<h1>Confirm User</h1>";

$result = $client->call("confirmUser", array("email" => "dummy@infoShare.com"));

if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Activation result</h2><pre>";
        echo $result==1?"<span style='color:green;'>CONFIRMED</span>":"<span style='color:red;'>NOT CONFIRMED</span>";
        echo "</pre>";
    }
}

echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";

echo "<hr/>";

echo "<h1>Authenticate confirmed user</h1>";

$result = $client->call("authenticate", array("email" => "dummy@infoShare.com", "password" => md5("dummy")));

if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
       echo "<h2>Authentication result</h2><pre>";
        if($result==0){
			echo "<span style='color:red;'>NOT REGISTERED</span>";
		}else if($result==-1){
			echo "<span style='color:red;'>WRONG CREDENTIALS</span>";
		}else if($result==-2){
			echo "<span style='color:red;'>NOT CONFIRMED</span>";
		}else{
			echo "<span style='color:green;'>AUTHENTICATED - userId = ".$result."</span>";
		}
        echo "</pre>";
    }
}

echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";

echo "<hr/>";

echo "<h1>Register user - OK</h1>";

$result = $client->call("register", array("email" => "infosharead@gmail.com", "password" => "dummy"));

if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
    else {
        echo "<h2>Registration result</h2><pre>";
        if($result==0){
			echo "<span style='color:green;'>SUCCESS</span>";
		}else if($result==1){
			echo "<span style='color:red;'>ALREADY REGISTERED</span>";
		}
        echo "</pre>";
    }
}

echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";