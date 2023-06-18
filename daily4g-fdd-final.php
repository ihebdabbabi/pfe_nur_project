
<!DOCTYPE html>
<html>
<head>
<title>Daily-4G-FDD-final</title>
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
    <a href="../importation/import daily4G.php" style="margin-right: 10px; padding: 5px 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Import</a>
    <a href="../Delete 4G_PRS.php?delete_table=1" style="padding: 5px 10px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 4px;">Delete Table</a>
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
<input type="submit" name="myBtn" value="Annuler">
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
        $days = ($diff / (60 * 60 * 24)) ;

        
        echo 'le nbr de jours est     '. $days +1 ; 

        
        $nur_4g_T = "SELECT (((select SUM(b.Indispo_sys_F_group_DI_min) from (SELECT DISTINCT(Cell_Name) FROM `4g_filtre_fdd`) a ,
         (SELECT DISTINCT(Cell_Name),Indispo_sys_F_group_DI_min FROM `4g_prs` group by Cell_Name) b where a.Cell_Name=b.Cell_Name) + 
         (select SUM(b.Indispo_sys_F_group_DI_min) from (SELECT DISTINCT(Cell_Name) FROM `4g_filtre_tdd`) a , 
         (SELECT DISTINCT(Cell_Name),Indispo_sys_F_group_DI_min FROM `4g_prs` group by Cell_Name) b 
         where a.Cell_Name=b.Cell_Name)) * pow(10, 5)) / ((select (SELECT COUNT(Cell_Name) FROM 4g_filtre_fdd) + 
         (SELECT COUNT(Cell_Name) FROM 4g_filtre_tdd )) * 60 * 24 * 30) AS di_4g_avg;";


$res_nur_4g = mysqli_query($cnx, $nur_4g_T);

if (!$res_nur_4g) {
    printf("Error: %s\n", mysqli_error($cnx));
    exit();
}

$row = mysqli_fetch_array($res_nur_4g);
$di_4g_avg = $row['di_4g_avg'];

echo 'NUR-T-4G est : ' . $di_4g_avg;

$update_query = "UPDATE 4g_prs SET di_4g_avg = $di_4g_avg";
mysqli_query($cnx, $update_query);



$NUR_WORKS_4G = "SELECT ((select SUM(b.Indispo_works_DI_min) from (SELECT DISTINCT(Cell_Name) FROM `4g_filtre_fdd`) a ,
 (SELECT DISTINCT(Cell_Name),Indispo_works_DI_min FROM `4g_prs` group by Cell_Name) b where a.Cell_Name=b.Cell_Name) +
  (select SUM(b.Indispo_works_DI_min) from (SELECT DISTINCT(Cell_Name) FROM `4g_filtre_tdd`) a , 
  (SELECT DISTINCT(Cell_Name),Indispo_works_DI_min FROM `4g_prs` group by Cell_Name) b where a.Cell_Name=b.Cell_Name ) * pow(10, 5) ) 
      / 
  ((select (SELECT COUNT(Cell_Name) FROM 4g_filtre_fdd) + (SELECT COUNT(Cell_Name) FROM 4g_filtre_tdd )) * 60 * 24 * 30) AS di_4g_avg_works_fdd FROM 4g_prs;";

$res_NUR_WORKS_4G = mysqli_query($cnx, $NUR_WORKS_4G);
 

if (!$res_NUR_WORKS_4G) {
    printf("Error: %s\n", mysqli_error($cnx));
    exit();
}

$row = mysqli_fetch_array($res_NUR_WORKS_4G);
$di_4g_avg_works_fdd = $row['di_4g_avg_works_fdd'];

echo 'NUR-WORKS-4G: ' . $di_4g_avg_works_fdd;

$update_query = "UPDATE 4g_prs SET di_4g_avg_works_fdd = $di_4g_avg_works_fdd";
mysqli_query($cnx, $update_query);


 



?>
<table id="example" class="display nowrap" style="width:100%">
<thead>
<tr> 
    <th>Cell Name</th>
    <th>Count</th>
    <th>Total 1</th>
    <th>Total 2</th>
    <th>Total 3</th>
    <th>Total 4</th>
</tr>
</thead>   
<?php
     

     

 // Query to fetch data from 4g_prs table within the specified date range and filtered by the cell names in 4g_filtre table
