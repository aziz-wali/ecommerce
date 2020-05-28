<?php
session_start();
if(isset($_SESSION['user'])){
$titel='Categories';
include 'init.php';}

//$do=isset($_GET['do']);
$do=$_GET['do'];

if($do=='manag'){
echo '<h4 class="text-center"> Manage The Categories</h4>';
$sort ='ASC';
$sort_array=array('ASC','DESC');
if(isset($_GET['sort'])&&in_array($_GET['sort'],$sort_array)){

	$sort=$_GET['sort'];
}

	$stat=$con->prepare("SELECT* FROM categories ORDER BY ordering $sort");
	$stat->execute();
	$rows=$stat->fetchAll();

	?>
<div class="container">
	<div class="main-table">
		<hr class="separator sp">
	<div class="row">
	<div class="col-lg-2 first">
		Name
		</div>
		<div class="col-lg-5 first">
		Description  
		</div>
		<div class="col-lg-1 first">
		<?php  echo '<a class="';
				 if($sort=='ASC'){echo 'activ';}
				  echo'" href="categories.php?do=manag&sort=ASC">A</a> - <a class="';
				  if($sort=='DESC'){echo 'activ';}
				  echo '"href="categories.php?do=manag&sort=DESC">Z</a>'; ?></div>
		<div class="col-lg-3 first">
		Options
		</div>
	   </div>
		<hr class="separator sp2">
	</div>

</div>
<div class="container">
	<div class="main-table">
		<?php foreach($rows as $row ){?>
	<div class="row">
	<div class="col-lg-2">
		<?php echo '<h6>'.$row['cat_name'].'</h6>'; ?>
		</div>
		<div class="col-lg-6 ">
		<?php echo $row['description']; 
			if($row['description']==''){echo 'this category has no description ';} ?>
		</div>
		<div class="col-lg-3">
	<?php 
						
echo '<a href="categories.php?do=Edit&id='.$row["ID"].'"'. 'class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>';
echo '<a href="categories.php?do=Delete&id='.$row["ID"].'"'. 'class="btn btn-danger" onclick="return confirm(\'are you sure?\')"><i class="far fa-trash-alt"></i> Delete</a>';
									 ?>
		</div>
	   </div> <hr class="separator"><?php } ?>
		<?php echo '<a href="categories.php?do=add&id='.$row["ID"].'"'. 'class="btn btn-primary btn-cat">Add</a>';?>
	</div>

		
</div>

	<?php
	

		
}elseif($do=='add'){


  ?>	 	
           <form class="form-member text-center" action="?do=insert" method="POST">
         
			   <h4 class="text-center">Add Categories</h4><br>
	    	<h6 class="control-label">categorie name</h6>
        
		<input class="form-control" type="text" name="name" placeholder="enter name of object" required="required">
<h6 class="control-label">Order</h6>
		<input class="form-control" type="number" name="order" placeholder="enter your ordering.">
		<h6 class="control-label">desc</h6>
		<input class="form-control" type="text" name="desc" placeholder="enter your desc.">
   
  
     <h4  style="float: left"class="">Visibility</h4>
      
		<input id="vis-yes"class="" type="radio" name="vis" value ="0" placeholder="enter your desc.">
        <label for="vis-yes">yes</label>
     
        <div>
        <input id="vis-no" type="radio" name="vis" value ="1" placeholder="enter your desc.">
        <label for="vis-no">no</label>
    </div>
    
    
     <h4 style="float:left" class="">comments</h4>
      
		<input id="vis-yes"class="" type="radio" name="comm" value ="0" placeholder="enter your desc.">
        <label for="vis-yes">yes</label>
 
      <div>
        <input id="vis-no" type="radio" name="comm" value ="1" placeholder="enter your desc.">
        <label for="vis-no">no</label></div>
        <h4 style="float:left" class="">Ads</h4>
      
		<input id="vis-yes"class="" type="radio" name="ads" value ="0" placeholder="enter your desc.">
        <label for="vis-yes">yes</label>
 
      <div>
        <input id="vis-no" type="radio" name="ads" value ="1" placeholder="enter your desc.">
        <label for="vis-no">no</label></div>
      
		<button class="btn btn-primary text-center"> add</button>
	</form>







<?php

}elseif($do=='Edit'){

if(isset($_GET['id']) &&is_numeric($_GET['id'])){


	$id=$_GET['id'];
}
$st=$con->prepare("SELECT* FROM categories WHERE ID=?");
$st->execute(array($id));
 $rows=$st->fetchAll();
$count =$st->rowCount();
	if($count>0){
		foreach($rows as $row){
?>

	 <form class="form-member text-center" action="?do=update" method="POST">
         
		 <h4 class="text-center">Edit your Data</h4>
	             	<h6 class="control-label">name</h6><br>
              <input type="hidden" name="id" value="<?php echo $id ?>" />
		          <input class="form-control" type="text" name="name" value="<?php echo $row['cat_name'];?>">
		            <h6>Ordering</h6>
  		           <input class="form-control col-lg-offset-12" name="ordering" type="username" value="<?php echo$row['ordering'];?>" name="user" placeholder="enter your email">
                 <h6 class="control-label">descriptin</h6>
		           <input class="form-control" type="text" name="desc" value="<?php echo$row['description'];?>" name="user" placeholder="enter your username">

     <h4  style="float: left"class="">Visibility</h4>
      
		<input id="vis-yes"class="" type="radio" name="vis" value ="0" <?php  if($row['visibility']==0){echo 'checked';}?>>
        <label for="vis-yes">yes</label>
     
        <div>
        <input id="vis-no" type="radio" name="vis" value ="1" <?php  if($row['visibility']==1){echo 'checked';}?>>
        <label for="vis-no">no</label>
    </div>
    
    
     <h4 style="float:left" class="">comments</h4>
      
		<input id="vis-yes"class="" type="radio" name="comm" value ="0" <?php  if($row['allow_comment']==0){echo 'checked';}?>>
        <label for="vis-yes">yes</label>
 
      <div>
        <input id="vis-no" type="radio" name="comm" value ="1"  <?php  if($row['allow_comment']==1){echo 'checked';}?>>
        <label for="vis-no">no</label></div>
        <h4 style="float:left" class="">Ads</h4>
      
		<input id="vis-yes"class="" type="radio" name="ads" value ="0"  <?php  if($row['allow_ads']==0){echo 'checked';}?>>
        <label for="vis-yes">yes</label>
 
      <div>
        <input id="vis-no" type="radio" name="ads" value ="1"  <?php  if($row['allow_ads']==1){echo 'checked';}?>>
        <label for="vis-no">no</label></div>
      
		            <button class="btn btn-primary text-center"> save</button>
	       </form>
    <?php	
	} }

	 

 }elseif($do=='insert'){
 echo 'insert';
			if($_SERVER['REQUEST_METHOD']=='POST'){
			$name=$_POST['name'];
			$order = $_POST['order'];
			$desc=$_POST['desc'];
			$vis=$_POST['vis'];
			$comment =$_POST['comm'];
			$ads =$_POST['ads'];

			$CC=check('cat_name','categories','');
			if($CC>0){echo'sorry';}
			$st =$con ->prepare("INSERT INTO categories (cat_name,description ,ordering,visibility ,allow_comment ,allow_ads)
				VALUES(:zname,:zdescription,:zordering,:zvisibility,:zallow_comment,:zallow_ads)");
			$st->execute(array(

			'zname' => $name,
			'zdescription'=>$desc,
			'zordering'=> $order,
			'zvisibility'=> $vis,
			'zallow_comment'=> $comment,
			'zallow_ads'=>$ads,
			));


 echo '<div class="alert alert-success">Inserted</div>';
header("refresh:1;categories.php?do=manag");


}
}elseif($do=='update'){
   	if($_SERVER['REQUEST_METHOD']=='POST'){
            $id=$_POST['id'];
            $name=$_POST['name'];
            $ordering=$_POST['ordering'];
            $desc=$_POST['desc'];
            $vis=$_POST['vis'];
            $comm=$_POST['comm'];
            $ads=$_POST['ads'];
           $st=$con->prepare("UPDATE categories SET cat_name=?,ordering=?,description=?,visibility=?,allow_comment=?,allow_ads=?WHERE ID=?");
           $st->execute(array($name,$ordering,$desc,$vis,$comm,$ads,$id));
          echo '<div class="alert alert-success">Category Updated</div>';
		header("refresh:1;categories.php?do=manag");




   	}
     	


					


     		

}elseif($do=='Delete'){
 if(isset($_GET['id'])&&is_numeric($_GET['id'])){
 	$id=$_GET['id'];
 }
	$st=$con->prepare("DELETE FROM categories WHERE ID =:X") ;
     $st->bindParam(":X",$id);
     $st->execute();
     echo '<div class="alert alert-success">Deleted</div>';
header("refresh:1;categories.php?do=manag");
}elseif($do=='Activ'){


	}



   	
     include $tpl.'footer.php';

   

