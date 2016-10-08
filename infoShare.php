<?php
require_once "lib/nusoap.php";
require_once "infoShareAuthentication.php";
require_once "infoShareModel.php";
require_once "infoShareUtils.php";
require_once "dbConnector.php";
require_once "dataAccessor.php";
require_once "infoShareEmail.php";

function getInformations($category) {
	$dbhandle = DBConnect();
	$informations = getPublicCategoryInformationsList($dbhandle, $category);
	DBDisconnect($dbhandle);
	return $informations;
}

function getCategories() {
	$dbhandle = DBConnect();
	$categories = getCategoriesList($dbhandle);
	DBDisconnect($dbhandle);
	return $categories;
}

function addInformation($userId, $categoryName, $information){
	$dbhandle = DBConnect();
	$result = createInformation($dbhandle, $userId, $categoryName, $information, getCurrentDateTime());
	DBDisconnect($dbhandle);	
	return $result;
}

function addCategoryRequest($userId, $name){
	$dbhandle = DBConnect();
	$result = createCategoryRequest($dbhandle, $userId, $name, getCurrentDateTime());
	DBDisconnect($dbhandle);	
	return $result;
}

function register($email, $password){
	$dbhandle = DBConnect();
	$result = registerUser($dbhandle, $email, $password, getCurrentDate());
	DBDisconnect($dbhandle);	
	return $result;
}

function authenticate($email, $password){
	$dbhandle = DBConnect();
	$result = authenticateUser($dbhandle, $email, $password);
	DBDisconnect($dbhandle);	
	return $result;
}

function getUserId($email, $password){
	$dbhandle = DBConnect();
	$result = authenticate($dbhandle, $email, $password);
	if($result == AUTHENTICATION_STATUS::CONFIRMED){
		$result = getUserIdByEmail($dbhandle, $email);
	}
	DBDisconnect($dbhandle);	
	return $result;
}

function confirmUser($email){
	$dbhandle = DBConnect();
	$result = confirmUserByEmail($dbhandle, $email);
	DBDisconnect($dbhandle);	
	return $result;
}

$server = new soap_server();
$server->configureWSDL("infoShare", "urn:infoShare");

$server->wsdl->addComplexType(
	'Category',
	'complexType',
	'struct',
	'all',
	'',
	array(
	 'id'=>array('name'=>'id','type'=>'xsd:int'),
	 'name'=>array('name'=>'name','type'=>'xsd:string'))
	);
	
$server->wsdl->addComplexType('Categories','complexType','array','','SOAP-ENC:Array',
        array(),
        array(
            array(
                'ref' => 'SOAP-ENC:arrayType',
                'wsdl:arrayType' => 'tns:Category[]'
            )
        )
);
	
$server->wsdl->addComplexType(
	'Information',
	'complexType',
	'struct',
	'all',
	'',
	array(
	 'id'=>array('name'=>'id','type'=>'xsd:int'),
	 'userId'=>array('name'=>'userId','type'=>'xsd:int'),
	 'categoryId'=>array('name'=>'categoryId','type'=>'xsd:int'),
	 'information'=>array('name'=>'information','type'=>'xsd:string'),
	 'public'=>array('name'=>'public','type'=>'xsd:int'))
	);

$server->wsdl->addComplexType('Informations','complexType','array','','SOAP-ENC:Array',
	array(),
	array(
		array(
			'ref' => 'SOAP-ENC:arrayType',
			'wsdl:arrayType' => 'tns:Information[]'
		)
	)
);
	
$server->register("getInformations",
    array("category" => "xsd:string"),
    array("return" => "tns:Informations"),
    "urn:infoShare",
    "urn:infoShare#getInformations",
    "rpc",
    "encoded",
    "Get a listing of informations by category");
	
$server->register("getCategories",
    array(),
    array("return" => "tns:Categories"),
    "urn:infoShare",
    "urn:infoShare#getCategories",
    "rpc",
    "encoded",
    "Get a listing of available categories");
	
$server->register("addInformation",
    array("userId" => "xsd:string", "categoryName" => "xsd:string", "content" => "xsd:string"),
    array("return" => "xsd:boolean"),
    "urn:infoShare",
    "urn:infoShare#addInformation",
    "rpc",
    "encoded",
    "Add new information");
	
$server->register("addCategoryRequest",
    array("userId" => "xsd:string", "name" => "xsd:string"),
    array("return" => "xsd:boolean"),
    "urn:infoShare",
    "urn:infoShare#addCategoryRequest",
    "rpc",
    "encoded",
    "Request for new category");
	
$server->register("register",
    array("email" => "xsd:string", "password" => "xsd:string"),
    array("return" => "xsd:integer"),
    "urn:infoShare",
    "urn:infoShare#register",
    "rpc",
    "encoded",
    "Creating new user");
	
$server->register("authenticate",
    array("email" => "xsd:string", "password" => "xsd:string"),
    array("return" => "xsd:integer"),
    "urn:infoShare",
    "urn:infoShare#authenticate",
    "rpc",
    "encoded",
    "System authentication");
	
$server->register("confirmUser",
    array("email" => "xsd:string"),
    array("return" => "xsd:boolean"),
    "urn:infoShare",
    "urn:infoShare#confirmUser",
    "rpc",
    "encoded",
    "Activating the user");
	
	
$server->soap_defencoding = 'UTF-8';
$server->decode_utf8 = false;
$server->encode_utf8 = true;
	
if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA = file_get_contents( 'php://input' );
$server->service($HTTP_RAW_POST_DATA);

?>