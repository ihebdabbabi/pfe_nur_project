<?php
$cnx = mysqli_connect("localhost", "root", "", "pfe") or die("Connection failed");

if (isset($_GET['delete_table'])) {
    if ($_GET['delete_table'] === '1') {
        // Afficher le message de confirmation
        echo '
        <script>
            var confirmed = confirm("Are you sure you want to delete the table?");
            if (confirmed) {
                window.location.href = "Delete nur_b_4g_fdd.php?delete_table=confirmed";
            } else {
                window.location.href = "nur_b_4g_fdd2.php";
            }
        </script>';
    } elseif ($_GET['delete_table'] === 'confirmed') {
        // Perform the DROP TABLE operation
        $query = "TRUNCATE TABLE `pfe`.`nur_b_4g_fdd`";
        $result = mysqli_query($cnx, $query);

        if ($result) {
            echo "Table deleted successfully.";
        } else {
            echo "Failed to delete table.";
        }
    }
}
?>