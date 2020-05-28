<?php 
session_start();
$title='payment';
include 'init.php';
include 'includes/templates/navbar.php';


if(!isset($_SESSION['i'])){
	header('location:login.php?do=signin');
                           }
	if(isset($_GET['do'])){
		$do=$_GET['do'];
	}
	if(isset($_GET['id'])){
		$id=$_GET['id'];
	                     }
if(isset($_SESSION['username'])){ 

/*$statment=$con->prepare("select * from orders where user_ID=?");
	$statment->execute(array($_SESSION['i']));
	$counter =$statment->rowCount();
if($counter>0){*/


	
	if($do=='manage'){
		
	$count =check('quantity','orders','user_ID',$_SESSION['i']);
		//echo $count;
	if($count>0){?>
	<i class="fas fa-cart-plus fa-2x"><span><?php
		$total_orders=0;
		$infos= checkFetch('quantity','orders','user_ID',$_SESSION['i']);
	foreach($infos as $info){
	$orders= $info['quantity'];
		$total_orders =$orders +$total_orders;
		} echo $total_orders;
		?> </span></i>
       <div class="container">
		<h4 class="text-center">My Orders </h4>
		<div class="orders-table table-responsive">
	<table class="table table-borderd">
		<tr>
		<td><b>#ID</b></td>
		<td><b>quantity</b></td>
		<td><b>item</b></td>
		<td><b>price</b></td>
		<td><b>Date</b></td>
		<td><b>image</b></td>
		<td><b>Manage</b></td>
			
		</tr><br>
		
			<?php 
				 $total=0; 
			  $statment =$con->prepare("select orders.* ,item.* from orders INNER JOIN item on orders.item_id=item.itemid where user_ID=?");
					  $statment->execute(array($_SESSION['i']));
					  $rows =$statment->fetchAll();
					  foreach($rows as $row){
						
						
						  if(is_numeric($row['quantity'])&&is_numeric($row['price'])){}
						 
						  
		  echo'<tr>';
			 echo'<td>'.$row['order_id'].'</td>';
			 echo'<td>'.$row['quantity'].'</td>';
			 echo'<td><a href="items.php?itemid='.$row['itemid'].'">'.$row['name'].'</a></td>';
			 echo'<td>'.intval($row['quantity'])*intval($row['price']).' &euro;</td>';
			 echo'<td>'.$row['orders_date'].'</td>';
			 echo'<td><img src="upload/imag/'.$row['imag'].'"></td>';
			 echo'<td><a href="pay.php?do=edit&id='.$row['order_id'].'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>';
			 echo'<a onclick="return confirm(\'are you sure?\')" href="pay.php?do=delete&id='.$row['order_id'].'" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a></td>';
		echo'</tr>'	;  

		$count_price =intval($row['quantity'])*intval($row['price']);	
				 $total=$count_price + $total;			  
			} ?>
				</table>
			</div>

			<?php	
			echo '<hr class="separator">';
			echo 'Total price: <b>'.$total . '&euro;</b><br><br>'; 
		    echo'<a href="pay.php?do=buyit&id='.$row['order_id'].'" class="btn btn-success btn-sm"><i class="fas fa-money-bill-wave"></i> Buy </a>';}		 
					 
	 }elseif($do=='addcart'){

	if($_SERVER['REQUEST_METHOD']=='POST'){
		//echo $_POST['number'];
		  $number= filter_var($_POST['number'],FILTER_SANITIZE_NUMBER_INT);
		  $id=     filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);

		  $statment =$con->prepare("insert into orders(quantity,user_ID,item_id) 
		   values(:zquantity,:zuser_ID,:zitem_id)");

		   $statment->execute(array(
		       'zquantity' => $number,
			   'zuser_ID' => $_SESSION['i'],
			   'zitem_id' => $id
			   
		   
		   ));

		  echo'<div class="alert alert-success">your order was Added</div>';
		header('refresh:2;pay.php?do=manage');
	
	}
	  }elseif($do=='setnumber'){


		  	if(isset($_GET['id'])){
			$id=$_GET['id'];
				}?>
			<form class="edit-form" method="post" action="pay.php?do=addcart">
			<h6>Enter The Quantity :</h6><input type="hidden" name="id" value="<?php echo $id; ?>">
			<input class="form-control" type="number" name="number">
				<input type="submit" class="btn btn-primary"  value="save">

				</form>

<?php }elseif($do=='buy'){

			if(isset($_GET['id'])){
			 $id=$_GET['id'];}
		   if(isset($_GET['a'])){
			 $a=$_GET['a'];
			                    }

		   if($a=='q'){ if($_SERVER['REQUEST_METHOD']=='POST'){
		//echo $_POST['number'];
		  $number= filter_var($_POST['number'],FILTER_SANITIZE_NUMBER_INT);
		   $id=    filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
		  $statment =$con->prepare("insert into orders(quantity,user_ID,item_id) 
		   values(:zquantity,:zuser_ID,:zitem_id)");
		   $statment->execute(array(
		       'zquantity' => $number,
			   'zuser_ID' => $_SESSION['i'],
			   'zitem_id' => $id
			   
		   
		   
		   
		   ));
			   if($statment){
			echo'<div class="alert alert-success">your order was Added</div>';
			header("refresh:2;pay.php?do=buyit");
		}
		  }}elseif($a=='s'){
		  ?>
		   <form class="edit-form" method="post" action="pay.php?do=buy&a=q">
			<h6>Enter The Quantity :</h6><input type="hidden" name="id" value="<?php echo $id; ?>">
			<input class="form-control" type="number" name="number">
				<input type="submit" class="btn btn-primary"  value="save">
	
	</form>
		
		  <?php }
			
		
		
		
}elseif($do=='buyit'){?>
					<h4 class="text-center">Check out</h4>
		<div class="row">
			<div class="col-md-6">
               <form class="form-buy">
						<h6>Your Information :</h6>
						  <div class="form-row">

							<div class="form-group col-md-5">
							  <label for="inputEmail4">First Name</label>
							  <input type="text" class="form-control" placeholder="Enter your First Name" id="inputEmail4">
							</div>
							<div class="form-group col-md-5">
							  <label for="inputPassword4">Last Name</label>
							  <input type="text" class="form-control" placeholder="Enter your Last Name" id="inputPassword4">
							</div>
							  <div class="form-group col-md-5">
							  <label for="inputPassword4">Email</label>
							  <input type="email" class="form-control" placeholder="Enter your Email"id="inputPassword4">
							</div>
							  <div class="form-group col-md-5">
							  <label for="inputPassword4">Telephone Number </label>
							  <input type="number" class="form-control" placeholder="Enter your Telephone Number " id="inputPassword4">
							</div>
						  </div>
						  <div class="form-group">
							<label for="inputAddress">Address</label>
							<input type="text" class="form-control col-md-6" id="inputAddress" placeholder="1234 Main St">
						  </div>
						  <div class="form-group">
							<label for="inputAddress2">Address 2(optional)</label>
							<input type="text" class="form-control col-md-6" id="inputAddress2" placeholder="Apartment, studio, or floor">
						  </div>
						  <div class="form-row">
							<div class="form-group col-md-5">
							  <label for="inputCity">City</label>
							  <input type="text" class="form-control" id="inputCity">
							</div>
							<div class="form-group col-md-4">
							  <label for="inputState">Country</label>
							  <select id="inputState" class="form-control">
								<option ></option>
								<option selected>Germany</option>
								  <option>France</option>
								  <option>Syria</option>
								  <option>Moldova</option>
								  <option>Zimbabwe</option>
							  </select>
							</div>
							<div class="form-group col-md-2">
							  <label for="inputZip">Zip</label>
							  <input type="text" class="form-control" id="inputZip">
							</div>
						  </div>
						  <div class="form-group">
							<div class="form-check">
							  <input class="form-check-input" type="checkbox" id="gridCheck">
							  <label class="form-check-label" for="gridCheck">
								Check me out
							  </label>
							</div>
						  </div>
						  <button type="submit" class="btn btn-primary">Save</button>
			  </form>
		</div>
		  <div class="col-md-5">
			<div class="item-view">
				<h6>item view :</h6>
			<?php $total=0;
					$view = $con -> prepare("SELECT orders.*, item.* FROM orders INNER JOIN item ON orders.item_id =item.itemid WHERE user_ID=?");
					  $view->execute(array($_SESSION['i']));
					  $items =$view->fetchAll();
					  foreach($items as $item){
					 echo '<div class="details">';
					  echo'<div class="row">';
					    echo'<div class="col-md-5">';
						  echo'<img src="upload/imag/'.$item['imag'].'"><br>';
						 echo '</div>'; 
					   echo '<div class="col-md-7">'; 
						  echo '<b>item Name:</b> '.$item['name'].'<br>';
						  echo'<b>quantity:</b> '.$item['quantity'].'<br>';
						  echo'<b>price: </b>'.$item['price'];
						  echo '<br>'.'<b>Date: </b>'.$item['orders_date'].'<br>';
						  echo'<b>Sum : </b>'.intval($item['quantity'])*intval($item['price']).' &euro;<br>';
						  $i=intval($item['quantity'])*intval($item['price']);
						  $total=$i+$total;
					   echo '</div>';
					  echo '</div>'; 
				 echo '</div>'; 
					  }
			
			echo 'Total = <b>'.$total .'</b> &euro; <br>';
			echo 'Shipping = <b>'.'9 </b>&euro;'.'<br>';
					$shipping =$total +9 ;  
			echo 'Total Price = <b>'.$shipping .'</b> &euro;';
			
			
			
			?>
		</div>
	</div>
 </div>
		
		
<?php }elseif($do=='edit'){//start edit section


		   if(isset($_GET['id'])){
		   $id =intval($_GET['id']);
		   } 
		   $statment=$con->prepare("select quantity from orders where user_ID=? and order_id=?");
	       $statment->execute(array($_SESSION['i'],$id));
		  $data= $statment -> fetch();?>
		
		
		   <form class="edit-form" method="post" action="pay.php?do=update">
	           <h6>Change Quantity :</h6>
	           <input class="form-control" type="number" name="number" value="<?php echo $data['quantity'];?>">
			   <input class="form-control" type="hidden" name="id" value="<?php echo $id ; ?>">
			   <input class="btn btn-primary" type="submit" value="Save">
		</form>
      <?php
		
	}elseif($do=='update'){

		$number=filter_var($_POST['number'],FILTER_SANITIZE_NUMBER_INT);
		$id= filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);

		$update =$con->prepare("UPDATE orders SET quantity=? Where user_ID=? AND order_id=? ");
		$update->execute(array($number,$_SESSION['i'],$id));

		if($update){

			echo'<div class="alert alert-success">your quantity was updated</div>';
			header("refresh:2;pay.php?do=manage");
		        }
	}elseif($do=='delete'){

		   if(isset($_GET['id'])){
		   $id =intval($_GET['id']);
		                         }                  
			$delete =$con->prepare("DELETE FROM orders WHERE order_id= :x");
			$delete->bindParam(':x',$id);
			$delete->execute();

			if($delete){
			echo'<div class="alert alert-success">your order was Deleted</div>';
			header("refresh:2;pay.php?do=manage");
		            }
	                     }//end delete
	

}
		//else{echo'you dont have any orders';}
	 ?>
	
	
	
	</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
