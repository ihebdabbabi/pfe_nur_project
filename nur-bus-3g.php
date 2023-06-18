<!DOCTYPE html>
<html>
<head>
<title>nur-bus-3G</title>
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
    <a href="../importation/import_nur_b_3g.php" style="margin-right: 10px; padding: 5px 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Import</a>
    <a href="../Delete nur_b_3g.php?delete_table=1" style="padding: 5px 10px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 4px;">Delete Table</a>
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
 $cnx=mysqli_connect("localhost","root","","pfe") or die("connection failed");

 $start_Date = '';
$end_Date = '' ;


if (isset($_POST['send'])) {
    $start_Date = $_POST['start_date']; 
    $end_Date = $_POST['end_date'];
    echo $start_Date.' '.$end_Date .'<br>';

    $diff = strtotime($end_Date) - strtotime($start_Date);
    $days = ($diff / (60 * 60 * 24)) ;
    echo 'le nbr de jours est:     '. $days + 1 ; 

    $nur_3g_B = "SELECT (SUM(IB) * pow(10, 5) ) / ( 60 * 24 * $days) AS nur_B_F_3g FROM nur_b_3g";

    $res_nur_3g = mysqli_query($cnx, $nur_3g_B);
    
    if (!$res_nur_3g) {
        printf("Error: %s\n", mysqli_error($cnx));
        exit();
    }
    
    $row = mysqli_fetch_array($res_nur_3g);
    $nur_B_F_3g = $row['nur_B_F_3g'] ;

    echo "\n NUR-B-3G est". $nur_B_F_3g ; 
    
    $update_query = "UPDATE nur_b_3g SET nur_B_F_3g = $nur_B_F_3g";
mysqli_query($cnx, $update_query);

//     $queryb7 = "UPDATE nur_b_3g 
//             SET nur_B_F_3g = (SELECT (POW(10, 5) * SUM(IB)) / (30 * 24 * 60) AS value 
//                               FROM (SELECT IB FROM nur_b_3g) AS temp) ";
// $resultb7 = mysqli_query($cnx, $queryb7);

?>
<table id="example" class="display nowrap" style="width:100%">
<thead>
<tr> 
    <th>Cell Name</th>
    <th>Count</th>
    


    

  
</tr>
</thead>   
<?php
     

     // Query to fetch all rows within the specified date range and with 2G technology
     $query2 = "SELECT Cell_Name FROM 3g_filtre WHERE Cell_Name IN (SELECT Cell_Name FROM nur_b_3g)";
   $query3 = "SELECT Date, Cell_Name FROM nur_b_3g
   WHERE Date >= '$start_Date' AND Date <= '$end_Date' ";
   
   $query = "SELECT t2.Cell_Name
             FROM ($query2) AS t2
             JOIN ($query3) AS t3 ON t2.Cell_Name = t3.Cell_Name";
   
   $result = mysqli_query($cnx, $query);

 // Initialize an empty array to store the count and total for each unique cell name
 $cellData = array();

 // Loop through each row in the first result set and calculate the count and total for each unique cell name
 while ($row = mysqli_fetch_array($result)) {
  $cellName = $row['Cell_Name'];
  $count = isset($cellData[$cellName]['count']) ? $cellData[$cellName]['count'] : 0;
  $count += 1;

  $cellData[$cellName] = array('count' => $count);
}


 // Loop through each unique cell name and display the count and total for that cell
 foreach ($cellData as $cellName => $data) {
  ?>
  <tr>
      <td><?php echo $cellName ?></td>
      <td><?php echo $data['count'] ?></td>
    
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
    
    <th>Rev_Cell_voix</th>
    <th>Coef_Cell_voix</th>
    <th>Rev_Cell_data</th>
    <th>Coef_Cell_data</th>
    <th>Coef_Cell_moy</th>
    <th>IB</th>

    <th>nur_B_F_3g</th>

        
</tr>
</thead>
<?php

       $cnx=mysqli_connect("localhost","root","","pfe") or die("connection failed");

       
       $queryb6 = "UPDATE nur_b_3g nb
JOIN (
    SELECT DISTINCT(a.Cell_Name), b.DI_3g_Minute
    FROM `3g_filtre` a
    JOIN `3g_prs` b ON a.Cell_Name = b.Cell_Name
) subq ON nb.Cell_Name = subq.Cell_Name
SET nb.IB = nb.Coef_Cell_moy * subq.DI_3g_Minute;
";
$resultb6 = mysqli_query($cnx, $queryb6);




//        $queryb6 = "UPDATE nur_b_3g nb
//     SET IB = Coef_Cell_moy * (SELECT (DI_3g_Minute) FROM 3g_prs nt
//      WHERE nt.Cell_Name = nb.Cell_Name and nt.Cell_ID=nb.Cell_ID)";
       
// $resultb6 = mysqli_query($cnx, $queryb6);
  
$queryb5 = "UPDATE nur_b_3g
SET Coef_Cell_moy = ((Coef_Cell_data + Coef_Cell_voix) / 2)";
$resultb5 = mysqli_query($cnx, $queryb5);



       $queryb4 = "UPDATE nur_b_3g
       SET Coef_Cell_data = Rev_Cell_data / (SELECT SUM(Rev_Cell_data) FROM (SELECT Rev_Cell_data FROM nur_b_3g) AS temp)";
   $resultb4 = mysqli_query($cnx, $queryb4);
   
   
   
   $queryb3 = "UPDATE nur_b_3g  SET Rev_Cell_data =
  FT_3G_3G_TOTAL_DATA_TRAFFIC_VOLUME_DL_UL_GB_Gbit";
   
   $reslutb3= mysqli_query($cnx,$queryb3);
   
       $queryb2 = "UPDATE nur_b_3g
       SET Coef_Cell_voix = Rev_Cell_voix / (SELECT SUM(Rev_Cell_voix) FROM (SELECT Rev_Cell_voix FROM nur_b_3g) AS temp)";
   $resultb2 = mysqli_query($cnx, $queryb2);
   
   
   
   $queryb1 = "UPDATE nur_b_3g  SET Rev_Cell_voix =
   FT_3G_TRAFFIC_SPEECH_Erl_Erl";
   
   $reslutb1= mysqli_query($cnx,$queryb1);
   


  

   $query2 = "SELECT Cell_Name FROM 3g_filtre WHERE Cell_Name IN (SELECT Cell_Name FROM nur_b_3g)";
   $query3 = "SELECT Date, Cell_Name, Rev_Cell_voix, Coef_Cell_voix, Rev_Cell_data, Coef_Cell_data, Coef_Cell_moy, IB, nur_B_F_3g FROM nur_b_3g";
   
   $query = "SELECT t3.Date, t2.Cell_Name, t3.Rev_Cell_voix, t3.Coef_Cell_voix, t3.Rev_Cell_data, t3.Coef_Cell_data, t3.Coef_Cell_moy, t3.IB, t3.nur_B_F_3g
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
      <td><?php echo $ligne['Date'] ?> </td>
      
      <td><?php echo $ligne['Cell_Name'] ?> </td>
      

         <td><?php echo $ligne['Rev_Cell_voix'] ?> </td>
         <td><?php echo $ligne['Coef_Cell_voix'] ?> </td>
         <td><?php echo $ligne['Rev_Cell_data'] ?> </td>
         <td><?php echo $ligne['Coef_Cell_data'] ?> </td>
         <td><?php echo $ligne['Coef_Cell_moy'] ?> </td>
         <td><?php echo $ligne['IB'] ?> </td>

         <td><?php echo $ligne['nur_B_F_3g'] ?> </td>
      
      
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
