
<!DOCTYPE html>
<html>
<head>
<title>2G</title>
<style> 
table{border-collapse: collapse; }
td,th  {border: 1px solid black;}
th{color: black; background-color: #f07900;}
tbody{background-color: #67b4e7;}


</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.5/css/buttons.dataTables.min.css">
   



</head>
<body>

<div style="display: flex; align-items: center; justify-content: flex-end; margin-top: 10px; margin-right: 10px;">
    <div style="flex-grow: 1;"></div>
    <a href="../importation/import daily2G.php" style="margin-right: 10px; padding: 5px 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Import</a>
    <a href="../Delete 2G_PRS.php?delete_table=1" style="padding: 5px 10px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 4px;">Delete Table</a>
</div>



<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

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
$cnx = mysqli_connect("localhost","root","","pfe") or die("connection failed");

$start_Date = '';
$end_Date = '' ;



if (isset($_POST['send'])) {
    $start_Date = $_POST['start_date']; 
    $end_Date = $_POST['end_date'];
    echo $start_Date.' '.$end_Date .'<br>';
    
    $diff = strtotime($end_Date) - strtotime($start_Date);
    $days = ($diff / (60 * 60 * 24)) ;
    
    echo "\n Le nbr de jours :". $days + 1 ; 

//     $query1 = "SELECT Cell_Name FROM 2g_filtre WHERE Cell_Name IN (SELECT Cell_Name FROM 2g_prs)";
// $query2 = "SELECT SUM(DI_2G_min) AS total_DI_2G_min FROM 2g_prs WHERE Cell_Name IN ($query1)";

// $result2 = mysqli_query($cnx, $query2);

// if ($row = mysqli_fetch_assoc($result2)) {
//     $totalDI2Gmin = $row['total_DI_2G_min'];
//     echo "Total DI_2G_min for matching Cell_Name values: " . $totalDI2Gmin;
// }



    $nur_2g_T = "SELECT ((select SUM(b.DI_2G_min) from (SELECT DISTINCT(Cell_Name) FROM `2g_filtre`) a ,
     (SELECT DISTINCT(Cell_Name),DI_2G_min FROM `2g_prs` group by Cell_Name) b where a.Cell_Name=b.Cell_Name) * pow(10, 5)) 
     / ((SELECT COUNT(Cell_Name) FROM 2G_filtre) * 60 * 24 * $days) AS di_2g_avg FROM 2g_prs;"; 

$res_nur_2g = mysqli_query($cnx, $nur_2g_T);

if (!$res_nur_2g) {
    printf("Error: %s\n", mysqli_error($cnx));
    exit();
}

$row = mysqli_fetch_array($res_nur_2g);
$di_2g_avg = $row['di_2g_avg'];

echo "NUR-T-2G est: " . $di_2g_avg;

$update_query = "UPDATE 2g_prs SET di_2g_avg = $di_2g_avg";
mysqli_query($cnx, $update_query);




$nur_T_GL = "SELECT (((SELECT SUM(DI_3g_Minute) from 3g_prs WHERE Cell_Name IN (SELECT Cell_Name from 3g_filtre)) +
 (select SUM(b.DI_2G_min) from (SELECT DISTINCT(Cell_Name) FROM `2g_filtre`) a , (SELECT DISTINCT(Cell_Name),DI_2G_min FROM `2g_prs` group by Cell_Name) b where a.Cell_Name=b.Cell_Name) + 
 (SELECT SUM(Indispo_sys_F_group_DI_min) FROM 4g_prs where Cell_Name IN (SELECT Cell_Name FROM 4g_filtre_fdd)) +
  (SELECT SUM(Indispo_sys_F_group_DI_min) FROM 4g_prs WHERE Cell_Name IN (SELECT Cell_Name FROM 4g_filtre_tdd))) * POW(10, 5) )
      /
   ((((SELECT COUNT(Cell_Name) FROM 4g_filtre_fdd) + (SELECT COUNT(Cell_Name) FROM 4g_filtre_tdd)) +
    (SELECT COUNT(Cell_Name) FROM 3g_filtre) + 
    (SELECT COUNT(Cell_Name) FROM 2g_filtre)) * 60 * 24 * $days);";

$res_nur_T_GL = mysqli_query($cnx, $nur_T_GL);
if (!$res_nur_T_GL) {
printf("Error: %s\n", mysqli_error($cnx));
exit();}

$row = mysqli_fetch_array($res_nur_T_GL);
$nombre = $row[0];

echo "\n NUR-T-G  : " . $nombre;

$update_query = "UPDATE 2g_prs SET res_nur_T_GL = $nombre";
mysqli_query($cnx, $update_query);



$month = date('F Y', strtotime($start_Date));
// Check if a row exists for the given month
$select_query = "SELECT * FROM monthly_results WHERE month = '$month'";
$result = mysqli_query($cnx, $select_query);

if (mysqli_num_rows($result) > 0) {
  // Update the existing row
  $update_query = "UPDATE monthly_results SET nur_T_2G = $di_2g_avg, nur_T_Global = $nombre WHERE month = '$month'";
  mysqli_query($cnx, $update_query);
} else {
  // Insert a new row
  $insert_query = "INSERT INTO monthly_results (month, nur_T_2G, nur_T_Global) VALUES ('$month', $di_2g_avg, $nombre)";
  mysqli_query($cnx, $insert_query);
}




 ?>
    <table id="example" class="display nowrap" style="width:100%" >
