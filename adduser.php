<?php
$cnx = mysqli_connect("localhost", "root", "", "pfe") or die("Connection failed");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];
    $usertype = $_POST["usertype"];
    $mail = $_POST["mail"];
    $tel = $_POST["tel"];

    // Perform the insert operation
    $query = "INSERT INTO utilisateur (Login, Password, usertype, Mail, Tel) VALUES ('$login', '$password', '$usertype', '$mail', '$tel')";
    $result = mysqli_query($cnx, $query);

    if ($result) {
        echo "User added successfully.";
    } else {
        echo "Failed to add user.";
    }
}

mysqli_close($cnx);

?>
<form method="POST">
    <input type="text" name="login" placeholder="Login" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="text" name="usertype" placeholder="User Type" required><br>
    <input type="email" name="mail" placeholder="Email" required><br>
    <input type="tel" name="tel" placeholder="Phone Number" required><br>
    <input type="submit" value="Add User">
</form>
