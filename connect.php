<?php
$dsn='mysql:host=localhost;dbname=shop';
$user='root';
$pass='';
$option=array(
PDO::MYSQL_ATTR_INIT_COMMAND=> 'SET NAMES utf8',);
global $con;
try{
$con = new PDO($dsn,$user,$pass,$option);
$con -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


}
catch(PDOException $e){
	echo 'not connected' . $e ->getMessage();
}