<?php

function getCurrentDateTime(){
	return date('Y-m-d H:i:s');
}

function getCurrentDate(){
	return date('Y-m-d');
}

function joinResults($array, $property){
	$result = array();
	foreach ($array as $row) {
		$result[] = $row->$property;
	}
	return implode(", ", $result);
}

?>