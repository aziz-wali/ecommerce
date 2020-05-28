<?php
session_start();
$titel=' profile';
include "init.php";
include 'includes/templates/navbar.php';


if(isset($_GET['id'])){
	$id=$_GET['id'];
}
$st=$con->prepare("SELECT * FROM users WHERE userID=?");
$st->execute(array($id));
$info= $st->fetch();

?>


<div class="information block">
	<div class="container">
		
		<div class="panel panel-primary">
			<h1 class="text-center pagename">Profile</h1>
			<div class="panel-heading">Information</div>
			<div class="row">
			  <div class="panel-body col-md-9" >
				<ul class="list-unstyled ">
					<li >  <?php  echo '<i class="far fa-user"></i> Name : '. $info['username'];?></li>
                    <li >  <?php  echo '<i class="fas fa-file-signature"></i> Full Name : '. $info['fullname'];?></li>
                    <li >  <?php  echo '<i class="far fa-calendar-alt"></i> Member since: '. $info['Date'];?></li>
                    <li >  <?php  echo '<i class="fas fa-envelope-open-text"></i> Email: '. $info['email'];?></li>
				    <li >  <?php  echo '<i class="fas fa-map-marked"></i> Address: '. $info['address'];?></li>
                    
                </ul>
          </div>
        <div class="col-md-3"> 
			<div class="image">
             <img src='<?php echo "upload/imag//".$info['imag']; ?>'>
				</div>
          </div>

</div>
</div><hr class="separator">
</div>
	
<div class="container">

<?php
$st=$con->prepare("SELECT * FROM item WHERE member_id=?");
$st->execute(array($id));
$infos= $st->fetchAll();
?>
<div class="panel2 panel-primary">
			<div class="text-center pagename " style="font-size: 20px; margin-bottom: 40px;"> Items</div>
			  <div class="panel-body-items ">

			  	<?php 
echo '<div class="row">';
			  	foreach($infos as $info ){
			  		
			  	echo '<div class="col-md-4">';
				echo '<ul class="list-unstyled">';
				 echo'<li><img class="img-item-profile"'. 'src="'.'upload/imag/'.$info['imag'].'"' .'</li></br>';

				 echo '<li>Item name: '.'<a href="items.php?itemid='.$info['itemid'].'"'.'>'. $info['name'].'</a>'.'</li>';
                     echo '<li> price: :'. $info['price'].'</li>';
                       echo '<li>Date:'. $info['date'].'<li>';
            echo '</ul>';
                     echo '</div>';}  ?>

          
</div>
</div>
</div>


	




		


<?php   include "includes/templates/footer.php"?>