<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="dash.php">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="member.php?do=manag">Members <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="categories.php?do=manag">Categories</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="item.php?do=manag">Items</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="comment.php?do=manag">Comments</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Settings
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="member.php?do=manag&id=<?php echo $_SESSION['id']; ?>">Manage Members</a>
          <a class="dropdown-item" href="member.php?do=Edit&id=<?php echo $_SESSION['id']; ?>">Edit ADMIN</a>
          <a class="dropdown-item" href="../index.php">Shop</a>
          <a class="dropdown-item" href="logout.php">log out</a>
        </div>
      </li>
     
    </ul>
    <form class="form-inline my-2 my-lg-0" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
      <input class="form-control mr-sm-2" type="search" name="search" placeholder="search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
<?php include 'connect.php';
	
	if($_SERVER['REQUEST_METHOD'] ='POST'){
	if(!empty($_POST['search'])){$search =$_POST['search'];
$output = $con -> prepare("SELECT * FROM item WHERE name LIKE :LL ");
	$output->bindValue('LL','%'.$search.'%');
	$output->execute();
	$items =$output->fetchAll();
	foreach($items as $item ){
		echo '<a href="../items.php?itemid='.$item['itemid'].'">'.$item['name'] .'</a><br>';
	
	}}

} ?>