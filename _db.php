<?php 
session_start();

if(isset($_GET['user']))
{
	$_SESSION['user_id'] = $_GET['user'];
}

$config = require(__DIR__.'/config/db.php');

try
{
	extract($config);
	$pdo = new PDO('mysql:host='. $host .';dbname=' . $name, $user, $pass, [
	  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	  PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
	]);

    
}catch(PDOException $e){

	die('Pas de connextion');
}