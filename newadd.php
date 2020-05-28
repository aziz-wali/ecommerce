
<form class="form-member text-center" action="?do=insert" method="POST">
				         
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