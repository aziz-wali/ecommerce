<?php
session_start();
$titel='Add';

 include "init.php";


//check if the request method is  post
            if($_SERVER['REQUEST_METHOD']=='POST'){

//--------------------Stat image-------

            	$imagname=$_FILES['imag']['name'];
            	$imagsize=$_FILES['imag']['size'];
            	$imagtype=$_FILES['imag']['type'];
            	$imagtmp=$_FILES['imag']['tmp_name'];
            	$extensions =array("jpg","jpeg","png","gif","jfif","JPG","webp");
            	$imagexp =strtolower(end(explode(".",$imagname)));

//---------------END IMAGE---------------

                $name=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
                $desc=filter_var($_POST['desc'],FILTER_SANITIZE_STRING);
                $country=filter_var($_POST['country'],FILTER_SANITIZE_STRING);
                $price=filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
                $status=filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
                $category=filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT); 
                $errors =array();
                
//------------check the Errors -------------
                if(strlen($name)<3){

                	$errors[]= 'name must be mor than 3 letters';
                }

                if(empty($name)){

                	$errors[]= 'name must be not empty';
                }
                if(empty($desc)){

                    $errors[]= 'description must be not empty';
                }
                if(empty($country)){

                    $errors[]= 'country must be not empty';
                }
                 if(empty($price)){

                    $errors[]= 'price must not be empty';
                }
                 if(empty($status)){

                    $errors[]= 'status must be not empty';
                }
                  if(empty($category)){

                    $errors[]= 'category must be not empty';
                }
               

                if(!empty($imagname) && !in_array($imagexp,$extensions)){

                	$errors[]= 'extension not allowed';
                }

                if(empty($imagname)){

                	$errors[]= 'image must not be empty';
                }

                if($imagsize>3000000){

                	$errors[]= 'size must not be more than 3 MB';
                }

//-----------loop the errors and display it ------------

                foreach($errors as $error){

                	echo '<div class="aler alert-danger">'.$error .'</div>';
                }

                $imag = rand(0,1000000).'_'.$imagname;

                move_uploaded_file($imagtmp,'upload/imag//'.$imag);

// ------------Check if there is no errors start insert the data to  databse-------------------

               if(empty($errors)){
                $country = filter_var($country,FILTER_SANITIZE_STRING);
                
                $st=$con->prepare("INSERT INTO item (name,description,country,price,status,date,imag,cat_id,member_id)
                	VALUES(:zname,:zdescription,:zcountry,:zprice,:zstatus,now(),:zimag,:zcat_id,:zmember_id)");
                $st->execute(array(
                        'zname'       =>   $name,
                        'zdescription'=>   $desc,
						'zcountry'    =>   $country,
						'zprice'      =>   $price,
						'zstatus'     =>   $status,
						'zimag'       =>   $imag,
						'zcat_id'     =>   $category,
						'zmember_id'  =>   $_SESSION['i']

                ));
                echo '<div class="alert alert-success"> Item inserted </div>';
                header('refresh:1;all.php');}



 }?>
<div class="container">
   
        <div class="panel panel-primary">
<div class="row">
	   <div class="col-md-12">


			           <form class="form-member" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
				         
					    <h4 class="text-center pagename">Add Items<h4>
					   <h6 class="control-label">Item name</h6>
				        
						<input class="form-control" type="text" name="name" placeholder="enter name of item" required="required">
				       <h6 class="control-label">description</h6>
						<input class="form-control" type="text" name="desc" placeholder="enter your description." required="required">
						<h6 class="control-label">country</h6>
						<input class="form-control" type="text" name="country" placeholder="enter country of manufacture " required="required">
						<h6 class="control-label">Price</h6>
						<input class="form-control" type="number" name="price" placeholder="enter the Price of Item" required="required">
				       <h6 class="control-label">status</h6>
						<select class="form-control" type="text" name="status" required="required">
							<option value="0">---</option>
    						<option value="1">very old</option>
    						<option value="2">Old</option>
    						<option value="3">New</option>
			           </select>
			        
			         <h6 class="control-label">category</h6>
			         <select class="form-control" type="text" name="category" required="required">
							<option value="0">---</option>
                             <?php
                             $st=$con->prepare("SELECT * FROM categories") ;
                             $st->execute();
                             $rows=$st->fetchAll();
                             foreach($rows as $row){
                             	echo '<option value="'.$row['ID'].'">' .$row['cat_name'] .'</option>';
                             }

                             ?>
						
			         </select>
                     <h6 class="control-label">Image</h6>
			          <input class="form-control" type="file" name="imag" placeholder="" required="required">
					 <button class="btn btn-primary text-center"> add</button>
				</form>

       </div>
       <div class="">

	
	<img class="img-responsiv" src="">
        </div>
       
    </div>
   </div>
</div>


<?php   include "includes/templates/footer.php"; ?>