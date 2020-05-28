<?php
session_start();
if(isset($_SESSION['user'])){
			$titel='Items';
			include 'init.php';

			//$do=isset($_GET['do']);
			$do=$_GET['do'];

		if($do=='manag'){
										$st=$con->prepare("SELECT comment.*, users.username, item.name
										FROM comment
										INNER JOIN item ON
										item.itemid=comment.item_id
										INNER JOIN users ON
										users.userID=comment.user_id");
										$st->execute();
				$comments=$st->fetchAll();

				?>

					<h4 class="text-center">Manage The Comments</h4><br><br>
					<div class="container">
						<div class="table-responsive">
							<table class="main-table table-bordered table text-center">
								<tr class="tr">
									<td>ID</td>
									<td>comment</td>
									<td>Date</td>
									<td>username</td>
									<td>Item</td>
									
								 <!--<td>status</td>-->
									<td>Options</td>
								</tr>
			<?php
                foreach($comments as $comment)

                	{echo '<tr>';
                		echo'<td>'. $comment['comment_id'].'</td>';
                        echo'<td class="td">'. $comment['comment_name'].'</td>';
						echo'<td>'. $comment['date'].'</td>';
						echo'<td>'. $comment['username'].'</td>';
						echo'<td>'. $comment['name'].'</td>';
						/*echo'<td>'. $item['category_name'].'</td>';
						echo'<td>'. $item['date'].'</td>';*/
						//echo'<td>'. $item['status'].'</td>';
	                     echo '<td>' .'<a class="btn btn-primary"'.'href="comment.php?do=edit&id='; echo $comment['comment_id'].'"><i class="fas fa-edit"></i> Edit</a>';
                        echo '<a class="btn btn-danger"'; echo' href="comment.php?do=delete&id='.$comment['comment_id'].'"  onclick="return confirm(\'are you sure?\')"><i class="far fa-trash-alt"></i> Delete</a>';
                        if($comment['approv']==0){echo '<a class="btn btn-info"'; echo' href="comment.php?do=approve&id='.$comment['comment_id'].'"><i class="far fa-lightbulb"></i> Approve</a></td>';}
                        echo '</tr>';
                                        }
					echo'</table>';
					echo'</div>';
					echo'</div>';

			}elseif($do=='edit'){
            if(isset($_GET['id'])&&is_numeric($_GET['id'])){
             	$id=$_GET['id'];}
           $st =$con->prepare("SELECT comment_name from comment WHERE comment_id=?");
					$st->execute(array($id));
					$checks =$st->fetch();
          //  foreach($checks as $check){
             	
			           ?><form class="form-member text-center" action="?do=update" method="POST">
				         
					    <h4 class="text-center">Edit comment</h4><br>
					   <h6 class="control-label">Edit your comment</h6>
				        <input type="hidden" class="form-control" name="id" value="<?php echo $id;?>" >
						<input class="form-control" type="text" value="<?php echo $checks['comment_name'];?>" name="comment" placeholder="enter name of object" required="required">
						<input type="submit" value="Save" class="btn btn-primary btn-sm" /> 
            
					</form>
              
<?php
			}elseif($do=='update')	{
				
				if($_SERVER['REQUEST_METHOD']=='POST'){
					$id = $_POST['id'];
					$comment=$_POST['comment'];
					$st =$con->prepare("UPDATE comment SET comment_name=? WHERE comment_id=?");
					$st->execute(array($comment,$id));
					echo '<div class="alert alert-success">Updated</div>';
				header('refresh:1;comment.php?do=manag');



			}}elseif($do=='delete')	{
				if(isset($_GET['id'])&&is_numeric($_GET['id'])){
             	$id=$_GET['id'];}
             	$st =$con ->prepare("DELETE FROM comment WHERE comment_id=:zid");
             	$st->bindParam(':zid',$id);
             	$st->execute();
			echo '<div class="alert alert-success">Deleted</div>';
             	header('refresh:1;comment.php?do=manag');



			}elseif($do=='approve'){
				if(isset($_GET['id'])&&is_numeric($_GET['id'])){
             	$id=$_GET['id'];}

             	$st=$con->prepare("UPDATE comment SET approv=1 WHERE comment_id=?");
             	$st->execute(array($id));
             	echo '<div class="alert alert-success">approved</div>';
				 header('refresh:1,'.$_SERVER['HTTP_REFERER']);
			}	   	
			     include $tpl.'footer.php';}else{
				

		exit();

			     }