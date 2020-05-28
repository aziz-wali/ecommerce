<?php
session_start();

$titel=$_GET['pagename'];

 include "init.php";

 include 'includes/templates/navbar.php';
 ?>

       <a href="pay.php?do=manage">
           <i class="fas fa-cart-plus fa-2x">
              <span>
                
                  <?php

                    // Fetch The  Number of Items in Cart

                   if(isset($_SESSION['username'])){$total_orders=0;
            		   $infos= checkFetch('quantity','orders','user_ID',$_SESSION['i']);
            	     foreach($infos as $info){
            	      $orders= $info['quantity'];
            		      $total_orders =$orders +$total_orders;
            		       } echo $total_orders; }?>
      	      </span>
           </i>
        </a>
    <div class="container">
    
<?php     
  //array of allowed Categories

    $names =array("sport","TVs","Mobile","electronic","haushalt","Allitem");

  //-----------check if the Category found in array --------
    if(in_array($_GET['pagename'],$names))
      {
        echo '<h2 class="text-center pagename">'.$_GET['pagename'].'</h2>';?>
	<?php
  //echo'<a class="btn btn-primary" href="add.php">Add item</a>';


     //------------select all items of this category according to approve status =1 (approved )
  
       $st = $con->prepare("SELECT item.*,users.username FROM item INNER JOIN users ON users.userID=item.member_id WHERE cat_id =? AND approve=1");

       $st->execute(array($_GET['id']));

       $rows =$st->fetchAll();
									   
        echo '<div class="row">';
        
       foreach($rows as $row ){

       echo '<div class="col-lg-3">';
		   echo '<div class=" cats">';	
        echo'<span class="price">'. $row['price'].'</span>';
       echo '<div class="thumbnail">';
 
       echo '<img class="img-responsive" src="upload/imag/'.$row["imag"].'">';
     
       	echo'<h3><a href="items.php?itemid='.$row['itemid'].'">'. $row['name'].'</a>'.'</h3>';
       	echo '<span class="span"><i class="fas fa-user-plus"></i> Added By: </span><a href="profile2.php?id='. $row['member_id'] .'">'. $row['username'].'</a><br>';
		   	echo '<span class="span"><i class="far fa-calendar-alt"></i> Added On:'.$row['date'] .'</span>';
       	echo'</div>';
       
       	echo'</div>';
       	echo '</div>';
       }
 



     }else
     {
      echo'category is not found';
      }
//------------select all items of this category according to approve status 

     $st = $con->prepare("SELECT * FROM item WHERE cat_id =? AND approve=0");
       $st->execute(array($_GET['id']));
       $rows =$st->fetchAll();
       foreach($rows as $row ){

       echo '<div class="col-lg-3">';
       echo'<span class="price">'. $row['price'].'</span>';
       echo'<span class="waiting">waiting approval</span>';
       echo '<div class="thumbnail">';

       echo '<img class="img-responsive" src="upload/imag/'.$row["imag"].'">';
        echo'<h3><a href="items.php?itemid='.$row['itemid'].'">'. $row['name'].'</a>'.'</h3>';
        echo'<h6>'. $row['description'].'</h6>';
        echo'</div>';
        echo'</div>';}
        


?></div></div>
<?php include "admin/includes/templates/footer.php";?>