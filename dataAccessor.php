<?php

function getCategoriesList($dbhandle){
	$sql = "SELECT * FROM categories";
	$result = mysqli_query($dbhandle, $sql) or die(mysqli_error());
	$data = array();
	while ($row = mysqli_fetch_object($result, "Category")) {
			$data[] = $row;
	}
	return $data;
}

function getPublicCategoryInformationsList($dbhandle, $categoryName){
	$categoryId = getCategoryIdByName($dbhandle, $categoryName);
	$sql = "SELECT i.id, i.userId, i.categoryId, i.content, i.creationDate, i.public, u.email FROM informations i INNER JOIN users u on i.userId = u.id WHERE i.categoryId = '".$categoryId."' AND i.public = 1";
	$result = mysqli_query($dbhandle, $sql) or die(mysqli_error());
	
	$data = array();
	while ($row = mysqli_fetch_object($result, "Information")) {
			$data[] = $row;
	}
	return $data;
}

function getCategoryIdByName($dbhandle, $categoryName){
	$sql = "SELECT id FROM categories WHERE name = '".$categoryName."' limit 1";
	$result = mysqli_query($dbhandle, $sql) or die(mysqli_error());
	$row = mysqli_fetch_row($result);
	return $row[0];
}

function getPrivateCategoryInformationsList($dbhandle, $categoryName){
	$categoryId = getCategoryIdByName($dbhandle, $categoryName);
	$sql = "SELECT * FROM informations WHERE categoryId = '".$categoryId."' AND public = 0";
	$result = mysqli_query($dbhandle, $sql) or die(mysqli_error());
	
	$data = array();
	while ($row = mysqli_fetch_object($result, "Information")) {
			$data[] = $row;
	}
	return $data;
}

function createInformation($dbhandle, $userId, $categoryName, $content, $date){
	$categoryId = getCategoryIdByName($dbhandle, $categoryName);
	$sql = "INSERT INTO informations (userId, categoryId, content, creationDate) VALUES ('".$userId."','".$categoryId."','".$content."','".$date."')";
	return mysqli_query($dbhandle, $sql);
}

function createCategoryRequest($dbhandle, $userId, $name, $date){
	$sql = "INSERT INTO categories_requests (userId, name, creationDate) VALUES ('".$userId."','".$name."','".$date."')";
	return mysqli_query($dbhandle, $sql);
}

?>