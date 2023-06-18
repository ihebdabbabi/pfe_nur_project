<?php


session_start();
error_reporting(E_ERROR);

if($_SESSION['login']=="")
		
	{
		
		?>
	<script type="text/javascript">

alert("Pas d'utilisateur connecté/ Prière de vous connecter");
	window.open("index.php","_self");
</script>
	<?php
		
	}

	
	
	
 include "conn2.php";
 
 
 
 date_default_timezone_set('Africa/Tunis');
	
	


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Orange and Boosted contributors">
    <meta name="generator" content="Hugo 0.101.0">
	<link rel="shortcut icon" type="image/x-icon" href="assets/brand/orange_favicon.ico" />
    <title>Gestion incident</title>

    <link rel="canonical" href="https://boosted.orange.com/docs/5.2/examples/navbar-sticky/">
	 <link rel="canonical" href="https://boosted.orange.com/docs/5.2/examples/sidebars/">

    

    

<link href="assets/dist/css/orange-helvetica.min.css" rel="stylesheet">
<link href="assets/dist/css/boosted.min.css" rel="stylesheet">

    <style>
	a:link { text-decoration: none; }

a:visited { text-decoration: none; }

a:hover { text-decoration: none; }

a:active { text-decoration: none; }
	 a:focus {
            color: #FF7900
         }
	.table1 {
	border: 5px solid;
  border-collapse: collapse;
}
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
	  
	  
	

    

  

     

    
    </style>

    
    <!-- Custom styles for this template -->
    <link href="navbar-sticky.css" rel="stylesheet">
  </head>
  <body>
    <audio id="myAudio">
  <source src="1650.mp3" type="audio/mpeg">
  
</audio>
    
<main>

  <h1 class="visually-hidden">Difference between sticky and fixed navbar</h1>
  <header class="sticky-top">
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark supra" aria-label="Supra navigation - Sticky example">
	

</nav>


    <nav class="navbar navbar-dark bg-dark navbar-expand-lg" aria-label="Global navigation - Sticky example">
  <div class="container-xxl">
    <div class="navbar-brand me-auto me-lg-4">
      <a class="stretched-link" href="#">
        <img src="assets/brand/orange-logo.svg" width="50" height="50" alt="Boosted - Back to Home" loading="lazy">
      </a>
	  <h1 class="title">Gestion incident</h1>
    </div>
    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target=".global-header-1" aria-controls="global-header-1.1 global-header-1.2" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="global-header-2.1" class="navbar-collapse collapse me-lg-auto global-header-2">
      
      <ul class="navbar-nav">
	    <li class="nav-item"><a class="nav-link active" href=../daily2g-nur_T.php>2G</a></li>
        <li class="nav-item"><a class="nav-link" href="radio.php"> 3G</a></li>
		<li class="nav-item"><a class="nav-link" href="env_tech.php"> 4G FDD</a></li>
        <li class="nav-item"><a class="nav-link" href="trans.php"> 4G TDD</a></li>
        <li class="nav-item"><a class="nav-link" href="it.php">GLOBAL</a></li>
        
        
      </ul>
      
    </div>
	
	
	
	
	
	
	
	
	
	
    <div id="global-header-1.2" class="navbar-collapse collapse d-sm-flex global-header-1">
      <ul class="navbar-nav flex-row">
     
        
        
		
		
		
			
<div class="dropdown">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
       <img src="assets/dist/img/Avatar_1.png" alt="" width="40" height="40">
        <strong><?php echo $_SESSION['login'];?></strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
        <li><a class="dropdown-item" href="#">New project...</a></li>
        <li><a class="dropdown-item" href="#">Settings</a></li>
      
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="index.php">Sign out</a></li>
      </ul>
    </div>
  </div>
  
  
      </ul>
    </div>
  </div>
