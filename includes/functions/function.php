<?php
/*function setTitel(){
	 $titel;
	if(isset($titel)){
		echo $titel;
	}else{
		echo 'default';
	}
}*/
//this function used  to define the titel ,
//but now the titel defined with another way without function

//errors redirect function depends on parameters
// like error message class of this error und the Url 
 function ERR($err ,$class, $seconds=3,$url){


echo '<div class="' .$class .'" >' .$err .'</div>';
echo ' you will be redirected after ' .$seconds;
header ("refresh: $seconds;url=$url");
exit();
 }



 /* Funtion to Check  wether there is a value in database and return it*/
function check($select,$database,$value){

global $con ;
$statment = $con->prepare("SELECT $select FROM $database WHERE $select =?");
$statment->execute(array($value));
$count =$statment->rowCount();

return $count;


 }





 
 function x($item, $data){
      global $con;
	  $stx=$con->prepare("SELECT COUNT($item) FROM $data");
	  $stx->execute();
	 $y= $stx -> fetchColumn();
	 return $y;
	}








// This Function calculate the items depend on the given parameters
function countItems($item, $table) {

		global $con;

		$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

		$stmt2->execute();

		return $stmt2->fetchColumn();

	}






	function latest ($select,$data,$order,$limit){
		global $con ;
		$stat=$con -> prepare("SELECT $select FROM $data ORDER BY $order DESC LIMIT $limit");
		$stat->execute();
		 $rows=$stat->fetchAll();
	return $rows;}


//function with parameters to retrieve  elements from database
function co($item, $table) {

		global $con;

		$stmt2 = $con->prepare("SELECT $item FROM $table");

		$stmt2->execute();

		return $stmt2->fetchAll();

	}