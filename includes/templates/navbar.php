<nav class="navbar navbar-expand-lg navbar-light bg-light">
 <a class="navbar-brand" href="index.php">

  <span style="color:#3498db"><b>S</b></span>
  <span style="color:#2ecc71"><b>H</b></span>
  <span style="color:#e74c3c"><b>O</b></span>
  <span style="color:#1abc9c">P</span> 
  <span style="color:#2980b9"><b></b></span>
  <span style="color:#e74c3c"><b></b></span>

</a>




 <!------------------------------------------------------------------->
 <button class="navbar-toggler" type="button" data-toggle="collapse"
  data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
   aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  
  
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item ">
          <a class="nav-link" href="all.php">All Items <span class="sr-only">(current)</span></a>
          <i class="fas fa-angle-down"></i>
        </li> 
   
       <?php
    
        include "connect.php";
         $st=$con->prepare("SELECT * FROM categories order by ID ASC");
         $st->execute();
         $rows =$st->fetchAll();
         foreach ($rows as $cat){
          echo'<li class="nav-item" >'.'<a class="nav-link" href="categories.php?id='.$cat['ID'].'&pagename='
          .$cat['cat_name'].'">'.$cat['cat_name'] .'</a>'.'</li>';
         }
         
        ?>
   </ul>

<div class="sub-menu">
   <ul>
     <li>TEST</li>
     <li>TEST2</li>
     <li>TEST</li>
     <li>TEST2</li>
     <li>TEST</li>
     <li>TEST2</li>
     <li>TEST</li>
     <li>TEST</li>
     <li>TEST2</li>
     <li>TEST</li>
     <li>TEST2</li>
     <li>TEST</li>
     <li>TEST2</li>
     <li>TEST</li>
     <li>TEST2</li>
     <li>TEST2</li>
   </ul>
 </div>

</div>
        
 
</nav>
