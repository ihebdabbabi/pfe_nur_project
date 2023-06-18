
<!DOCTYPE html>
<html>
<head>
<title>Daily-3G</title>
<style> 
table{border-collapse: collapse; }
td,th  {border: 1px solid black;}
th{color: black; background-color: #f07900;}
tbody{background-color: #67b4e7}
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.5/css/buttons.dataTables.min.css">


</head>
<body>

<div style="display: flex; align-items: center; justify-content: flex-end; margin-top: 10px; margin-right: 10px;">
    <div style="flex-grow: 1;"></div>
    <a href="../importation/import daily3G.php" style="margin-right: 10px; padding: 5px 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Import</a>
    <a href="../Delete 3G_PRS.php?delete_table=1" style="padding: 5px 10px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 4px;">Delete Table</a>
</div>

<form action="<?php echo $_SERVER['PHP_SELF'  ]; ?>" method="POST">

<div>
    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date">
    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date">
    <input type="submit" value="Submit" name="send">

</div>
</form>

<form action="" method="POST" style="display:inline">
<input type="submit" name="myBtn" value="return">
</form>

<tbody>
<?php
 $cnx=mysqli_connect("localhost","root","","pfe") or die("connection failed");

 $start_Date = '';
$end_Date = '' ;

if (isset($_POST['send'])) {
    $start_Date = $_POST['start_date']; 
    $end_Date = $_POST['end_date'];
    echo $start_Date.' '.$end_Date .'<br>';
    
    $diff = strtotime($end_Date) - strtotime($start_Date);
    $days = ($diff / (60 * 60 * 24));
    
    echo 'le nbr de jours est     '. $days + 1 ; 

    
    $NUR_WORKS_3G = "SELECT ((select SUM(b.Indisponibilite_works_3g) from (SELECT DISTINCT(Cell_Name) FROM `3g_filtre`) a , 
    (SELECT DISTINCT(Cell_Name),Indisponibilite_works_3g FROM `3g_prs` group by Cell_Name) b where a.Cell_Name=b.Cell_Name ) * pow(10, 5))
       / 
    ((SELECT COUNT(Cell_Name) FROM 3G_filtre) *60 * 60 * 24 * $days) AS di_3g_avg_works FROM 3g_prs";
    
    $res_NUR_WORKS_3G= mysqli_query($cnx,$NUR_WORKS_3G);   
    
    if (!$res_NUR_WORKS_3G) {
        printf("Error: %s\n", mysqli_error($cnx));
        exit();
    }
    
    $row = mysqli_fetch_array($res_NUR_WORKS_3G);
    $di_3g_avg_works = $row['di_3g_avg_works'] ;
    
    echo "\n NUR-WORKS-3G :". $di_3g_avg_works ; 
    $update_query = "UPDATE 3g_prs SET di_3g_avg_works = $di_3g_avg_works";
    mysqli_query($cnx, $update_query);


    

    $nur_3g_T = "SELECT ((select SUM(b.DI_3g_Minute) from (SELECT DISTINCT(Cell_Name) FROM `3g_filtre`) a ,
     (SELECT DISTINCT(Cell_Name),DI_3g_Minute FROM `3g_prs` group by Cell_Name) b where a.Cell_Name=b.Cell_Name ) * pow(10, 5))
      / ((SELECT COUNT(Cell_Name) FROM 3G_filtre) * 60 * 24 * $days) AS di_3g_avg FROM 3g_prs";

    $res_nur_3g = mysqli_query($cnx, $nur_3g_T);
    
    if (!$res_nur_3g) {
        printf("Error: %s\n", mysqli_error($cnx));
        exit();
    }
    
    $row = mysqli_fetch_array($res_nur_3g);
    $di_3g_avg = $row['di_3g_avg'] ;

    echo 'NUR-T-3G est'. $di_3g_avg ; 
    $update_query = "UPDATE 3g_prs SET di_3g_avg = $di_3g_avg";
mysqli_query($cnx, $update_query);


$month = date('F Y', strtotime($start_Date));

