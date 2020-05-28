<?php
session_start();

$title='All items';

 include "init.php";
 //echo phpversion();?>
 <div class="colors">
   <a href="pay.php?do=manage">
   	<i class="fas fa-cart-plus fa-2x">
   		<span>
	

				<?php  //Fetch The Data TO Calculate The Total Number of Orders in Cart
				
				if(isset($_SESSION['username'])){ $total_orders=0;

					$infos= checkFetch('quantity','orders','user_ID',$_SESSION['i']);

				foreach($infos as $info)
				{

				$orders= $info['quantity'];

					$total_orders =$orders +$total_orders;

					} 
				      echo $total_orders;

	           }?>
		  	
		    </span>
		</i>
	</a>
	 
		  <ul>
			  <li data-color="default"></li>
			  <li data-color="red"></li>
			  <li data-color="blue"></li>
			  <li data-color="green"></li>
			  <li data-color="black"></li>
			  <li data-color="yellow"></li>
		  </ul>
		   
 <?php if(isset($_SESSION['username'])){?> <!-- Check if there is a session -->

   <div class="nav-item dropdown login"> <!-- start login -->

		   <a class="nav-link dropdown-toggle user" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img src="<?php 
		
		//we used this function to return the Session data 

		  $infos=checkFetch("*","users","username",$_SESSION['username']);
		  
	      foreach($infos as $info){

	      echo "upload/imag/".$info['imag'];}
	  
		  ?>" >
		
	  <?php  echo'<b>' .$_SESSION['username'].'</b>';
	      $checkUser =$con->prepare("SELECT userID FROM users WHERE groupID=1");
          $checkUser->execute();
          $count = $checkUser->fetch();
	   ?>
	  
    </a>
       <div class="dropdown-menu user-dropdown" aria-labelledby="navbarDropdown">

       	   <?php if($count['userID']==$_SESSION['i']){?>
       	    <a class="dropdown-item" href="admin/dash.php">Dashboard</a>
       	<?php } ?>
              <a class="dropdown-item" href="profile.php">My profile</a>
              <a class="dropdown-item" href="add.php">Add item</a>
              <a class="dropdown-item" href="pay.php?do=manage">My orders</a>
              <a class="dropdown-item" href="members.php?section=edit&id=<?php echo $info['userID']; ?>">Edit</a>
              <a class="dropdown-item" href="logoutuser.php">log out</a>
        </div>
  
	 
<?php }else{?>
     <div class="buttons">
        <a class="btn btn-success btn-sm" href="login.php?do=signin" >Login </a>
        <a href="login.php?do=signup">sign up?</a></h6>

    </div>
	<?php } ?>
  </div>
</div>
<?php include 'includes/templates/navbar.php'; ?>
<!-- start search Form section -->
<div class="gallery">
		<form class="search-form" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">

			<input type="text" class="form-control" name="search" placeholder=" Search For Somthing here" >

			<input type="submit" value="Search" class="btn btn-primary btn-sm">

		</form>

    <div class="search-result">

		   <?php if($_SERVER['REQUEST_METHOD'] ='POST'){

		  

			if(!empty($_POST['search'])){
			
				$search =	filter_var($_POST['search'],FILTER_SANITIZE_STRING);

		       $output = $con -> prepare("SELECT name,itemid FROM item WHERE name LIKE :LL ");

		       $output->bindValue('LL','%'.$search.'%');

			   $output->execute();

			  $items =$output->fetchAll();

			foreach($items as $item ){

				echo '<a href="items.php?itemid='.$item['itemid'].'">'.$item['name'] .'</a><br>';
			
			}
		          }

		} ?></div>



	  
		  <img class="active" src="layout/imgs/home-office-5114128_960_720.webp">
		  <img src="layout/imgs/couture-5117020_960_720.webp">
		  <img src="layout/imgs/money-2696229_960_720.webp">
		  <img src="layout/imgs/ma.jpg">
		  <div class="pagination">
			 <ul>
				 <li class="active" data-number="1">1</li>
				 <li data-number="2">2</li>
				 <li data-number="3">3</li>
				 <li data-number="4">4</li>
			 </ul>
		  </div>
</div>
		  <div class="container">
		    
                <div class="row">

	<?php

	 //echo ' your ID is '.$_GET['id'];
	 
	 // Fetch the items with the related users According to approve status =0(waitring approval from admin)

   $st = $con->prepare("SELECT item.*,users.username FROM item INNER JOIN users ON users.userID=item.member_id WHERE approve=0");

	   $st->execute();
	   
	   $rows =$st->fetchAll();
	   
       foreach($rows as $row ){

	   echo '<div class="col-lg-3">';
	   
	   echo '<div class=" cats">';	

	   echo'<span class="price">'. $row['price'].'</span>';
	   
	   echo'<span class="waiting">waiting approval</span>';
	   
       echo '<div class="thumbnail">';

	   echo '<img class="img-responsive" src="upload/imag/'.$row["imag"].'">';
	   
       echo'<h3><a href="items.php?itemid='.$row['itemid'].'">'. $row['name'].'</a>'.'</h3>';
		    
	   echo '<span class="span"><i class="fas fa-user-plus"></i> Added By: </span><a href="profile2.php?id='. $row['member_id'] .'">'. $row['username'].'</a><br>';
	   
	   echo '<span class="span"><i class="far fa-calendar-alt"></i> Added On: '.$row['date'] .'</span>';
		echo'</div>';
		
		echo'</div>';
		
		   echo'</div>';

        
       }

        // Fetch the items with the related users According to approve status==1 (admin gived a permission )

	   $st = $con->prepare("SELECT item.*,users.username FROM item  INNER JOIN users ON users.userID=item.member_id WHERE approve=1");
	   
	   $st->execute();
	   
	   $rows =$st->fetchAll();
	   
       foreach($rows as $row ){

 echo '<div class="col-lg-3">';
	   
	echo '<div class=" cats">';

	    echo'<span class="price">'. $row['price'].'</span>';
	   
       echo '<div class="thumbnail">';

				   echo '<img class="img-responsive" src="upload/imag/'.$row["imag"].'">';
				   
			       	echo'<h3><a href="items.php?itemid='.$row['itemid'].'">'. $row['name'].'</a>'.'</h3>';
					   
				   echo '<span class="span"><i class="fas fa-user-plus"></i> Added By: </span><a href="profile2.php?id='. $row['member_id'] .'">'. $row['username'].'</a><br>';
				   
					echo '<span class="span"><i class="far fa-calendar-alt"></i> Added On: '.$row['date'] .'</span>';

		  echo'</div>';
		   
	 echo'</div>';
		   
 echo'</div>';
		  
       	//echo '</div>';
       }
//------------------------
      

?></div></div>
<div class="popup">

  <div class="inner">
  	<div class="spinner-border text-primary" role="status">
  <span class="sr-only">Loading...</span>
   </div>
   <p>  often the first stop in any user’s journey through a website or blog.
            If your visitors aren’t impressed, you can expect them to leave without reading your awesome content or completing
  </p> 
            <button>Close</button>
    
  </div>
</div>
<?php include "includes/templates/footer.php" ;?>