</nav>

  </header>
 <div class="container-xxl pt-5">
    <div class="row mx-0">
     <p style="font-size:400%;color: #FF7900"><strong>Gestion de suivie de qualité réseaux</strong></p>
    </div>
    <div class="row m-0 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-6 g-3 py-1">
  <div class="col m-0 py-2">
        <div class="card border-0">
        <a href="../charts_2g_T.php" target="_blank"><svg class="bd-placeholder-img card-img-top" width="100%" height="0" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#ddd"/><text x="50%" y="50%" fill="#999" dy=".3em"><img src="assets/dist/img/Networks_3.png" alt="" width="100%" height="100%" border="5px solid #ccc"></text></svg></a>

          <div class="card-body bg-dark">
            <center><h4 class="card-title"><a href="../charts_2g_T.php" target="_blank">chart 2G_T</a></h4></center>
          </div>
          
        </div>
      </div>

  <div class="col m-0 py-2">
        <div class="card border-0">
        <a href="../charts_3g_T.php" target="_blank"><svg class="bd-placeholder-img card-img-top" width="100%" height="0" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#ddd"/><text x="50%" y="50%" fill="#999" dy=".3em"><img src="assets/dist/img/Networks_2.png"  alt="" width="100%" height="100%" border="5px solid #ccc"></text></svg></a>

          <div class="card-body bg-dark">
            <center><h4 class="card-title"><a href="../charts_3g_T.php" target="_blank">chart 3G_T</a></h4></center>
          </div>
          
        </div>
      </div>

  <div class="col m-0 py-2">
        <div class="card border-0">
        <a href="../charts_4g_fdd.php" target="_blank"><svg class="bd-placeholder-img card-img-top" width="100%" height="0" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#ddd"/><text x="50%" y="50%" fill="#999" dy=".3em"><img src="assets/dist/img/Networks_1.png"  alt="" width="100%" height="100%" border="5px solid #ccc"></text></svg></a>

          <div class="card-body bg-dark">
            <center><h4 class="card-title"><a href="../charts_4g_fdd.php" target="_blank">chart 4G_T_FDD</a></h4></center>
          </div>
          
        </div>
      </div>

      <div class="col m-0 py-2">
        <div class="card border-0">
        <a href="../charts_4g_tdd.php" target="_blank"><svg class="bd-placeholder-img card-img-top" width="100%" height="0" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#ddd"/><text x="50%" y="50%" fill="#999" dy=".3em"><img src="assets/dist/img/Networks.png"  alt="" width="100%" height="100%" border="5px solid #ccc"></text></svg></a>

          <div class="card-body bg-dark">
            <center><h4 class="card-title"><a href="../charts_4g_tdd.php" target="_blank">chart 4G_T_TDD</a></h4></center>
          </div>
          
        </div>
      </div>


      <div class="col m-0 py-2">
        <div class="card border-0">
        <a href="../charts_3g_works.php" target="_blank"><svg class="bd-placeholder-img card-img-top" width="100%" height="0" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#ddd"/><text x="50%" y="50%" fill="#999" dy=".3em"><img src="assets/dist/img/Display_List_2.png"  alt="" width="100%" height="100%" border="5px solid #ccc"></text></svg></a>

          <div class="card-body bg-dark">
            <center><h4 class="card-title"><a href="../charts_3g_works.php" target="_blank">chart 3G WORKS</a></h4></center>
          </div>
          
        </div>
      </div>

    <div class="col m-0 py-2">
        <div class="card border-0">
        <a href="../charts_4g_works_fdd.php" target="_blank"><svg class="bd-placeholder-img card-img-top" width="100%" height="0" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#ddd"/><text x="50%" y="50%" fill="#999" dy=".3em"><img src="assets/dist/img/Display_List_1.png"  alt="" width="100%" height="100%" border="5px solid #ccc"></text></svg></a>

          <div class="card-body bg-dark">
            <center><h4 class="card-title"><a href="../charts_4g_works_fdd.php" target="_blank">chart 4G Works FDD</a></h4></center>
          </div>
          
        </div>
      </div>

      <div class="col m-0 py-2">
        <div class="card border-0">
        <a href="../charts_4g_works_tdd.php" target="_blank"><svg class="bd-placeholder-img card-img-top" width="100%" height="0" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#ddd"/><text x="50%" y="50%" fill="#999" dy=".3em"><img src="assets/dist/img/Display_List_1.png"  alt="" width="100%" height="100%" border="5px solid #ccc"></text></svg></a>

          <div class="card-body bg-dark">
            <center><h4 class="card-title"><a href="../charts_4g_works_tdd.php" target="_blank">charts 4G Works TDD</a></h4></center>
          </div>
          
        </div>
      </div>
      <div class="col m-0 py-2">
        <div class="card border-0">
        <a href="../Nur_B_2G.php" target="_blank"><svg class="bd-placeholder-img card-img-top" width="100%" height="0" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#ddd"/><text x="50%" y="50%" fill="#999" dy=".3em"><img src="assets/dist/img/Graph_Column_chart_3.png"  alt="" width="100%" height="100%" border="5px solid #ccc"></text></svg></a>

          <div class="card-body bg-dark">
            <center><h4 class="card-title"><a href="../Nur_B_2G.php" target="_blank">Nur_B_2G</a></h4></center>
          </div>
          
        </div>
      </div>




      <div class="col m-0 py-2">
        <div class="card border-0">
        <a href="../Nur_B_4G_FDD.php" target="_blank"><svg class="bd-placeholder-img card-img-top" width="100%" height="0" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#ddd"/><text x="50%" y="50%" fill="#999" dy=".3em"><img src="assets/dist/img/Graph_Column_chart_1.png"  alt="" width="100%" height="100%" border="5px solid #ccc"></text></svg></a>

          <div class="card-body bg-dark">
            <center><h4 class="card-title"><a href="../Nur_B_4G_FDD.php" target="_blank">Nur_B_4G_FDD</a></h4></center>
          </div>
          
        </div>
      </div>
      <div class="col m-0 py-2">
        <div class="card border-0">
        <a href="../Nur_B_4G_TDD.php" target="_blank"><svg class="bd-placeholder-img card-img-top" width="100%" height="0" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#ddd"/><text x="50%" y="50%" fill="#999" dy=".3em"><img src="assets/dist/img/Graph_Column_chart_2.png"  alt="" width="100%" height="100%" border="5px solid #ccc"></text></svg></a>

          <div class="card-body bg-dark">
            <center><h4 class="card-title"><a href="../Nur_B_4G_TDD.php" target="_blank">Nur_B_4G_TDD</a></h4></center>
          </div>
          
        </div>
      </div>







      <div class="col m-0 py-2">
        <div class="card border-0">
        <a href="../Nur_B_3G.php" target="_blank"><svg class="bd-placeholder-img card-img-top" width="100%" height="0" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Image cap" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#ddd"/><text x="50%" y="50%" fill="#999" dy=".3em"><img src="assets/dist/img/Graph_Column_chart.png"  alt="" width="100%" height="100%" border="5px solid #ccc"></text></svg></a>

          <div class="card-body bg-dark">
            <center><h4 class="card-title"><a href="../Nur_B_3G.php" target="_blank">Nur_B_3G</a></h4></center>
          </div>
          
        </div>
      </div>

    </div>
  </div>
</main>


	
    <script src="assets/dist/js/boosted.bundle.min.js"></script>

      <script src="sidebars.js"></script>
  </body>
</html>
<?php



	
	
?>