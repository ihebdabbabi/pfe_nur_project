
<?php
// Détruisez la session existante (assurez-vous que session_start() a été appelé au début de votre fichier)
session_start();
session_destroy();

// Redirigez l'utilisateur vers la page de connexion ou toute autre page appropriée
header("Location: index.php");
exit();
?>
