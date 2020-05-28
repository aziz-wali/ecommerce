<?php 
session_start();
include'init.php';
if(isset($_SESSION['username'])){
	$section=filter_var($_GET['section'],FILTER_SANITIZE_STRING);
	 if(isset($_GET['id'])){$id=$_GET['id'];}

	
	if($section=='edit'){
 $rows= checkFetch('*','users','userID',$id);
		foreach($rows as $row){
 ?>
<div class="container">
	 <h4 class="text-center">Edit your data</h4>
	<div class="alert alert-primary notice">Notice : if you want to change your old password , please insert your new password in password field</div>
		<form class="form-profile text-center" action="?section=update" method= 'POST' enctype="multipart/form-data">
			<div class="row">
			   <input type="hidden" value="<?php echo $row['userID']; ?>" name="id">
			<div class="col-lg-2">
				<h4><i class="fas fa-user"></i></h4>
				</div>
			<div class="col-lg-10">
				<input class="form-control" type="username" name="username" value="<?php echo $row['username']; ?>" placeholder="enter your username">
			</div>
				<div class="col-lg-2">
				<h4><i class="fas fa-user-friends"></i></h4>
				</div>
			<div class="col-lg-10">
				<input class="form-control" type="username" name="fullname" value="<?php echo $row['fullname']; ?>" placeholder="enter your fullname">
			</div>
				<div class="col-lg-2">
				
			</div>
				<div class="col-lg-10">
					<input class="form-control" type="hidden" value="<?php echo $row['password']; ?>" name="oldpassword" placeholder="enter your password">
				</div>
				<div class="col-lg-2">
				<h4 class="bbb"><i class="fas fa-eye"></i></h4>
			</div>
					<div class="col-lg-10">
					<input class="form-control" type="password" pattern=".{4,}" title="Enter your new password if you want to change it" name="newpassword" placeholder=" Enter your New password">
					</div>
				<div class="col-lg-2">
				<h4><i class="fas fa-map-marker-alt"></i></h4>
			</div>
				<div class="col-lg-10">
					<input class="form-control" type="text" name="address" value="<?php echo $row['address']; ?>" placeholder="Enter your address">
						</div>
				<div class="col-lg-2">
				<h4 class="bbb"><i class="fas fa-envelope-open-text"></i></h4>
			</div>
					<div class="col-lg-10">
					<input class="form-control" type="email" name="email" value="<?php echo $row['email']; ?>" placeholder="enter your email">
					</div>
				<div class="col-lg-2">
				<h4 class="bbb"><i class="fas fa-camera-retro"></i></h4>
			</div>
						<div class="col-lg-10">
					<input class="form-control" type="file" name="imag" placeholder="insert your image">
						</div>
					<button class="btn btn-primary">submit</button>
</div>
				</form>
		
	</div>
	<?php	}
	}elseif($section=='update'){
		
		// if(isset($_GET['id'])){$id=$_GET['id'];}
		

				if($_SERVER['REQUEST_METHOD']=='POST'){
                $name =    filter_var($_POST['username'],FILTER_SANITIZE_STRING);
				$fullname = filter_var($_POST['fullname'],FILTER_SANITIZE_STRING);
				$address = filter_var($_POST['address'],FILTER_SANITIZE_STRING);
				$email =   filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
			   // $imag =$_POST['imag'];
				$id= $_POST['id'];
				

            	$imagname=$_FILES['imag']['name'];
            	$imagsize=$_FILES['imag']['size'];
            	$imagtype=$_FILES['imag']['type'];
            	$imagtmp=$_FILES['imag']['tmp_name'];
            	$extensions =array("jpg","jpeg","png","gif","jfif");
				if(empty($imagname)){	 $rows =checkFetch("*","users","userID",$id);
                	//$errors[]= 'image must not be empty';
					foreach($rows as $row){
						$imagname=$row['imag'];}
					   $imag=$imagname;
					}else{ $imagname=$_FILES['imag']['name'];
						    $imag=rand(0,1000000).'_'.$imagname;       }
            	$imagexp =strtolower(end(explode('.',$imagname)));
            	//-----------------------
					
					
					$password='';
					if(empty($_POST['newpassword'])){
						$password = $_POST['oldpassword'];
					}else{$password =sha1($_POST['newpassword']);}
				//--------VALiDATE ERRORS -------------------
				$errors=array();

                if(!empty($imagname)&&!in_array($imagexp,$extensions)){

                	$errors[]= 'extension not allowed';
                }

                
                if($imagsize>3000000){

                	$errors[]= 'size must not be more than 3 MB';
                }

                foreach($errors as $error){

                	echo '<div class="aler alert-danger">'.$error .'</div>';
                }
					/*if(empty($imagname)){
                $imag =$imagname;}else{
						 $rows =checkFetch("*","item","itemid",$itemid);
						foreach($rows as $row){
					$imag=	$row['imag'];}
					}*/
                move_uploaded_file($imagtmp,'upload/imag//'.$imag);

//---------------start Update------------------------------------
               if(empty($errors)){
                
					$update =$con->prepare("UPDATE users SET username=?, fullname=?, password=? ,address=?, email=?,imag=? WHERE userID=?");
					$update->execute(array($name,$fullname,$password,$address,$email,$imag,$id));
					
			if($update)	{echo '<div class="alert alert-success">updated</div>';}
 //header('refresh:3;manage.php?section=edit&id=' .$itemid);
 
 
}}
		
		
		
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}