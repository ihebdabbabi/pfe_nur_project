 <?php
session_start();




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel="stylesheet" type="text/css" href="css/page4.css" media="all"/>
<link rel="shortcut icon" type="image/x-icon" href="img/1200px-Orange_logo.svg.png" />

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nouveau utilisateur</title>
 
  <style type="text/css">
	  



  body,td,th {
    font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif;
}
  </style>
  <script src="js/jquery-1.12.4.js"></script>
  <script src="js/jquery-ui.js"></script>
 <script src="js/timepicker.js"></script>
 

<style>
	.time-input{
		padding:10px;
		border-radius:5px;
		border:solid 1px #ccc;
		width:90px;
	}
</style>










</head>
<body>
	

<div style="position: absolute; top: 40px; left: 30px;">
        <a href="../menu/maquette.php">
            <img src="../menu/logo-orange" alt="Description de l'image">
        </a>
    </div>
	
	<p style="text-align: center; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif; font-size: 36px;"><strong>Ajouter utilisateur</strong></p>
	


<p>&nbsp; </p> 
	




<table align="center">
  
<form action="" method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<tr>
  <td width="163" style="font-size: 18px"><p><strong>Login</strong></p></td>
	  <td width="266" style="font-size: 18px"><p>
    <input type="text" name="login" required>
    </p></td>
</tr>


<td width="163" style="font-size: 18px"><p><strong>Mot de passe </strong></p></td>
	  <td width="266" style="font-size: 18px"><p>
    <input type="password" name="password" required >
    </p></td>

</tr>

<tr>
<td width="163" style="font-size: 18px">
  <p><strong>Role</strong></p>
</td>
<td width="266" style="font-size: 18px">
  <p>
    <label>
      <input type="radio" name="usertype" value="admin" required> Admin
    </label>
    <br>
    <label>
      <input type="radio" name="usertype" value="user" required> User
    </label>
  </p>
</td>

</tr>

<tr>
  <td width="163" style="font-size: 18px"><p><strong>Email</strong></p></td>
	  <td width="266" style="font-size: 18px"><p>
    <input type="email" name="mail" required>
    </p></td>
</tr>

<tr>
  <td width="163" style="font-size: 18px"><p><strong>Tel</strong></p></td>
	  <td width="266" style="font-size: 18px"><p>
    <input type="tel" name="tel" pattern="\d{8}" title="Veuillez entrer un numéro de téléphone valide (8 chiffres)" required>
    </p></td>
</tr>




<tr><td><input type="submit" value="Enregistrer l'utilisateur" name="add" class="submitstyle"></td>
</tr>
	</form>
	
	<?php
// Connexion ï¿½ MySQL
$connection=mysqli_connect("localhost", "root", "", "pfe") or die("Connection failed");
 

if (!$connection){ // Contrï¿½ler la connexion
    $MessageConnexion = die ("connection impossible");
}
else {
	
if(isset($_POST['add'])){ // Autre contrï¿½le pour vï¿½rifier si la variable $_POST['Bouton'] est bien dï¿½finie
  
	$login = $_POST["login"];
    $password = $_POST["password"];
    $usertype = $_POST["usertype"];
    $mail = $_POST["mail"];
    $tel = $_POST["tel"];

    // Validate phone number format
    if (!preg_match("/^\d{8}$/", $tel)) {
      echo "Numéro de téléphone invalide. Veuillez entrer un numéro de téléphone valide.";
      exit;
  }

$user_existe="";
 $sql = "SELECT * FROM utilisateur where Login like'$login'";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
$user_existe=$row["Login"]; 
	?>
	<script type="text/javascript">

alert("Cet utilisateur existe déjà ");
</script>
	<?php	
        
    }
	} else {
   

if($login!=$user_existe)
{
 $sql2="INSERT INTO utilisateur (Login, Password, usertype, Mail, Tel) VALUES ('$login', '$password', '$usertype', '$mail', '$tel')";

   // Exï¿½cution de la reqï¿½te
   mysqli_query($connection, $sql2) or die('Erreur SQL !'.$sql2.'<br>'.mysqli_error($connection));
	
	?>
	<script type="text/javascript">

alert("L'utilisateur a \351t\351 bien enregistr\351");
</script>
	<?php	
	
}
	
	

}
	
	
	
} 
$connection->close();
   
}


?>



</body>



</html>