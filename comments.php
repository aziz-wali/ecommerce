<?php 
session_start();
if(isset($_SESSION['username'])){
			$title='Items';
			include 'init.php';
if(isset($_GET['do'])){
	$do=$_GET['do'];
}

//-----------start edit section 
if($do=='edit'){

            if(isset($_GET['id'])&&is_numeric($_GET['id'])){
             	$id=$_GET['id'];}
                $st =$con->prepare("SELECT comment_name from comment WHERE comment_id=?");
				$st->execute(array($id));
			    $checks =$st->fetch();
          //  foreach($checks as $check){
             	
			           ?>
	<form class="form-member text-center" action="?do=update" method="POST">
				         
					    <h4 class="text-center">Edit comment</h4><br>
					     <h6 class="control-label">Edit your comment</h6>
				        <input type="hidden" class="form-control" name="id" value="<?php echo $id;?>" >
	                   <textarea class="textarea" type="text" value="<?php echo $checks['comment_name'];?>" name="comment" placeholder="  enter name of object" required="required"><?php echo $checks['comment_name'];?>
	                   	
	                   </textarea>
						<input type="submit" value="Save" class="btn btn-primary btn-sm" /> 
            
	</form>
              
<?php
			}
//---------Start Update section-----------			
			
elseif($do=='update')	{
				
				if($_SERVER['REQUEST_METHOD']=='POST'){

					$id = $_POST['id'];
					$comment=filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
					$st =$con->prepare("UPDATE comment SET comment_name=? WHERE comment_id=?");
					$st->execute(array($comment,$id));
					echo '<div class="alert alert-success">Comment Updated</div>';
					header('refresh:2; ' . $_SERVER['HTTP_REFERER']);
				//header('refresh:2;items.php?itemid=');
					//echo "<a href=\"javascript:history.go(-1)\">GO BACK</a>";



			}
		}

//-------------start delete section-------------

elseif($do=='delete')	{
				if(isset($_GET['id'])&&is_numeric($_GET['id'])){
             	$id=$_GET['id'];}
             	$st =$con ->prepare("DELETE FROM comment WHERE comment_id=:zid");
             	$st->bindParam(':zid',$id);
             	$st->execute();
			echo '<div class="alert alert-success">Deleted</div>';
             	header('refresh:2;'.$_SERVER['HTTP_REFERER']);

             }

include 'includes/templates/footer.php';}