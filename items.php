<?php
session_start();
$title='Items';
include "init.php";
include 'includes/templates/navbar.php';
 
 error_reporting(1);

 ?>
<a href="pay.php?do=manage">
	<i class="fas fa-cart-plus fa-2x"> 
				<span><?php
					$total_orders=0;
					$infos= checkFetch('quantity','orders','user_ID',$_SESSION['i']);
				    foreach($infos as $info)
				    {

				    $orders= $info['quantity'];
					$total_orders =$orders +$total_orders;
					} 
					echo $total_orders;
				?> 
			</span>
    </i>
</a>
<div class="container">
<?php

			if(isset($_GET['itemid'])&&is_numeric($_GET['itemid']))
			{
			$itemid =intval($_GET['itemid']);
		    }
			$st=$con->prepare("SELECT item.*,users.username,categories.cat_name  FROM item  INNER JOIN users ON users.userID = item.member_id INNER JOIN categories ON categories.ID= item.cat_id
			   WHERE itemid=? ");
			$st->execute(array($itemid));
			$info= $st->fetch();
			echo '<h3 class="text-center titel">' .$info['name'].'</h3><br><br>';

			if($info['approve']==0)
			{

			  echo '<div class="alert alert-danger">sorry this item waiting approval from admin..</div>';
			  header('refresh:3;index.php');
			}else{?>
  <div class="panel panel-primary">
     <div class="panel-heading">More Infos</div>
	      <div class="panel-body">
              <div class="row">


	             <div class="col-lg-6">

							<?php	echo '<ul class="list-unstyled">';
							        echo '<li><span class="span"><i class="far fa-user"></i> Item name</span>:&#160 &#160 <b>' .$info['name'].'</b></li>';
						            echo '<li><span class="span"><i class="fas fa-map-marker-alt"></i> made In :</span>&#160 &#160 <b>'   .$info['country'].'</b></li>';
						            echo' <li><span class="span"><i class="far fa-calendar-alt"></i> Date :</span>&#160 &#160 &#160 &#160 <b>'.$info['date'].'</b></li>';
							        echo '<li><span class="span"><i class="fas fa-euro-sign"></i> Price :</span>&#160 &#160 &#160 &#160 <b>'.$info['price'].'</b></li>';
						            echo '<li> <span class="span"><i class="fas fa-user-plus"></i> Added By :</span><b><a href="profile2.php?id='. $info['member_id'] .'">'. $info['username'].'</a></b></li>';
							
							       echo '<li><span class="span"><i class="fab fa-buffer"></i> Category : </span><b>'.$info['cat_name'].'</b></li>';
							      if(empty($info['description'])){
								  echo '<li><span class="span"><i class="fas fa-info-circle"></i> description :</span>&#160 &#160 <b>there is no description</b></li>';
							       }else{
							       echo '<li><span class="span"><i class="fas fa-info-circle"></i> description :</span>&#160 &#160 <b>'.$info['description'].'</b></li>';}
						             //&id=<?php echo $info['itemid']; 
						             
						           echo '</ul>';?>

  
               </div>

               <div class="col-lg-6">
							<?php
						    $check_orders=$con-> prepare("SELECT * FROM orders WHERE user_ID=? AND item_id=?");
							  $check_orders->execute(array($_SESSION['i'],$itemid));
							  $data =$check_orders->fetch();
							  $counter = $check_orders->rowCount();
							  if( $counter>1){
									echo '<div class="in-cart">'.$counter.' Article was added to cart</div>';
								}else{
							 
										if($data['quantity']>0)
										{
											echo '<div class="in-cart">'.$data['quantity'].' Article was added to cart</div>';
										}
							        }
	  
	                        ?>

					    <div class="panel-body ">

					      <img src="<?php echo 'upload/imag/'.$info['imag'];?>">

					      <h6>Item location:</h6>
                         St. Louis, Missouri, United States
				         <h6>Ships to:</h6> 
						   United States and many other countries | See details
						   <h6>Delivery:</h6>
						   Estimated between Fri. Jun. 17 and Mon. Jun. 27  Includes international
						
						    <div class="buy-images">
							<span>Payments:</span>
						    <img src="layout/imgs/paypal.png">
						    <img src="layout/imgs/visa.png">
				           <img src="layout/imgs/master.png">
				          </div>
						</p>
					
					
					   <a class="btn btn-success"  href="pay.php?do=buy&a=s&id=<?php echo $info['itemid']; ?>" value="Buy Now">Buy It Now</a><br>
						<a class="btn btn-primary"  id="cart" href="pay.php?do=setnumber&id=<?php echo $info['itemid']; ?>" style="background-color:#4a9ef7" value="Buy Now">Add to Cart</a>
					</div>
	
  </div> 
<?php if(isset($_SESSION['username'])){

	if($_SESSION['i']==$info['member_id'])
		{?>
		      <div class="button">
		     <a  href="manage.php?section=edit&id=<?php echo $info['itemid']; ?>"  class="btn btn-primary btn-sm" style="margin-left:30px;">edit</a>
		     <a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')" href="manage.php?section=delete&id=<?php echo $info['itemid']; ?>"; >delete</a> <?php 
        }  
                             }//end check if theres  a session  
	    ?>
		</div> 
   <hr class="separator">
</div>
</div> <!---end row -->


</div><!--end container -->

  

  <div class="container panel">
			 <div class="comment">
			    <form action="<?php echo $_SERVER['PHP_SELF'].'?itemid='.$info['itemid'];?>" method="POST">
					<textarea class="textarea" type="text" name="text"></textarea>
			    <input class="btn btn-primary" type="submit" value="comment">
			   </form>
 

			 <?php 
			 if($_SERVER['REQUEST_METHOD']=='POST'){$text =$_POST['text']; 

			if(empty($text)){
			  echo '<div class="alert alert-danger pull-left">write a comment please</div>';
			}else{
			   if(isset($_SESSION['username'])){
			  $st =$con->prepare("INSERT INTO comment(comment_name ,date,user_id,item_id) values(:zcomment,now(),:zuserid,:zitem)");
			  $st->execute(array(
			    ':zcomment' => $text,
			    ':zuserid' =>$_SESSION['i'],
			    ':zitem'  => $info['itemid']

    


            ));


        if($st){
        echo '<div class="alert alert-success">Comment added</div>';
        }?>
	   <script>
			    if( window.history.replaceState ) {
			        window.history.replaceState( null, null, window.location.href );
                                      }
      </script>

<?php echo '</div>'; //end comment div 
   echo '</div>'; // end container div

              }//end check  session 


     }// end else

}

$statment =$con ->prepare ("SELECT * FROM comment WHERE approv=1 AND item_id=?");
$statment -> execute(array($itemid));
$count = $statment->rowCount();
echo'<div class="container panel">';
echo '<div class="row">';
if($count>0){?>
  
  <div class="col-lg-2">
   <h6> username</h6>
  </div>
  <div class="col-lg-5">
   <h6> comment</h6>
  </div>
  <div class="col-lg-2">
  <h6> Date</h6>
  </div>
	   <div class="manage col-lg-3">
  <h6> manage</h6>
  </div>

  <?php 
$st=$con->prepare("SELECT comment.*,users.*,item.itemid FROM comment INNER JOIN users ON users.userID = comment.user_id 
  INNER JOIN item ON item.itemid=comment.item_id
 WHERE approv=1 and itemid=? ");

  //$st= $con->prepare("SELECT * FROM comment");
$st->execute(array($itemid));
$rows= $st->fetchAll();
echo '<div class="container">';
	
	
foreach($rows as $row){
	echo '<div class="comments">';
	echo '<div class="row">';
	
    echo '<div class="col-lg-2">';
	echo'<img class="comment-image" src="upload/imag/'.$row['imag'].'"> ';
    echo '<a href="profile2.php?id='.$row['userID'].'">'.$row['username'].'</a>';
    echo '</div>';
	
    echo'<div class="col-lg-5 comment-content">';
    echo $row['comment_name'];
	echo'<div class="angel"></div>';
    echo'</div>';
    echo'<div class="col-lg-2">';
    echo $row['date'];
    echo'</div>';
	echo'<div class=" col-lg-3">';
	echo'<div class="icon">';
	echo '<i class="fas fa-ellipsis-v" ></i>';
	

	if($row['user_id']==$_SESSION['i']){
	echo'<div class="buttons">';

    echo '<a class="btn btn-primary btn-sm" href="comments.php?do=edit&id='.$row['comment_id']. '"> Edit</a>';
    echo'<a class="btn btn-danger btn-sm" href="comments.php?do=delete&id='.$row['comment_id']. '" onclick="return confirm(\'are you sure?\')"> Delete</a>';
                                    }
	echo'</div>';
	echo'</div>'; 
    echo'</div>';
    echo'</div>';
	
            }//end row 

    echo'</div>';
    }//end count
    }?>
	 <script> var dots =document.getElementById("dots");
         var buttons =document.getElementById("buttons");
          dots.onclick= function show(){
	       buttons.style.display="block";
                                        }    
  </script>
	 <?php

   include "includes/templates/footer.php"; ?>