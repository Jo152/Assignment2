<?php
namespace App\core;

class Model{
	protected static $connection;

	public function __construct(){
		
		$host = "localhost";
		$DBName = "assignment2";
		$username = "root";
		$password = "";

		self::$connection = new \PDO("mysql:host=$host;dbname=$DBName;charset=utf8;", $username, $password);
		self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	}
}
?>