<?php 



session_start();
if(isset($_SESSION['user'])){
			$titel='Items';
			include 'init.php';

			//$do=isset($_GET['do']);
			$do=$_GET['do'];

			if($do=='manag'){
				$st=$con->prepare("SELECT
										item.*, 
										categories.cat_name AS category_name, 
										users.username 
									FROM 
										item
									INNER JOIN 
										categories 
									ON 
										categories.ID = item.cat_id 
									INNER JOIN 
										users 
									ON 
										users.userID = item.member_id");
				$st->execute();
				$data=$st->fetchAll();

				?>

					<h4 class="text-center">Manage All Items</h4><br><br>
					<div class="container">
						<div class="table-responsive">
							<table class="main-table table-bordered table text-center">
								<tr class="tr">
									<td>ID</td>
									<td>Image</td>
									<td>Name</td>
									<td>country</td>
									<td>price</td>
									<td>member</td>
									<td>Category</td>
									<td>Date</td>
									<!--<td>status</td>-->
									<td>Options</td>
								</tr>
			<?php
                foreach($data as $item)

                	{echo '<tr>';
                		echo'<td>'. $item['itemid'].'</td>';
                		echo '<td><img src="../upload/imag/'.$item['imag'].'"></td>';
                        echo'<td>'. $item['name'].'</td>';
						echo'<td>'. $item['country'].'</td>';
						echo'<td>'. $item['price'].'</td>';
						echo'<td>'. $item['username'].'</td>';
						echo'<td>'. $item['category_name'].'</td>';
						echo'<td>'. $item['date'].'</td>';
						//echo'<td>'. $item['status'].'</td>';
	                    echo '<td>' .'<a class="btn btn-primary"'.'href="item.php?do=edit&id='; echo $item['itemid'].'"><i class="fas fa-edit"></i> Edit</a>';
                        echo '<a class="btn btn-danger"'; echo' href="item.php?do=delete&id='.$item['itemid'].'"' ;
				        echo 'onclick="return confirm(\'Are you sure?\')"';
					    echo'>Delete <i class="far fa-trash-alt"></i> </a>';
                        if($item['approve']==0){echo '<a class="btn btn-info"'; echo' href="item.php?do=approve&id='.$item['itemid'].'"' .'><i class="far fa-lightbulb"></i> Approve</a></td>';}
                        echo '</tr>';
                                        }
					    echo'</table>';
					    echo'</div>';
					    echo' <a class="btn btn-primary"  href="item.php?do=add"> Add items </a> ';
					    echo'</div>';

			}elseif($do=='add'){


			  ?>	 	
			           <form class="form-member" action="?do=insert" method="POST">
				         
					    <h4 class="text-center">Add Items<h4><br>
					   <h6 class="control-label">Item name</h6>
				        
						<input class="form-control" type="text" name="name" placeholder="enter name of object" required="required">
				       <h6 class="control-label">description</h6>
						<input class="form-control" type="text" name="desc" placeholder="enter your ordering.">
						<h6 class="control-label">country</h6>
						<input class="form-control" type="text" name="country" placeholder="enter your desc.">
						<h6 class="control-label">Price</h6>
						<input class="form-control" type="text" name="price" placeholder="enter your ordering.">
				       <h6 class="control-label">status</h6>
						<select class="form-control" type="text" name="status" placeholder="enter your desc.">
							<option value="0">---</option>
						<option value="1">very old</option>
						<option value="2">Old</option>
						<option value="3">New</option>
			         </select>
			         <h6 class="control-label">member</h6>
			         <select class="form-control" type="text" name="member" placeholder="enter your desc.">
							<option>---</option>
                             <?php
                             $st=$con->prepare("SELECT * FROM users") ;
                             $st->execute();
                             $rows=$st->fetchAll();
                             foreach($rows as $row){
                             	echo '<option value="'.$row['userID'].'">' .$row['username'] .'</option>';
                             }

                             ?>
						
			         </select>
			         <h6 class="control-label">category</h6>
			         <select class="form-control" type="text" name="category" placeholder="enter your desc.">
							<option>---</option>
                             <?php
                             $st=$con->prepare("SELECT * FROM categories") ;
                             $st->execute();
                             $rows=$st->fetchAll();
                             foreach($rows as $row){
                             	echo '<option value="'.$row['ID'].'">' .$row['cat_name'] .'</option>';
                             }

                             ?>
						
			         </select>
			     
					<button class="btn btn-primary text-center"> add</button>
				</form>

			<?php

}elseif($do=='edit'){
				if(isset($_GET['id'])){
					$id=$_GET['id'];
				}
				$st =$con-> prepare("SELECT * FROM item WHERE itemid=?");
				
				$st->execute(array($id));
				$items=$st->fetchAll();
			foreach($items as $item){
?>	 	
			           <form class="form-member" action="?do=update" method="POST">
				         
					    <h4 class="text-center">Edit Item<h4><br>
					   <h6 class="control-label">Item name</h6>
				        <input type="hidden" name="id" value= "<?php echo $id;?>">
						<input class="form-control" type="text" value="<?php echo $item['name']; ?>" name="name" placeholder="enter name of object" required="required">
				       <h6 class="control-label">description</h6>
						<input class="form-control" type="text" name="desc" value="<?php echo $item['description']; ?>" placeholder="enter your ordering.">
						<h6 class="control-label">Price</h6>
						<input class="form-control" type="text" name="price" value="<?php echo $item['price']; ?>" placeholder="enter your ordering.">
						<h6 class="control-label">country</h6>
						<input class="form-control" type="text" name="country" value="<?php echo $item['country']; ?>" placeholder="enter your desc.">
						
				       <h6 class="control-label">status</h6>
						<select class="form-control" type="text" name="status" placeholder="enter your desc.">
						<option value="0" <?php if($item['status']==0){echo 'selected';}?>>---</option>
						<option value="1" <?php if($item['status']==1){echo 'selected';}?>>very old</option>
						<option value="2" <?php if($item['status']==2){echo 'selected';}?>>Old</option>
						<option value="3" <?php if($item['status']==3){echo 'selected';}?>>New</option>
			         </select>
			         <h6 class="control-label">member</h6>
			         <select class="form-control" type="text" name="member" placeholder="enter your desc.">
							 <?php
							
						   $st=$con->prepare("SELECT *FROM users");
							$st->execute();
							$items=$st->fetchAll();
							foreach($items as $it){
								echo'<option value="'.$it['userID'] .'"';
							 if($it['userID']==$item['member_id'])
							 	{
							 echo 'selected';}echo '>'. $it['username'] .'</option>';}?>
                            
						
			         </select>
			         <h6 class="control-label">category</h6>
			         <select class="form-control" type="text" name="category" placeholder="enter your desc.">
					
                             <?php
                             $st=$con->prepare("SELECT * FROM categories") ;
                             $st->execute();
                             $rows=$st->fetchAll();
                             foreach($rows as $row){
                             	
                             	echo '<option value="'.$row['ID'].'"';
                             	if($row['ID']==$item['cat_id']){echo 'selected';}
                             	echo'>' .$row['cat_name'] .'</option>';
                             
}
                             ?>
						
			         </select>
			     
					<button class="btn btn-primary text-center">save</button>
				</form>

			<?php
}

	 }elseif($do=='insert'){
			 echo 'insert';
            if($_SERVER['REQUEST_METHOD']=='POST'){
                
                $name=$_POST['name'];
                $desc=$_POST['desc'];
                $country=$_POST['country'];
                $price=$_POST['price'];
                $status=$_POST['status'];
                $member=$_POST['member'];
                $category=$_POST['category'];
                $st=$con->prepare("INSERT INTO item (name,description,country,price,status,date,cat_id,member_id)
                	VALUES(:zname,:zdescription,:zcountry,:zprice,:zstatus,now(),:zcat_id,:zmember_id)");
                $st->execute(array(
                    'zname'=>$name,
                     'zdescription'=> $desc,
						'zcountry'=>$country,
						'zprice'=>$price,
						'zstatus'=>$status,
						'zcat_id'=> $category,
						'zmember_id'=> $member

                ));
            echo '<div class="alert alert-success"> Item Inserted</div>';

             header('refresh:1;item.php?do=manag');

            }

						




			}
			elseif($do=='update'){
				
				if($_SERVER['REQUEST_METHOD']=='POST'){
					$id =$_POST['id'];
					$name =$_POST['name'];
					$desc =$_POST['desc'];
					
					$price =$_POST['price'];
					$country =$_POST['country'];
					$status=$_POST['status'];
					$cat=$_POST['category'];
					$member =$_POST['member'];
					$st=$con->prepare("UPDATE item SET name=?,description=?,price=?,country=?,status=?,cat_id=?,member_id=?WHERE itemid=?");
					$st->execute(array($name,$desc,$price,$country,$status,$cat,$member,$id));
					echo '<div class="alert alert-success"> Item Updated</div>';
					 header('refresh:1;item.php?do=manag');


				}
			   	
			}elseif($do=='delete'){
				if(isset($_GET['id'])&&is_numeric($_GET['id'])){
					$id=$_GET['id'];

				}
			 $stmt=$con->prepare("DELETE FROM item WHERE itemid=:id");
			 $stmt->bindParam(":id",$id);
			 $stmt->execute();
			   echo '<div class="alert alert-success">Deleted</div>';
               header('refresh:1;item.php?do=manag');
			}elseif($do=='approve'){

                  if(isset($_GET['id'])&&is_numeric($_GET['id'])){
					$id=$_GET['id'];

				                 }
				                 $st=$con->prepare("UPDATE item SET approve=1 WHERE itemid=?");
                                  $st->execute(array($id));
                                  echo '<div class="alert alert-success">approved</div>';
                                  header('refresh:1;item.php?do=manag');
                                 

				}



			   	
			     include $tpl.'footer.php';}else{
		header('Location: index.php');

		exit();

			     }

