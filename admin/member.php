<?php
session_start();
if(isset($_SESSION['user'])){
$titel='member';
include 'init.php';}

//$do=isset($_GET['do']);
$do=$_GET['do'];

if($do=='manag'){
$q = "";
if(isset($_GET['site'])&&$_GET['site']=='pending'){
$q = "AND Regstatus =0";

}


$st =$con->prepare("SELECT* FROM users WHERE groupID!=1 $q");
$st->execute();
$rows =$st->fetchAll();




	?>

<h4 class="text-center t">This is manage page</h4><br><br>
<div class="container">
	<div class="table-responsive">
		<table class="main-table table-bordered table text-center">
			<tr class="tr">
				<td>Userid</td>
				<td>Imag</td>
				<td>Username</td>
				<td>Email</td>
				<td>Fullname</td>
				<td>Date</td>
				<td>Control</td>
			</tr>


			<?php
              foreach($rows as $row){
              	 echo '<tr>';
              	         echo '<td>' .$row['userID'] .'</td>';
              	         echo '<td><img src="../upload/imag/'.$row['imag'].'"></td>';
                         echo '<td>' .$row['username'] .'</td>';
                         echo '<td>' .$row['email'] .'</td>';
                         echo '<td>' .$row['fullname'] .'</td>';
                         echo '<td>' .$row['Date'] .'</td>';
              	         echo'<td>
					<a href="member.php?do=Edit&id=' . $row['userID'].'" ' .  'class="btn btn-primary" ><i class="fas fa-edit"></i> Edit</a>
					<a  href="member.php?do=Delete&id=' . $row['userID'].'" ' .  'class="btn btn-danger" onclick="return confirm(\'are you sure?\')"> <i class="far fa-trash-alt"></i> Delete</a>';
					if($row['Regstatus']==0){

                      echo '<a href="member.php?do=Activ&id=' . $row['userID'].'" ' .  'class="btn btn-info"><i class="far fa-lightbulb"></i> Active</a></td>';
					}
			
             echo '</tr>';

                 
//onclick="return confirm('Are you sure?')"
              }


       ?>  </table>
      </div>


 <a class="btn btn-primary"  href="member.php?do=add"> Add member </a> 
</div>





<?php
}elseif($do=='add'){

  ?>	 	
           <form class="form-member text-center" action="?do=insert" method="POST" enctype="multipart/form-data">
         
	      <h4 class="text-center">add Memeber<h4>
	    	<h6 class="control-label">user name</h6><br>
        
		<input class="form-control" type="text" name="username" required="required">
		<h6>password</h6><input class="form-control"  type="password" name="password" placeholder="enter your password" required="required">
		<h6>Email</h6>
  		<input class="form-control col-lg-offset-12" name="email" type="username" name="user" placeholder="enter your email">
<h6 class="control-label">full name</h6>
		<input class="form-control" type="text" name="fullname" placeholder="enter your username">
		<h6 class="control-label">image</h6>
		<input class="form-control" type="file" name="imag" placeholder="insert your image">
		<button class="btn btn-primary text-center"> add</button>
	</form>







<?php

}elseif($do=='Edit'){
	$userid = isset($_GET['id'])&&is_numeric($_GET['id'])?intval($_GET['id']) :0;
    $st = $con -> prepare ("SELECT * FROM users WHERE userID=?  LIMIT 1");
    $st -> execute(array($userid));
    $row=$st->fetch();
    $count= $st-> rowCount();
    //$_SESSION['id']=$row['userID'];
   
     if($count > 0){?>	 	
           <form class="form-member text-center" action="?do=update" method="POST" enctype="multipart/form-data">
         
			   <h4 class="text-center">Edit your Data</h4>
	             	<h6 class="control-label">User Name:</h6><br>
              <input type="hidden" name="userID" value="<?php echo $userid ?>" />
		          <input class="form-control" type="text" name="username" value="<?php echo $row['username'];?>">
		             <input class="form-control" value="<?Php echo $row['password'];?>" type="hidden" name="oldpass" placeholder="enter your password">
			   	<h6 class="control-label">Password :</h6>
		           <input class="form-control" value="" type="password" name="newpass" placeholder="enter your password">
		            <h6>Email</h6>
  		           <input class="form-control col-lg-offset-12" name="email" type="username" value="<?php echo $row['email'];?>"  placeholder="enter your email">
                 <h6 class="control-label">Full name:</h6>
		           <input class="form-control" type="text" name="fullname" value="<?php echo $row['fullname'];?>"  placeholder="enter your username">
                     <h6 class="control-label">Image:</h6>
		            <input class="form-control col-lg-offset-12" name="imag" type="file" value=""  placeholder="">
		            <button class="btn btn-primary text-center"> Save</button>
	       </form>
    	
          

	<?php 
            }else{
	              echo "no ID";
	          }
 }elseif($do=='insert'){

 	if($_SERVER['REQUEST_METHOD']=="POST"){

                $imagname=$_FILES['imag']['name'];
            	$imagsize=$_FILES['imag']['size'];
            	$imagtype=$_FILES['imag']['type'];
            	$imagtmp=$_FILES['imag']['tmp_name'];
            	$extensions =array("jpg","jpeg","png","gif","jfif","JPG");
		
            	$imagexp =strtolower(end(explode(".",$imagname)));

			     $user=     $_POST['username'] ;
			     $password= sha1($_POST['password']);
			     $email =    $_POST['email'];
			     $fullname=   $_POST['fullname'];
			      

			     $errors=array();
			    if(strlen($user)<4||strlen($user)>20){

			    	$errors[] ='user must be mor than4 and less than 20 carachters';
			    	
			      // echo'<div class ="alert alert-warning">you will be redirected after 6 seconds</div>';
			      
			       
			        
			    }
			     if(!empty($imagname) && !in_array($imagexp,$extensions)){

                	$errors[]= 'extension not allowed';
                }

                if(empty($imagname)){

                	$errors[]= 'image must not be empty';
                }

                if($imagsize>3000000){

                	$errors[]= 'size must not be more than 3 MB';
                }
                foreach($errors as $error){
                  echo'<div class ="alert alert-warning">'.$error.'</div>';
                  header('refresh:3;member.php?do=add');

                }
			     $imag = rand(0,1000000).'_'.$imagname;
                move_uploaded_file($imagtmp,'../upload/imag/'.$imag);
                
                
				if(empty($errors)){
				$statment = $con->prepare("SELECT username FROM users WHERE username =?");
				$statment->execute(array($user));
				$count =$statment->rowCount();

				if($count>0){
					echo'<div class ="alert alert-danger">username is already found  ..try another username please</div>';
					 header('refresh:4;member.php?do=add');
				}else{

				     $st =$con->prepare("INSERT INTO users(username,password,email,fullname,Regstatus,Date,imag)
				                        VALUES (:user,:pass,:emai,:full,1,now(),:zimag)");
				    $st->execute(array(
				 'user'=>$_POST['username'],
				 'pass'=>$password,
				'emai'=>$_POST['email'],
				'full'=>$_POST['fullname'],
				'zimag'=>$imag
				));
				echo '<div class="alert alert-success">one record inserted</div>' ;

               header('refresh:1;index.php');




}}}}
				


elseif($do=='update'){

   	
     	if($_SERVER['REQUEST_METHOD']=="POST"){

                   $imagname=$_FILES['imag']['name'];
                   $imagsize=$_FILES['imag']['size'];
                   $imagtmp=$_FILES['imag']['tmp_name'];
                   $imagtype=$_FILES['imag']['type'];
                   $extension =array("jpg","png","jfif","gif","jpeg");
                   $var =strtolower(end(explode(".",$imagname)));
                   //if(in_array($var,$extension)){


     		$id= $_POST['userID'];
				$username	= $_POST['username'];
				$email 	= $_POST['email'];
				$name 	= $_POST['fullname'];
                $password='';
				if(empty($_POST['newpass'])){
					$password=$_POST['oldpass'];
				}
			   else{
				$password=sha1($_POST['newpass']);
				}
				if(empty($imagname)){	 $rows =checkFetch("*","users","userID",$id);
                	//$errors[]= 'image must not be empty';
					foreach($rows as $row){
						$imagname=$row['imag'];}
					   $imag=$imagname;
					}else{ $imagname=$_FILES['imag']['name'];
						    $imag=rand(0,1000000).'_'.$imagname;   }
				//_____________________________________
$statment = $con->prepare("SELECT * FROM users WHERE username=? AND userID != ?");
$statment->execute(array($username,$id));
$count =$statment->rowCount();
$row=$statment->fetch();
if($count>0){
	echo'<div class ="alert alert-danger">username is already found  ..try another username please</div>';
	 header('refresh:1;index.php?do=manage'); exit();}

//_____________________

	 //$imag=rand(0,100000).'_'.$imagname;

	 move_uploaded_file($imagtmp,'../upload/imag//'.$imag);
				 $statment = $con->prepare("UPDATE users SET username = ?, email = ?, fullname = ?,password=? ,imag=? WHERE userID = ? LIMIT 1");

			   			$statment->execute(array($username, $email, $name,$password,$imag,$id));
                         
                         $count= $statment-> rowCount();
											// Echo Success Message
										echo'<div class ="alert alert-success">updated</div>';

					header('refresh:1;index.php');




					 }else{echo "sorry";}  }


     		

elseif($do=='Delete'){
	  if(isset($_GET['id'])&&is_numeric($_GET['id'])){
	  	$userid=$_GET['id'];

	  }
  $st=$con->prepare("DELETE FROM users WHERE userID= :user");
  $st->bindParam(":user",$userid);
  $st->execute();
	echo '<div class="alert alert-success">Deleted</div>';
header('refresh:1;member.php?do=manag');


}elseif($do=='Activ'){

        $userid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

				// Select All Data Depend On This ID

				
					$stmt = $con->prepare("UPDATE users SET Regstatus = 1 WHERE UserID = ?");

					$stmt->execute(array($userid));

					echo "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activated</div>';
					header('refresh:1,'.$_SERVER['HTTP_REFERER']);


	}



   	
     include $tpl."footer.php";

   

