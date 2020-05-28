
<?php 
session_start();
$titel ='dashboard';
if(isset($_SESSION['user'])){
	include "init.php";
	echo '<pre>';
	$url =parse_url(trim(strtolower($_SERVER['REQUEST_URI']),'/'),PHP_URL_PATH);
	//print_r(explode('/',$url,3));
//echo 'APP_PATH' ;
echo '</pre>';
?>
<div class="dashboard text-center">
	<h2>Dashboard</h2>
  <div class="container text-center">
	<div class="row">
		<div class="col-lg-3 text-center ">
			<div class="stat d1">
				<span class="sp"></span>
			<h4>Members  <i class="fas fa-users"></i></h4>
				
			<span ><a href="member.php?do=manag"><?php echo x('UserID', 'users') ;?></a></span>
		

            </div>
	    </div>

		<div class="col-lg-3 text-center">
		    <div class="stat d2">
		    	<span class="sp"></span>
					<h4>Pending Members <i class="fas fa-ban"></i></h4>
					<span><a  href="member.php?do=manag&site=pending"><?php echo check("Regstatus","users",0)  ?></a></span>
					

			</div>
        </div>
		<div class="col-lg-3 text-center ">
		    <div class="stat d3">
		    	<span class="sp"></span>
			<h4>Total Items <i class="fab fa-adversal"></i></h4>
			<span><a href="item.php?do=manag"><?php echo countItems('itemid','item');?></a></span>
			

			</div>
        </div>
		<div  class="col-lg-3 text-center ">
		    <div class="stat d4">
		    	<span class="sp"></span>
			<h4>Comments <i class="far fa-comments"></i></h4>
			<span><a href="comment.php?do=manag"><?php echo x('comment_id','comment');?></a></span>
			

            </div>
		</div>
   </div>
</div>
</div>
<div class="container">
	<div class="last">
	   <div class="row">

	 <div class="col-lg-4 text-center">
		 <h4>latest Registerd users</h4>
		 <?php
		 $action=$con -> prepare("SELECT * FROM users WHERE Regstatus=0 ");
		 $action->execute();
		 $rows =$action->fetchAll();
 	   foreach($rows as $row){
        echo '<div style=" background-color:">';
 		echo '<div class="user">'. '<img src="../upload/imag/'.$row['imag'].'">'.$row['username'].' '.'  ' .$row['Date'] .'<a href="member.php?do=Activ&id='.$row['userID'] . '" ' .  'class="btn btn-info btn-sm">Approve</a></div>';
 		 echo '</div>';
 		}?>
	 </div>
 
	
	 <div class="col-lg-4 text-center">
	 	
 	<?php //$late=latest('comment_name,date','comment','comment_id',3);
 	$output=$con -> prepare("SELECT * FROM comment WHERE approv=0 ");
		$output->execute();
		if($output->rowCount()>0){
			echo'<h4>latest  Comments</h4>';
		}else{
			echo '<h4> There Is No Pending Comments </h4>';
		}
		 $rows=$output->fetchAll();

 	foreach($rows as $row){
 		echo '<div style=" background-color:">';
 		 echo '<div class="comm">' .$row['comment_name'] .$row['date'] .'<a href="comment.php?do=approve&id='.$row['comment_id'] . '" ' .  'class="btn btn-info btn-sm">Approve</a></div>';
 		 
 		   echo '</div>';
 		}?>
	 </div>
	
<div class="col-lg-4 text-center">
	 	<h4>latest Added Items</h4>
 	<?php $late=latest('*','item','itemid',3);
 	foreach($late as $row){
 		echo '<div style=" background-color:">';
 		 echo '<div class="item">'. '<img src="../upload/imag/'.$row['imag'].'">' .$row['name'] .$row['date'] .'<a href="item.php?do=manag' . '" ' .  'class="btn btn-danger btn-sm">show</a></div>';
 		 
 		   echo '</div>';
 		}?>

   </div>
</div>

</div>


<div class="progress">
	<div class="users">
	<div style="width:26%"><span>Users</span></div>
</div>

	<div class="items">
	<div style="width:60%">
	<span>Items</span>
	</div>
</div>

	<div class="comments">
	<div style="width:80%">
	<span>Comments</span>
	</div>
</div>
	</div>
	</div>


<div class="container text-center">
	
<div class="world-item">
	<h4>World wide Items</h4>
	<div class="row">
		
<div class="col-lg-2 i">
<h6 class="germany">Germany</h6>
<?php $country=check("country","item","germany");
	echo $country;

	?>
</div>
<div class="col-lg-2 i">
<h6 class="usa">USA</h6>
<?php $country=check("country","item","usa");
	echo $country;

	?>
</div>
<div class="col-lg-2 i">
<h6 class="china">CHina</h6>
<?php $country=check("country","item","china");
	echo $country;

	?>
</div>
<div class="col-lg-2 i">
<h6 class="finland">Finland</h6>
<?php $country=check("country","item","finland");
	echo $country;

	?>
</div>
<div class="col-lg-2 i">
<h6 class="japan">Japan</h6>
<?php $country=check("country","item","japan");
	echo $country;

	?>
</div>
</div>
	<div class="world-img">
		<img src="w.png">
	</div>
</div>
</div>
<?php
	include "includes/templates/footer.php";
}else{

	header('location:index.php');
	exit();
}
?>