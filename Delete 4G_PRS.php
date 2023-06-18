<?php
$cnx = mysqli_connect("localhost", "root", "", "pfe") or die("Connection failed");

if (isset($_GET['delete_table'])) {
    if ($_GET['delete_table'] === '1') {
        // Afficher le message de confirmation
        echo '
        <script>
            var confirmed = confirm("Are you sure you want to delete the table?");
            if (confirmed) {
                window.location.href = "Delete 4G_PRS.php?delete_table=confirmed";
            } else {
                window.location.href = "daily4g-fdd-final.php";
            }
        </script>';
    } elseif ($_GET['delete_table'] === 'confirmed') {
        // Perform the DROP TABLE operation
        $query = "TRUNCATE TABLE `pfe`.`4g_prs`";
        $result = mysqli_query($cnx, $query);

        if ($result) {
            echo "Table deleted successfully.";
        } else {
            echo "Failed to delete table.";
        }
    }
}
?>