// Check if a row exists for the given month
$select_query = "SELECT * FROM monthly_results WHERE month = '$month'";
$result = mysqli_query($cnx, $select_query);

if (mysqli_num_rows($result) > 0) {
  // Update the existing row
  $update_query = "UPDATE monthly_results SET nur_T_3G = $di_3g_avg, nur_works_3G = $di_3g_avg_works WHERE month = '$month'";
  mysqli_query($cnx, $update_query);
} else {
  // Insert a new row
  $insert_query = "INSERT INTO monthly_results (month, nur_T_3G, nur_works_3G) VALUES ('$month', $di_3g_avg, $di_3g_avg_works)";
  mysqli_query($cnx, $insert_query);
}





?>
<table id="example" class="display nowrap" style="width:100%">
<thead>
<tr> 
    <th>Cell Name</th>
    <th>Count</th>
    <th>Total 1</th>
    <th>Total 2</th>

</tr>
</thead>   
<?php
     

     // Query to fetch data from 3g_prs table within the specified date range and filtered by the cell names in 3g_filtre table
$query1 = "SELECT Cell_Name, VSCellUnavailTime, VSCellUnavailTimeSys FROM 3g_prs
WHERE Date >= '$start_Date' AND Date <= '$end_Date'
AND Cell_Name IN (SELECT Cell_Name FROM 3g_filtre)";

$result1 = mysqli_query($cnx, $query1);

// Initialize an empty array to store the count and total for each unique cell name
$cellData = array();

// Loop through each row in the result set and calculate the count and total for each unique cell name
while ($row = mysqli_fetch_array($result1)) {
$cellName = $row['Cell_Name'];
$count = isset($cellData[$cellName]['count']) ? $cellData[$cellName]['count'] : 0;
$count += 1;

$total1 = isset($cellData[$cellName]['total1']) ? $cellData[$cellName]['total1'] : 0;
$total1 += $row['VSCellUnavailTime'];

$total2 = isset($cellData[$cellName]['total2']) ? $cellData[$cellName]['total2'] : 0;
$total2 += $row['VSCellUnavailTimeSys'];

$cellData[$cellName] = array('count' => $count, 'total1' => $total1, 'total2' => $total2);
}

// Loop through each unique cell name and display the count and total for that cell
foreach ($cellData as $cellName => $data) {
?>
<tr>
<td><?php echo $cellName ?></td>
<td><?php echo $data['count'] ?></td>
<td><?php echo $data['total1'] ?></td>
<td><?php echo $data['total2'] ?></td>
</tr>
<?php
}
}




if(isset($_POST['myBtn'])) {
?>

<table id="example" class="display nowrap" style="width:100%">
<thead>
<tr> 
    <th>Date</th>
    
    <th>Cell_ID</th>
    <th>Cell_Name</th>
    <th>NodeB_Name</th>
    <th>Integrity</th>
    <th>VSCellUnavailTime</th>
    <th>VSCellUnavailTimeSys</th>
    <th>Indisponibilite_3g</th>
    <th>Indisponibilite_works_3g</th>
 
    <th>DI_3g_Minute</th>
    <th>DI_3g_Heure</th>
    <th>DI_3g_Jour</th>
   
    
      
</tr>
</thead>
<?php

       $cnx=mysqli_connect("localhost","root","","pfe") or die("connection failed");
    




   

 $query7 = "UPDATE 3g_prs SET Indisponibilite_3g =
                               `VSCellUnavailTime` + `VSCellUnavailTimeSys`";
        $reslut7= mysqli_query($cnx,$query7);     

 $query6 = "UPDATE 3g_prs SET DI_3g_Jour =
                        `Indisponibilite_3g` /86400";
             $reslut6= mysqli_query($cnx,$query6);     
 
 $query5 = "UPDATE 3g_prs SET DI_3g_Heure =
                             `Indisponibilite_3g` /3600";
         $reslut5= mysqli_query($cnx,$query5);      


 
 $query4 = "UPDATE 3g_prs SET DI_3g_Minute =
                             `Indisponibilite_3g` /60";
         $reslut4= mysqli_query($cnx,$query4);      
 
 $query3 = "UPDATE 3g_prs SET Indisponibilite_works_3g =
                             `VSCellUnavailTime` ";
    $reslut3= mysqli_query($cnx,$query3);       


    mysqli_query($cnx, "TRUNCATE TABLE 3g_filtre"); 
 
    $query1 = "SELECT DISTINCT Cell_Name, Activity_Status FROM 3G_U2020 WHERE Activity_Status = 'Activated' 
    and SUBSTR(Cell_Name, 1, 8) IN (SELECT Sites FROM ssvok_test)";

$result1=mysqli_query($cnx,$query1);




$sql_create_table = "CREATE TABLE IF NOT EXISTS 3g_filtre (

Cell_Name VARCHAR(255),
Activity_Status	varchar(10)
)";
mysqli_query($cnx, $sql_create_table);