$query1 = "SELECT Cell_Name, LCell_Unavail_Dur_Sys_s ,LCell_Unavail_Dur_Manual_s ,Total_Cell_Unavail_Duration_s,LCell_Unavail_Dur_EnergySaving_s FROM 4g_prs
WHERE Date >= '$start_Date' AND Date <= '$end_Date'
AND Cell_Name IN (SELECT Cell_Name FROM 4g_filtre_fdd)";
$result1 = mysqli_query($cnx, $query1);

 // Initialize an empty array to store the count and total for each unique cell name
 $cellData = array();

 // Loop through each row in the first result set and calculate the count and total for each unique cell name
 while ($row = mysqli_fetch_array($result1)) {
  $cellName = $row['Cell_Name'];
  $count = isset($cellData[$cellName]['count']) ? $cellData[$cellName]['count'] : 0;
  $count += 1;

  $total1 = isset($cellData[$cellName]['total1']) ? $cellData[$cellName]['total1'] : 0;
  $total1 += $row['LCell_Unavail_Dur_Sys_s'];

  $total2 = isset($cellData[$cellName]['total2']) ? $cellData[$cellName]['total2'] : 0;
  $total2 += $row['LCell_Unavail_Dur_Manual_s'];

  $total3 = isset($cellData[$cellName]['total3']) ? $cellData[$cellName]['total3'] : 0;
  $total3 += $row['Total_Cell_Unavail_Duration_s'];

  $total4 = isset($cellData[$cellName]['total4']) ? $cellData[$cellName]['total4'] : 0;
  $total4 += $row['LCell_Unavail_Dur_EnergySaving_s'];

  $cellData[$cellName] = array('count' => $count, 'total1' => $total1, 'total2' => $total2, 'total3' => $total3, 'total4' => $total4);
}


 

 // Loop through each unique cell name and display the count and total for that cell
 foreach ($cellData as $cellName => $data) {
  ?>
  <tr>
      <td><?php echo $cellName ?></td>
      <td><?php echo $data['count'] ?></td>
      <td><?php echo $data['total1'] ?></td>
      <td><?php echo $data['total2'] ?></td>
      <td><?php echo $data['total3'] ?></td>
      <td><?php echo $data['total4'] ?></td>
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
    <th>Cell_Name</th>
    
    <th>Indispo_sys_F_group_DI_min</th>
    <th>Indispo_sys_F_group_DI_h</th>
   
    <th>Indispo_syst_DI_min</th>
    <th>Indispo_syst_DI_h</th>
    
    <th>Indispo_works_DI_min</th>
    <th>Indispo_works_DI_h</th>
    <th>di_4g_avg</th>
    <th>di_4g_avg_works_fdd</th>

      
</tr>
</thead>
<?php
$cnx=mysqli_connect("localhost","root","","pfe") or die("connection failed");

$query11 = "UPDATE 4g_prs SET Indispo_works_DI_min =
           `Indispo_works` /60";
$reslut11= mysqli_query($cnx,$query11);      

$query10 = "UPDATE 4g_prs SET Indispo_works_DI_h =
    `Indispo_works` /3600";
$reslut10= mysqli_query($cnx,$query10);

$query9 = "UPDATE 4g_prs SET Indispo_syst_DI_min =
           `Indispo_syst` /60";
$reslut9= mysqli_query($cnx,$query9);      

$query8 = "UPDATE 4g_prs SET Indispo_syst_DI_h =
`Indispo_syst` /3600";
$reslut8= mysqli_query($cnx,$query8);


$query7 = "UPDATE 4g_prs SET Indispo_sys_F_group_DI_min =
           `Indispo_sys_F_group` /60";
$reslut7= mysqli_query($cnx,$query7);      


$query6 = "UPDATE 4g_prs SET Indispo_sys_F_group_DI_h =
`Indispo_sys_F_group` /3600";
$reslut6= mysqli_query($cnx,$query6);


$query3 = "UPDATE 4g_prs SET Indispo_sys_F_group =
                 `LCell_Unavail_Dur_Sys_s` + `LCell_Unavail_Dur_Manual_s`";
   $reslut3= mysqli_query($cnx,$query3);

   $query4 = "UPDATE 4g_prs SET Indispo_syst =
                `Total_Cell_Unavail_Duration_s` - `LCell_Unavail_Dur_EnergySaving_s`";
    $reslut4= mysqli_query($cnx,$query4);
       
    $query5 = "UPDATE 4g_prs SET Indispo_works = `LCell_Unavail_Dur_Manual_s`";
$result5 = mysqli_query($cnx, $query5);


mysqli_query($cnx, "TRUNCATE TABLE 4g_filtre_fdd");

$query1 = "SELECT * FROM 4G_U2020 WHERE Activation_Status = 'Active' and SUBSTR(Cell_Name, 1, 8) IN 
             (SELECT Sites FROM ssvok_test) and RAT='CELL_FDD' ";


$result1=mysqli_query($cnx,$query1);



$sql_create_table = "CREATE TABLE IF NOT EXISTS 4g_filtre_fdd(

Cell_Name VARCHAR(255),
Activation_Status	varchar(10)
)";
mysqli_query($cnx, $sql_create_table);


if(mysqli_num_rows($result1) > 0) {

while($ligne = mysqli_fetch_array($result1)) {

$sql_insert = "INSERT INTO 4g_filtre_fdd ( Cell_Name, Activation_Status) 
VALUES ( '".$ligne['Cell_Name']."', '".$ligne['Activation_Status']."')";
mysqli_query($cnx, $sql_insert);

}
}


$query2 = "SELECT * from 4g_prs WHERE  Cell_Name IN (SELECT Cell_Name from 4g_filtre_fdd )";

$result2=mysqli_query($cnx,$query2);

if(mysqli_num_rows($result2) > 0) {
while ($ligne = mysqli_fetch_array($result2)) {
     
    ?>
    
    <tr>
      <td><?php echo $ligne['Date'] ?> </td>
      
      <td><?php echo $ligne['Cell_Name'] ?> </td>
      
      
      <td><?php echo $ligne['Indispo_sys_F_group_DI_min'] ?></td>
      <td><?php echo $ligne['Indispo_sys_F_group_DI_h'] ?></td>
      
      <td><?php echo $ligne['Indispo_syst_DI_min'] ?></td>
      <td><?php echo $ligne['Indispo_syst_DI_h'] ?></td>
     
      <td><?php echo $ligne['Indispo_works_DI_min'] ?></td>
      <td><?php echo $ligne['Indispo_works_DI_h'] ?></td>

      <td><?php echo $ligne['di_4g_avg'] ?></td>
      <td><?php echo $ligne['di_4g_avg_works_fdd'] ?></td>


     
     

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
