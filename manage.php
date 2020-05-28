<?php 
session_start();
if(isset($_SESSION['username'])){
						$title='Manage';
						include "init.php";

						if(isset($_GET['section'])){

						$section=filter_var($_GET['section'],FILTER_SANITIZE_STRING);
					                             }

						if(isset($_GET['id'])&&is_numeric($_GET['id'])){

						$itemid =intval($_GET['id']);}

if($section=='edit'){

						$rows =checkFetch("*","item","itemid",$itemid);
						foreach ($rows as $row){
							

						?>


<div class="container">
						   
	<div class="panel panel-primary">
			<div class="row">
							
	     		 <div class="col-md-8">


			       <form class="form-member" action="?section=update&id=<?php echo $row['itemid']; ?>" method="POST"  enctype="multipart/form-data">
						         
						 <h4 class="text-center pagename">Edit Item</h4>
					 <div class="row">
							 <div class="col-lg-3">
							 <i class="far fa-user"></i> <h5 class="control-label">Name:</h5>
								 </div>
							 
						        <input type="hidden" name="id" value="<?php echo $row['itemid'];?>">
							 <div class="col-lg-9">
								<input class="form-control" type="text" name="name" value="<?php echo $row['name']; ?>" placeholder="enter name of item" required="required">
								 </div>
							  <div class="col-lg-3">
								  <i class="fas fa-info-circle"></i> 
						       <h5 class="control-label">Info :</h5>
							 </div>
							 <div class="col-lg-9">
								<input class="form-control" type="text" name="desc" value="<?php echo $row['description']; ?>" placeholder="enter your description">
							 </div>
								   <div class="col-lg-3">
								<h6 class="control-label"><i class="fas fa-map-marker-alt"></i> country:</h6>
								  </div>
							  <div class="col-lg-9">
								<input class="form-control" type="text" name="country" value="<?php echo $row['country']; ?>" placeholder="country of made ">
							 </div>
									    <div class="col-lg-3">
								<h6 class="control-label"><i class="fas fa-euro-sign"></i> Price:</h6>
									   </div>
							  <div class="col-lg-9">
								<input class="form-control" type="text" name="price" value="<?php echo $row['price']; ?>" placeholder="Enter the price">
							 </div>
											 <div class="col-lg-3">
						       <h6 class="control-label"><i class="far fa-question-circle"></i>status:</h6>
											</div>
							  <div class="col-lg-9">
						    <select class="form-control" type="text" name="status" value="<?php echo $row['status']; ?>" placeholder="eselect status">
									<option value="0" <?php if ($row['status']==0){echo 'selected';} ?>>---</option>
								<option value="1"  <?php if ($row['status']==1){echo 'selected';} ?>>very old</option>
								<option value="2"  <?php if ($row['status']==2){echo 'selected';} ?>>Old</option>
								<option value="3"  <?php if ($row['status']==3){echo 'selected';} ?>>New</option>
					        </select>
							 </div>
					         <div class="col-lg-3">
					         <i class="fab fa-buffer"></i><h6 class="control-label">category:</h6>
												 </div>
							 <div class="col-lg-9">
							       <select class="form-control" type="text" name="category" placeholder="select the category">
											<option value="0">---</option>
				                         <?php
				                             $st=$con->prepare("SELECT * FROM categories") ;
				                             $st->execute();
				                             $rows=$st->fetchAll();
				                          foreach($rows as $r){
				                             	echo '<option value="'.$r['ID'].'"';
				                                 if($row['cat_id']==$r['ID']){echo 'selected';} 
				                             	 echo '>' .$r['cat_name'] .'</option>';
				                             }

				                         ?>
										
								 </select>
							 </div>
							 <div class="col-lg-3">
								             <h6 class="control-label"><i class="fas fa-camera-retro"></i>Image:</h6>
								 </div>
							 <div class="col-lg-9">
								         <input class="form-control" type="file" name="imag" value="<?php if(isset($row['imag'])){echo 'selected';}?>" placeholder="<?php echo $row['imag'];?>" >
								</div>
								<button class="btn btn-primary text-center" > Save</button>
										
					 </div>
		   </form>

             
       </div>
							
									
		       <div class="col-md-4">

			
		               	<img class="img-responsive" src="<?php echo'upload/imag/'.$row['imag'];?>">
		        </div>
		       <?php } ?>
		 
		   </div> <!--end row-->
  </div>	<!--end panel-->							
							
</div><!--end container-->






<?php	
 

echo '</div>';



}elseif($section=='update'){
	
			if($_SERVER['REQUEST_METHOD']=='POST'){


            	$imagname=$_FILES['imag']['name'];
            	$imagsize=$_FILES['imag']['size'];
            	$imagtype=$_FILES['imag']['type'];
            	$imagtmp=$_FILES['imag']['tmp_name'];
            	$extensions =array("jpg","jpeg","png","gif","jfif");
				if(empty($imagname)){	 $rows =checkFetch("*","item","itemid",$itemid);
                	//$errors[]= 'image must not be empty';
					foreach($rows as $row){
						$imagname=$row['imag'];}
					   $imag=$imagname;
					}else{ $imagname=$_FILES['imag']['name'];
						    $imag=rand(0,1000000).'_'.$imagname;       }
            	$imagexp =strtolower(end(explode(".",$imagname)));


            	//----------------------- Filter the Values that user inserted 
				$name =filter_var($_POST['name'],FILTER_SANITIZE_STRING);
				$desc =filter_var($_POST['desc'],FILTER_SANITIZE_STRING);
				$country =filter_var($_POST['country'],FILTER_SANITIZE_STRING);
				$price =filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
				$status =filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
				$cat =filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
				$id= filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);


				//--------VALiDATE ERRORS -------------------
				$errors=array();

                if(!empty($imagname)&&!in_array($imagexp,$extensions)){

                	$errors[]= 'extension not allowed';
                }

                
             
                

                if($imagsize>3000000){

                	$errors[]= 'size must not be more than 3 MB';
                }
          //---------loop the erroes ------------
                foreach($errors as $error){

                	echo '<div class="aler alert-danger">'.$error .'</div>';
                }
					/*if(empty($imagname)){
                $imag =$imagname;}else{
						 $rows =checkFetch("*","item","itemid",$itemid);
						foreach($rows as $row){
					$imag=	$row['imag'];}
					}*/
                move_uploaded_file($imagtmp,'upload/imag//'.$imag);
                

//---------------start Update------------------------------------
               if(empty($errors)){
                
					$update =$con->prepare("UPDATE item SET name=?, description=?, country=? ,price=?, status=?, cat_id=?,imag=? WHERE itemid=?");
					$update->execute(array($name,$desc,$country,$price,$status,$cat,$imag,$id));
					
			       if($update)	{echo '<div class="alert alert-success">updated</div>';}
                   header('refresh:3;manage.php?section=edit&id=' .$itemid);
 
 
                              }
                }
	//--------------------Start Delete--------------------------------------------
}elseif($section=='delete'){

					$delete =$con->prepare("DELETE FROM item WHERE itemid=:zid");
					$delete->bindParam(":zid" ,$itemid);
					$delete->execute();
					echo '<div class="alert alert-success">Deleted</div>';
					header('refresh:3;index.php');
				}
				 
include "includes/templates/footer.php";}