<thead>
<tr> 
    <th>Cell CI</th>
    <th>Count</th>
    <th>Totale</th>
   
    
</tr>



</thead>   
 <?php

$query1 = "SELECT Cell_Name FROM 2g_filtre WHERE Cell_Name IN (SELECT Cell_Name FROM 2g_prs)";
$query2 = "SELECT Cell_Name, R373Cell_Out FROM `2g_prs` 
           WHERE Date >= '$start_Date' AND Date <= '$end_Date'";

$query = "SELECT t2.Cell_Name, t2.R373Cell_Out 
          FROM ($query1) AS t1
          JOIN ($query2) AS t2 ON t1.Cell_Name = t2.Cell_Name";

$result = mysqli_query($cnx, $query);

    // Initialize an empty array to store the count and total for each unique cell name
    $cellData = array();

    // Loop through each row in the first result set and calculate the count and total for each unique cell name
    while ($row = mysqli_fetch_array($result)) {
        $cellName = $row['Cell_Name'];
        $count = isset($cellData[$cellName]['count']) ? $cellData[$cellName]['count'] : 0;
        $count += 1;

        $total = isset($cellData[$cellName]['total']) ? $cellData[$cellName]['total'] : 0;
        $total += $row['R373Cell_Out'];
        $cellData[$cellName] = array('count' => $count, 'total' => $total);
    }

    
    // Loop through each unique cell name and display the count and total for that cell
    foreach ($cellData as $cellName => $data) {
        
        ?>
        <tr>
            <td><?php echo $cellName ?></td>
            <td><?php echo $data['count'] ?></td>
            <td><?php echo $data['total'] ?></td>
            
        </tr>
        <?php
    }
    
}

if(isset($_POST['myBtn'])) {
    ?>
    <table id="example" class="display nowrap" style="width:100%" >
<thead>
<tr> 
    <th>Date</th>
    
    <th>Cell Name</th>
    
    <th>R373Cell_Out</th>
    <th>DI_2G_min</th>
    <th>DI_2G_h</th>
    <th>DI_2G_j</th>
    <th>di_2g_avg</th>
   
   <th>res_nur_T_GL</th>
    
 

    
</tr>

</thead>   
 <?php
    $cnx=mysqli_connect("localhost","root","","pfe") or die("connection failed");
    

   


//     $nur_2g_T2 = "UPDATE 2g_prs SET di_2g_avg =  'di_2g_avg'/2'";
// $res_nur_2g2= mysqli_query($cnx, $nur_2g_T2);  




    $query5 = "UPDATE 2g_prs SET DI_2G_j =
                                `R373Cell_Out` /86400";
       $reslut5= mysqli_query($cnx,$query5); 
   
    $query4 = "UPDATE 2g_prs SET DI_2G_h =
    `R373Cell_Out` /3600";
   $reslut4= mysqli_query($cnx,$query4);  
   
    $query3 = "UPDATE 2g_prs SET DI_2G_min =
                                `R373Cell_Out` /60";
       $reslut3= mysqli_query($cnx,$query3); 
   


       mysqli_query($cnx, "TRUNCATE TABLE 2g_filtre");

    $query1 = "SELECT DISTINCT Cell_Name, Activity_Status FROM 2G_U2020 WHERE Activity_Status = 'Activated' 
              AND SUBSTR(Cell_Name, 1, 8) IN (SELECT Sites FROM ssvok_test)";
   
   $result1=mysqli_query($cnx,$query1);


      $sql_create_table = "CREATE TABLE IF NOT EXISTS 2g_filtre (
        
        Cell_Name VARCHAR(255),
        Activity_Status	varchar(10)
    )";
mysqli_query($cnx, $sql_create_table);

if(mysqli_num_rows($result1) > 0) {
        
    while($ligne = mysqli_fetch_array($result1)) {

$sql_insert = "INSERT INTO 2g_filtre ( Cell_Name, Activity_Status) 
     VALUES ( '".$ligne['Cell_Name']."', '".$ligne['Activity_Status']."' )";
         mysqli_query($cnx, $sql_insert);

    }
}


$query2 = "SELECT Cell_Name FROM 2g_filtre WHERE Cell_Name IN (SELECT Cell_Name FROM 2g_prs)";
$query3 = "SELECT Date, Cell_Name, R373Cell_Out, DI_2G_min, DI_2G_h, DI_2G_j, di_2g_avg, res_nur_T_GL FROM 2g_prs";

$query = "SELECT t3.Date, t2.Cell_Name, t3.R373Cell_Out, t3.DI_2G_min, t3.DI_2G_h, t3.DI_2G_j, t3.di_2g_avg, t3.res_nur_T_GL
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
            <td><?php echo $ligne['Cell_Name'] ?></td>
            <td><?php echo $ligne['R373Cell_Out'] ?></td>
            <td><?php echo $ligne['DI_2G_min'] ?></td>
            <td><?php echo $ligne['DI_2G_h'] ?></td>
            <td><?php echo $ligne['DI_2G_j'] ?></td>
            <td><?php echo $ligne['di_2g_avg'] ?></td>
            <td><?php echo $ligne['res_nur_T_GL'] ?></td>
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
