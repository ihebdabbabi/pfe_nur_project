<!DOCTYPE html>
<html>
<head>
<title>nur_b_4G tdd</title>
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
    <a href="../importation/import_nur_b_4g_tdd.php" style="margin-right: 10px; padding: 5px 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Import</a>
    <a href="../Delete nur_b_4g_tdd.php?delete_table=1" style="padding: 5px 10px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 4px;">Delete Table</a>
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
    echo 'le nbr de jours est:     '. $days + 1 ; 

    $nur_4g_B = "SELECT ((SELECT (SUM(IB)) FROM nur_b_4g_tdd WHERE Cell_Name IN (SELECT Cell_Name FROM 4g_filtre_tdd)) * pow(10, 5) )
       / 
    ( 60 * 24 * 30) ";

    $res_nur_4g = mysqli_query($cnx, $nur_4g_B);
    
    if (!$res_nur_4g) {
        printf("Error: %s\n", mysqli_error($cnx));
        exit();
    }
    
    $row = mysqli_fetch_array($res_nur_4g);
    $nur_B_F_4G_tdd = $row[0];

    echo 'NUR-B-4G-tdd est'. $nur_B_F_4G_tdd ; 
    
    $update_query = "UPDATE nur_b_4g_tdd SET nur_B_F_4G_tdd = $nur_B_F_4G_tdd";
mysqli_query($cnx, $update_query);

?>
<table id="example" class="display nowrap" style="width:100%">
<thead>
<tr> 
    <th>Cell Name</th>
    <th>Count</th>
  
</tr>
</thead>   
<?php


   // Query to fetch all rows within the specified date range and with 4G technology
   $query1 = "SELECT Date, Cell_Name FROM  nur_b_4g_tdd
   WHERE Date >= '$start_Date' AND Date <= '$end_Date' and Cell_FDD_TDD_Indication = 'CELL_TDD'
   AND SUBSTR(Cell_Name, 1, 8) IN (SELECT Code_site FROM ssvok WHERE techno = '4G' AND SSV = 'SSVOK' )";
$result1 = mysqli_query($cnx, $query1);

// Query to fetch the activated cell name from the 4G_U2020 table
$query2 = "SELECT Cell_Name FROM 4G_U2020  WHERE Activation_Status ='Active' LIMIT 1";
$result2 = mysqli_query($cnx, $query2);

// Query to fetch all rows within the specified date range
$query3 = "SELECT * FROM nur_b_4g_tdd WHERE Date >= '$start_Date' AND Date <= '$end_Date'";
$result3 = mysqli_query($cnx, $query3);

// Initialize an empty array to store the count and total for each unique cell name
$cellData = array();

    // Loop through each row in the first result set and calculate the count and total for each unique cell name
    while ($row = mysqli_fetch_array($result1)) {
        $cellName = $row['Cell_Name'];
        $count = isset($cellData[$cellName]['count']) ? $cellData[$cellName]['count'] : 0;
        $count += 1;
        $cellData[$cellName] = array('count' => $count);
    }

    // Fetch the activated cell name from the second result set
    $activatedCellName = mysqli_fetch_array($result2)['Cell_Name'];

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
<table id="example" class="display nowrap" style="width:100%" >
<thead>
<tr> 
    <th>Date</th>
    <th>Cell Name</th>

    <th>Rev_Cell</th>
    <th>Coef_Cell</th>
    <th>IB</th>

    <th>nur_B_F_4G_tdd</th>
  
</tr>
</thead>   
<?php
    
    $cnx=mysqli_connect("localhost","root","","pfe") or die("connection failed");



//     $queryb3 = "UPDATE nur_b_4g_tdd nb
//     SET IB = Coef_Cell * (SELECT (Indispo_sys_F_group_DI_min) FROM 4g_prs nt
//     WHERE nt.Cell_Name = nb.Cell_Name )";
// $resultb3 = mysqli_query($cnx, $queryb3);

$queryb3 = "UPDATE nur_b_4g_tdd nb
JOIN (
    SELECT DISTINCT(a.Cell_Name), b.Indispo_sys_F_group_DI_min
    FROM `4g_filtre_tdd` a
    JOIN `4g_prs` b ON a.Cell_Name = b.Cell_Name 
) subq ON nb.Cell_Name = subq.Cell_Name
SET nb.IB = nb.Coef_Cell * subq.Indispo_sys_F_group_DI_min;
";
$resultb3 = mysqli_query($cnx, $queryb3);



    $queryb2 = "UPDATE nur_b_4g_tdd
    SET Coef_Cell = Rev_Cell / (SELECT SUM(Rev_Cell) FROM (SELECT Rev_Cell FROM nur_b_4g_tdd) AS temp)";
$resultb2 = mysqli_query($cnx, $queryb2);



$queryb1 = "UPDATE nur_b_4g_tdd  SET Rev_Cell =
                          FT_AVERAGE_NB_OF_USERS_UEs_RRC_CONNECTED";

$reslutb1= mysqli_query($cnx,$queryb1);



   

$query2 = "SELECT * from nur_b_4g_tdd WHERE  Cell_Name IN (SELECT Cell_Name from 4g_filtre_tdd )";

$result2=mysqli_query($cnx,$query2);

if(mysqli_num_rows($result2) > 0) {
while ($ligne = mysqli_fetch_array($result2)) {
  
     
    ?>
    
   
       <tr>
         <td><?php echo $ligne['Date'] ?> </td>
        
         <td><?php echo $ligne['Cell_Name'] ?> </td>
        
         <td><?php echo $ligne['Rev_Cell'] ?> </td>
         <td><?php echo $ligne['Coef_Cell'] ?> </td>
       
         <td><?php echo $ligne['IB'] ?> </td>

         <td><?php echo $ligne['nur_B_F_4g_tdd'] ?> </td>
       
       
        
       
        
         
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