if(mysqli_num_rows($result1) > 0) {

while($ligne = mysqli_fetch_array($result1)) {

$sql_insert = "INSERT INTO 3g_filtre ( Cell_Name, Activity_Status) 
VALUES ( '".$ligne['Cell_Name']."', '".$ligne['Activity_Status']."')";
mysqli_query($cnx, $sql_insert);

}
}


$query2 = "SELECT Cell_Name FROM 3g_filtre WHERE Cell_Name IN (SELECT Cell_Name FROM 3g_prs)";
   $query3 = "SELECT Date, Cell_ID, Cell_Name, NodeB_Name, Integrity, VSCellUnavailTime, VSCellUnavailTimeSys, Indisponibilite_3g,Indisponibilite_works_3g, DI_3g_Minute, DI_3g_Heure, DI_3g_Jour FROM 3g_prs";
   
   $query = "SELECT t3.Date, t3.Cell_ID, t2.Cell_Name, t3.NodeB_Name, t3.Integrity, t3.VSCellUnavailTime, t3.VSCellUnavailTimeSys, t3.Indisponibilite_3g, t3.Indisponibilite_works_3g, t3.DI_3g_Minute ,t3.DI_3g_Heure, t3.DI_3g_Jour
             FROM ($query2) AS t2
             JOIN ($query3) AS t3 ON t2.Cell_Name = t3.Cell_Name";
   
   $result = mysqli_query($cnx, $query);
   
$rowCount = mysqli_num_rows($result);  // Total number of rows in the result

if ($rowCount > 0) {
    $totalRowsToShow = mysqli_num_rows(mysqli_query($cnx, $query2));  // Total number of rows in query2

    // Display only the first $totalRowsToShow rows
    for ($i = 0; $i < $totalRowsToShow; $i++) {
        $ligne = mysqli_fetch_array($result);
        // Code to display the query result
    ?>
    <tr>
        <td><?php echo $ligne['Date'] ?></td>
        <td><?php echo $ligne['Cell_ID'] ?></td>
        <td><?php echo $ligne['Cell_Name'] ?></td>
        <td><?php echo $ligne['NodeB_Name'] ?></td>
        <td><?php echo $ligne['Integrity'] ?></td>
        <td><?php echo $ligne['VSCellUnavailTime'] ?></td>
        <td><?php echo $ligne['VSCellUnavailTimeSys'] ?></td>
        <td><?php echo $ligne['Indisponibilite_3g'] ?></td>
        <td><?php echo $ligne['Indisponibilite_works_3g'] ?></td>
        <td><?php echo $ligne['DI_3g_Minute'] ?></td>
        <td><?php echo $ligne['DI_3g_Heure'] ?></td>
        <td><?php echo $ligne['DI_3g_Jour'] ?></td>
        
    </tr>
    <?php
}
}
}
  ?>  
 </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.5.1.js"> </script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"> </script>
<script src="https://cdn.datatables.net/buttons/2.3.5/js/dataTables.buttons.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"> </script>
<script src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.html5.min.js"> </script>
<script src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.print.min.js"> </script>

<script> 
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>

</body>
</html>
