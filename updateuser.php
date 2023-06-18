<form method="POST" >
    <input type="text" name="login" placeholder="Login" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="text" name="usertype" placeholder="User Type" required><br>
    <input type="email" name="mail" placeholder="Email" required><br>
    <input type="tel" name="tel" placeholder="Phone Number" required><br>
    <input type="submit" value="Update">
</form>


<?php

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs du formulaire
    $login = $_POST['login'];
    $password = $_POST['password'];
    $usertype = $_POST['usertype'];
    $mail = $_POST['mail'];
    $tel = $_POST['tel'];

    // Connexion à la base de données
    $cnx = mysqli_connect("localhost", "root", "", "pfe") or die("Connection failed");

    // Échapper les valeurs pour éviter les injections SQL
    $login = mysqli_real_escape_string($cnx, $login);
    $password = mysqli_real_escape_string($cnx, $password);
    $usertype = mysqli_real_escape_string($cnx, $usertype);
    $mail = mysqli_real_escape_string($cnx, $mail);
    $tel = mysqli_real_escape_string($cnx, $tel);

    // Exécuter la requête de mise à jour
    $query = "UPDATE utilisateur SET Password='$password', usertype='$usertype', Mail='$mail', Tel='$tel' WHERE Login='$login'";
    $result = mysqli_query($cnx, $query);

    // Vérifier si la mise à jour a réussi
    if ($result) {
        echo "Mise à jour effectuée avec succès!";
    } else {
        echo "Échec de la mise à jour: " . mysqli_error($cnx);
    }

    // Fermer la connexion à la base de données
    mysqli_close($cnx);
}
?>
