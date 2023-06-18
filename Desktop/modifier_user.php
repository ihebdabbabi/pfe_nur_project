<?php
session_start();

// Connexion à MySQL
$connection = mysqli_connect("localhost", "root", "", "pfe") or die("Connection failed");

if (!$connection) { // Contrôler la connexion
    $MessageConnexion = die("Connection impossible");
} else {

    if (isset($_GET['updatelogin'])) { // Check if the 'updatelogin' parameter is present in the URL

        // Récupérer le login de l'utilisateur sélectionné dans l'URL
        $login = $_GET['updatelogin'];

        // Exécuter la requête pour récupérer les informations de l'utilisateur
        $query = "SELECT * FROM utilisateur WHERE Login='$login'";
        $result = mysqli_query($connection, $query);

        // Vérifier si l'utilisateur existe
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $oldLogin = $row["Login"];
            $password = $row["Password"];
            $usertype = $row["usertype"];
            $mail = $row["Mail"];
            $tel = $row["Tel"];
        } else {
            echo "Utilisateur non trouvé.";
            exit; // Stop further execution if user not found
        }
    }

    if (isset($_POST['update'])) { // Check if the form is submitted

        $oldLogin = $_POST["old_login"];
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

        $login = mysqli_real_escape_string($connection, $login);
        $password = mysqli_real_escape_string($connection, $password);
        $usertype = mysqli_real_escape_string($connection, $usertype);
        $mail = mysqli_real_escape_string($connection, $mail);
        $tel = mysqli_real_escape_string($connection, $tel);

        // Exécuter la requête de mise à jour
        $query = "UPDATE utilisateur SET Login='$login', Password='$password', usertype='$usertype', Mail='$mail', Tel='$tel' WHERE Login='$oldLogin'";
        $result = mysqli_query($connection, $query);

        // Vérifier si la mise à jour a réussi
        if ($result) {
            echo "Mise à jour effectuée avec succès!";
        } else {
            echo "Échec de la mise à jour: " . mysqli_error($connection);
        }
    }

    // Fermer la connexion à la base de données
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/page4.css" media="all"/>
    <link rel="shortcut icon" type="image/x-icon" href="img/1200px-Orange_logo.svg.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nouveau utilisateur</title>
    <style type="text/css">
        body, td, th {
            font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif;
        }
    </style>
    <script src="js/jquery-1.12.4.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/timepicker.js"></script>
    <style>
        .time-input {
            padding: 10px;
            border-radius: 5px;
            border: solid 1px #ccc;
            width: 90px;
        }
    </style>
</head>
<body>
<div style="position: absolute; top: 40px; left: 30px;">
    <a href="../profile.php">
        <img src="../menu/logo-orange" alt="Description de l'image">
    </a>
</div>
<p style="text-align: center; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif; font-size: 36px;">
    <strong>Modifier utilisateur</strong></p>
<p>&nbsp;</p>
<table align="center">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?updatelogin=' . $login); ?>" method="post" name="myform">
        <input type="hidden" name="old_login" value="<?php echo isset($oldLogin) ? htmlspecialchars($oldLogin) : ''; ?>">
        <tr>
            <td width="163" style="font-size: 18px">
                <p><strong>Login</strong></p>
            </td>
            <td width="266" style="font-size: 18px">
                <p>
                    <input type="text" name="login" value="<?php echo isset($login) ? htmlspecialchars($login) : ''; ?>" required>
                </p>
            </td>
        </tr>
        <tr>
            <td width="163" style="font-size: 18px">
                <p><strong>Mot de passe</strong></p>
            </td>
            <td width="266" style="font-size: 18px">
                <p>
                    <input type="password" name="password" value="<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>" required>
                </p>
            </td>
        </tr>
        <tr>
            <td width="163" style="font-size: 18px">
                <p><strong>Role</strong></p>
            </td>
            <td width="266" style="font-size: 18px">
                <p>
                    <label>
                        <input type="radio" name="usertype" value="admin" <?php if (isset($usertype) && $usertype == 'admin') echo 'checked'; ?> required> Admin
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="usertype" value="user" <?php if (isset($usertype) && $usertype == 'user') echo 'checked'; ?> required> User
                    </label>
                </p>
            </td>
        </tr>
        <tr>
            <td width="163" style="font-size: 18px">
                <p><strong>Mail</strong></p>
            </td>
            <td width="266" style="font-size: 18px">
                <p>
                    <input type="email" name="mail" value="<?php echo isset($mail) ? htmlspecialchars($mail) : ''; ?>" required>
                </p>
            </td>
        </tr>
        <tr>
            <td width="163" style="font-size: 18px">
                <p><strong>Tel</strong></p>
            </td>
            <td width="266" style="font-size: 18px">
                <p>
                <input type="tel" name="tel" pattern="\d{8}" title="Veuillez entrer un numéro de téléphone valide (8 chiffres)" value="<?php echo isset($tel) ? htmlspecialchars($tel) : ''; ?>" required>
                </p>
            </td>
        </tr>
        <tr>
            <td><input type="submit" value="Modifier l'utilisateur" name="update" class="submitstyle"></td>
        </tr>
    </form>
</table>
<!-- Reste du code HTML -->
</body>
</html>
