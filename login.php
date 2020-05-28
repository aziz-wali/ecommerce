<?php 
session_start();
$titel='login';
if(isset($_SESSION['username'])){
	header('location:index.php');
}
include "init.php";

if(isset($_GET['do'])){
					$do =$_GET['do'];}
					
if($_SERVER['REQUEST_METHOD']=='POST'){


			
  if($do=='login'){
				$username=$_POST['username'];
				$password=$_POST['password'];
				$hpassword=sha1($password);
				$st=$con->prepare("SELECT username, password,userID FROM users WHERE username=? AND password=?");
				$st->execute(array($username,$hpassword));
				$c=$st->fetch();
				$row=$st->rowCount();
				if($row>0){
					$_SESSION['username']=$username;
					$_SESSION['i']=$c['userID'];

					header('location:index.php');
				}else{ echo 'sorry user or password not exist!!!!' .'<a href="login.php?do=signup"> Sign Up?</a>';
				exit();}

				
		}elseif($do=='signup1'){	

            	$imagname=$_FILES['imag']['name'];
            	$imagsize=$_FILES['imag']['size'];
            	$imagtype=$_FILES['imag']['type'];
            	$imagtmp=$_FILES['imag']['tmp_name'];
            	$extensions =array("jpg","jpeg","png","gif","jfif","JPG");
            	$imagexp =strtolower(end(explode(".",$imagname)));
	           
				$username=$_POST['username'];
				$password=$_POST['password'];
				$password2=$_POST['password2'];
				$email=$_POST['email'];
	            $address=$_POST['address'];





				$errors= array();
				if($username>=4){
					$errors[]='sorry user name must be more than 4 letters'.'<br>';
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



				if(empty($password)||empty($password2)){
					$errors[]='sorry password must not be empty'.'<br>';
				}
				if(sha1($password)!==sha1($password2)){
					$errors[]='sorry passwords  not match'.'<br>';
				}
				if(empty($email)){
					$errors[]='sorry email must not be empty'.'<br>';
				}


                $imag = rand(0,1000000).'_'.$imagname;
                move_uploaded_file($imagtmp,'upload/imag//'.$imag);


				if(empty($errors)){
					$user=check('username', 'users','username',$username);
				   if($user>0){
				   	echo 'sorry username is exist'.'<br>';
				   }else{

				   $adduser = $con-> prepare("INSERT INTO users (username ,password,address,email,Date,imag)
				   	VALUES (:zusername,:zpassword,:zaddress,:zemail,now(),:zimag)");
				   $adduser->execute(array(
				   ':zusername'=> $username,
				   ':zpassword' => sha1($password),
					   ':zaddress' => $address,
				    ':zemail' => $email,
				    ':zimag'=> $imag

				     ));

				   echo "<div class='alert alert-success'>welcom</div>";
                    $st=$con->prepare("SELECT username, password,userID FROM users WHERE username=?");
				    $st->execute(array($username));
				    $c=$st->fetch();

				    $_SESSION['username'] =$username;
				    $_SESSION['i']       =$c['userID'];

				header('location:index.php');}
					}else{
				foreach($errors as $error){


					echo $error;
				                        }
			             }


					}//end if do ==signup



				} // end request method 

			
if($do=='signin'){?>
			      <form class="form text-center" action="<?php echo $_SERVER['PHP_SELF'].'?do=login'; ?>" method= 'POST'>
				    <h4 class="text-center">Login site<h4>
					<input class="form-control" type="username" name="username" placeholder="enter your username" autocomplete="off">
					<input class="form-control" type="password" name="password" placeholder="enter your password">
					<button class="btn btn-primary">submit</button>

				</form>
	<?php }
elseif($do=='signup'){  ?>

			 <form class="form text-center" action="<?php echo $_SERVER['PHP_SELF'] .'?do=signup1'; ?>" method= 'POST' enctype="multipart/form-data">
				<h4 class="text-center">Login site<h4>
					<input class="form-control" type="username" name="username" placeholder="enter your username">
					<input class="form-control" type="password" name="password" placeholder="enter your password">
					<input class="form-control" type="password" name="password2" placeholder=" Repeat your password">
					<input class="form-control" type="text" name="address" placeholder="Enter your address">
					<input class="form-control" type="email" name="email" placeholder="enter your email">
					<input class="form-control" type="file" name="imag" placeholder="insert your image">
					<button class="btn btn-primary">submit</button>

</form>
<?php  } include "admin/includes/templates/footer.php";?>