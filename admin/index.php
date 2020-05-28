<?php
session_start();
error_reporting(0);
$Nonavbar ="";
$titel='login';
if(!isset($Nonavbar)){
	include $tpl."navbar.php";
}
if(isset($_SESSION['user'])){
	header ("location:dash.php");
}else{

}
include "connect.php";
include "includes/templates/header.php";

//include "includes/templates/Navbar.php";
if($_SERVER['REQUEST_METHOD']=='POST'){
	$user =$_POST['user'];
	$pass= $_POST['pass'];
	$hashpass = sha1($pass);
	//echo $user .' ' . $pass;
$st = $con -> prepare ("SELECT username,password,userID FROM users WHERE username=? AND password=? AND groupID=1 LIMIT 1");
$st -> execute(array($user,$hashpass));
$count= $st-> rowCount();
$row =$st->fetch();
if($count > 0){

    $_SESSION['user']=$user;
   $_SESSION['id']= $row['userID'];
   header ("location:dash.php");
   exit();

}


}

?>

<form class="form text-center" action="<?php echo $_SERVER['PHP_SELF']; ?>" method= 'POST'>
	<h4 class="text-center">Login<h4>
		<input class="form-control" type="username" name="user" placeholder="enter your username" autocomplete="off">
		<input class="form-control" type="password" name="pass" placeholder="enter your password">
		<button class="btn btn-primary">submit</button>
	</form>
<?php include "includes/templates/footer.php";?>