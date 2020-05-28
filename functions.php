<?php





 /* Funtion to Check  wether there is a value in database and return it*/

function check($item,$database,$value1,$value2){

global $con;
$statment =$con->prepare("SELECT $item FROM $database WHERE $value1=?");
$statment -> execute(array($value2));
$row = $statment->fetch();
$count = $statment->rowCount();
return $count;


}
//______________________function used return  an array of elements___________________________

function checkFetch($item,$database,$value,$x){

global $con;
$statment =$con ->prepare ("SELECT $item FROM $database WHERE $value=? ");
$statment -> execute(array($x));
$rows = $statment->fetchAll();
$count = $statment->rowCount();
return $rows;


}
//_________________________


function bringimage($item,$database,$value,$value2){
	global $con;
$stmt=$con->prepare("SELECT $item FROM $database WHERE $value=?");
$stmt->execute(array($value2));
$row=$stmt->fetchAll();
return $row ;

}