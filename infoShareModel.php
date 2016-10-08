<?php

class User {
	public $id;
	public $email;
	public $password;
	public $registrationDate;
	public $confirmed;
}

class Category {
	public $id;
	public $userId;
	public $name;
	public $creationDate;
}

class Information {
	public $id;
	public $userId;
	public $categoryId;
	public $content;
	public $creationDate;
	public $public;

}

class CategoryRequest {
	public $id;
	public $userId;
	public $name;
	public $creationDate;
}


?>