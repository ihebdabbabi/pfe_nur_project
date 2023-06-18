<!DOCTYPE html>
<html>
<head>
<title>nur-b-2G</title>
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
    <a href="../importation/import_nur_b_2g.php" style="margin-right: 10px; padding: 5px 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Import</a>
    <a href="../Delete nur_b_2g.php?delete_table=1" style="padding: 5px 10px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 4px;">Delete Table</a>
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
    echo 'le nbr de jours est:     '. $days + 1; 

    $nur_2g_B = "SELECT (SUM(IB) * pow(10, 5) ) / ( 60 * 24 * $days) AS nur_B_F_2g FROM nur_b_2g";

    $res_nur_2g = mysqli_query($cnx, $nur_2g_B);
    
    if (!$res_nur_2g) {
        printf("Error: %s\n", mysqli_error($cnx));
        exit();
    }
    
    $row = mysqli_fetch_array($res_nur_2g);
    $nur_B_F_2g = $row['nur_B_F_2g'] ;

    echo 'NUR-B-2G est'. $nur_B_F_2g ; 
    
    $update_query = "UPDATE nur_b_2g SET nur_B_F_2g = $nur_B_F_2g";
    mysqli_query($cnx, $update_query);

    ?>

    <table id="example" class="display nowrap" style="width:100%" >
    <thead>
    <tr> 
        <th>Cell Name</th>
        <th>Count</th>
    </tr>
    </thead>

    <?php

    // Query to fetch all rows within the specified date range and with 2G technology
    $query1 = "SELECT Cell_Name FROM 2g_filtre WHERE Cell_Name IN (SELECT Cell_Name FROM 2g_prs)";
$query2 = "SELECT Cell_Name FROM `2g_prs` 
           WHERE Date >= '$start_Date' AND Date <= '$end_Date'";

$query = "SELECT t2.Cell_Name 
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
?>
 </table> 
<?php
if(isset($_POST['myBtn'])) {
    ?>
    <table id="example" class="display nowrap" style="width:100%" >
<thead>
<tr> 
    <th>Date</th>
    
    <th>Cell Name</th>
   
    
    <th>FT_Traffic_2GErl</th>
    <th>PS_Traffic_kbit</th>
    <th>Rev_Cell</th>
    <th>Coef_Cell</th>
    <th>IB</th>
    <th>nur_B_F_2g</th>

    
</tr>
</thead>
<?php

    
    $cnx=mysqli_connect("localhost","root","","pfe") or die("connection failed");



 
//     $queryb3 = "UPDATE nur_b_2g nb 
//     SET IB = Coef_Cell * (SELECT (DI_2G_min) FROM 2g_prs nt
//             WHERE nt.Cell_Name = nb.Cell_Name ) ";
// $resultb3 = mysqli_query($cnx, $queryb3);

$queryb3 = "UPDATE nur_b_2g nb
JOIN (
    SELECT DISTINCT(a.Cell_Name), b.DI_2G_min
    FROM `2g_filtre` a
    JOIN `2g_prs` b ON a.Cell_Name = b.Cell_Name
) subq ON nb.Cell_Name = subq.Cell_Name
SET nb.IB = nb.Coef_Cell * subq.DI_2G_min;
 ";
$resultb3 = mysqli_query($cnx, $queryb3);



    $queryb2 = "UPDATE nur_b_2g
    SET Coef_Cell = Rev_Cell / (SELECT SUM(Rev_Cell) FROM (SELECT Rev_Cell FROM nur_b_2g) AS temp)";
$resultb2 = mysqli_query($cnx, $queryb2);




$queryb1 = "UPDATE nur_b_2g  SET Rev_Cell =
FT_Traffic_2GErl";

$reslutb1= mysqli_query($cnx,$queryb1);

   

   
$query2 = "SELECT Cell_Name FROM 2g_filtre WHERE Cell_Name IN (SELECT Cell_Name FROM nur_b_2g)";
$query3 = "SELECT Date, Cell_Name, FT_Traffic_2GErl,PS_Traffic_kbit, Rev_Cell, Coef_Cell,IB, nur_B_F_2g FROM nur_b_2g";

$query = "SELECT t3.Date, t2.Cell_Name, t3.FT_Traffic_2GErl, t3.PS_Traffic_kbit, t3.Coef_Cell, t3.Rev_Cell, t3.IB, t3.nur_B_F_2g
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
         
         <td><?php echo $ligne['FT_Traffic_2GErl'] ?> </td>
         <td><?php echo $ligne['PS_Traffic_kbit'] ?> </td>
         <td><?php echo $ligne['Rev_Cell'] ?> </td>
         <td><?php echo $ligne['Coef_Cell'] ?> </td>
         <td><?php echo $ligne['IB'] ?> </td>
         <td><?php echo $ligne['nur_B_F_2g'] ?> </td>
       
       
        
       
        
         
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