<!DOCTYPE html>
<html>
<head>
<title>nur-b-4G fdd</title>
<style> 
table{border-collapse: collapse; }
td,th  {border: 1px solid black;}
th{color: black; background-color: #f07900;}
tbody{background-color: #8f8f8f;}
body{background-color: #f07900;
background-image: linear-gradient(43deg, #f07900 30%, #f6b4e6 72%);
}

</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.5/css/buttons.dataTables.min.css">




</head>
<body>


<?php
$cnx = mysqli_connect("localhost","root","","pfe") or die("connection failed");

$start_Date = '';
$end_Date = '' ;



    $start_Date = $_POST['start_date']; 
    $end_Date = $_POST['end_date'];
    echo $start_Date.' '.$end_Date .'<br>';

    $diff = strtotime($end_Date) - strtotime($start_Date);
    $days = ($diff / (60 * 60 * 24)) ;
    echo 'le nbr de jours est:     '. $days ; 

    $nur_4g_B = "SELECT SUM(IB) * pow(10, 5)  / ( 60 * 24 * $days) AS nur_B_F_4g_fdd FROM nur_b_4g_fdd";

    $res_nur_4g = mysqli_query($cnx, $nur_4g_B);
    
    if (!$res_nur_4g) {
        printf("Error: %s\n", mysqli_error($cnx));
        exit();
    }
    
    $row = mysqli_fetch_array($res_nur_4g);
    $nur_B_F_4g_fdd = $row['nur_B_F_4g_fdd'] ;

    echo 'NUR-B-4G-FDD est'. $nur_B_F_4g_fdd ; 
    
    $update_query = "UPDATE nur_b_4g_fdd SET nur_B_F_4g_fdd = $nur_B_F_4g_fdd";
mysqli_query($cnx, $update_query);



//      $queryb4 = "UPDATE nur_b_4g_fdd 
//     SET nur_B_F_4g_fdd = (SELECT (POW(10, 5) * SUM(IB)) / (30 * 24 * 60) AS value 
//                       FROM (SELECT IB FROM nur_b_4g_fdd) AS temp) ";
// $resultb4 = mysqli_query($cnx, $queryb4);

?>
<table id="example" class="display nowrap" style="width:100%">
<thead>
<tr> 
    <th>Cell Name</th>
    <th>Count</th>
  
</tr>
</thead> 

<tbody>  
<?php


   // Query to fetch all rows within the specified date range and with 4G technology
   $query1 = "SELECT Cell_Name FROM  nur_b_4g_fdd
   WHERE Date >= '$start_Date' AND Date <= '$end_Date' and Cell_FDD_TDD_Indication = 'CELL_FDD'
   AND SUBSTR(Cell_Name, 1, 8) IN (SELECT Code_site FROM ssvok WHERE techno = '4G' AND SSV = 'SSVOK' )";
$result1 = mysqli_query($cnx, $query1);

// Query to fetch the activated cell name from the 4G_U2020 table
$query2 = "SELECT Cell_Name FROM 4G_U2020  WHERE Activation_Status ='Active' LIMIT 1";
$result2 = mysqli_query($cnx, $query2);

// Query to fetch all rows within the specified date range
$query3 = "SELECT * FROM nur_b_4g_fdd WHERE Date >= '$start_Date' AND Date <= '$end_Date'";
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