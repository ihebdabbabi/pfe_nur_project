

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Orange and Boosted contributors">
    <meta name="generator" content="Hugo 0.101.0">
	<link rel="shortcut icon" type="image/x-icon" href="assets/brand/orange_favicon.ico" />
    <title>Signin</title>

    <link rel="canonical" href="https://boosted.orange.com/docs/5.2/examples/sign-in/">

    

    

<link href="assets/dist/css/orange-helvetica.min.css" rel="stylesheet">
<link href="assets/dist/css/boosted.min.css" rel="stylesheet">

<script type="text/javascript">
	
	
                
                       
            function openTab(th)
            {
                window.open(th.name,'_blank');
            }

function validate(){
	
	
	var login=document.myform.log.value;
	var passwd=document.myform.pass.value;
	
	
	if ((login=="") || (passwd=="")){
		
		
	
	alert("Merci de saisir votre login et votre mot de passe"); 
	return false;
	}
	
	
}

</script>




    <style>
	
	

a:active { text-decoration: none; }
	 a:focus {
            color: #FF7900
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

      .form-container {
            display: flex;
            justify-content: flex-end;
            margin-right: -400px;
        }
      
      
    </style>

    
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>
  <body class="text-center" background="../menu/background.jpg">
   
   	
   
   
   
   
   <?php

	 
	
		
	// Connexion � MySQL
include "conn.php";
 

if (!$connection){ // Contr�ler la connexion
    $MessageConnexion = die ("connection impossible");
}
else {
   
  
?>




<br>
<table border=0 align="center">


<tr><td><br><br><br><br><br><br></td>
</tr>
<tr><td>
<div class="form-container">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="myform">
   
    <h1 class="h3 mb-3 fw-normal">Veuillez-vous connecter</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" placeholder="login" size="30" name="log">
      
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Mot de passe" size="30" name="pass">
      
    </div>
<br>
    <div class="checkbox mb-3">
      
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit" onClick="return validate();" name="connect">Connection</button>
    
  </form>
</div>
  </tr>
  </table>



    
  </body>
</html>


<?php

$conn = mysqli_connect("localhost", "root", "", "pfe");

if (isset($_POST['connect'])) { // Check if the variable $_POST['connect'] is defined
    $login = $_POST['log'];
    $passw = $_POST['pass'];

    if ($login != "" && $passw != "") {
        session_start();
        $sql = "SELECT * FROM utilisateur WHERE Login='$login' AND Password='$passw'";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res); // Use mysqli_fetch_assoc() instead of mysqli_fetch_array()

        if ($row) {
            if ($row['usertype'] == "admin") {
                $_SESSION['login'] = $login;
                $_SESSION['usertype'] = "admin";
                header('Location: maquette.php');
                exit; // Add an exit statement after header() to stop executing the rest of the code
            } elseif ($row['usertype'] == "user") {
                $_SESSION['login'] = $login;
                $_SESSION['usertype'] = "user";
                header('Location: maquette2.php');
                exit; // Add an exit statement after header() to stop executing the rest of the code
            }
        } else {
            // Display an error message
            echo '<script type="text/javascript">
                alert("Login ou mot de passe incorrect !");
                </script>';
        }
    } else {
        // Display an error message
        echo '<script type="text/javascript">
            alert("Veuillez saisir un login et un mot de passe !");
            </script>';
    }
}

?>



<?php
}
 
	

?>
