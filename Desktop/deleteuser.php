<?php
$cnx = mysqli_connect("localhost", "root", "", "pfe") or die("Connection failed");

if (isset($_GET['deletelogin'])) {
    $login = $_GET['deletelogin'];

    if (isset($_GET['confirm'])) {
        $confirm = $_GET['confirm'];

        if ($confirm === 'yes') {
            // Perform the delete operation
            $query = "DELETE FROM utilisateur WHERE Login = '$login'";
            $result = mysqli_query($cnx, $query);

            if ($result) {
                echo "User deleted successfully.";
            } else {
                echo "Failed to delete user.";
            }
        } else {
            echo "Delete operation cancelled.";
        }
    } else {
        // Ask for confirmation
        echo '
        <script>
            var confirmed = confirm("Are you sure you want to delete the user?");
            if (confirmed) {
                window.location.href = "?deletelogin=' . $login . '&confirm=yes";
            } else {
                history.back(); // Go back to the previous page
            }
        </script>';
    }
}

mysqli_close($cnx);
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



</body>
</html>

