<!DOCTYPE html>
<html>
<head>
<title>charts-3G-T</title>
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

<input type="button"  id="copy_btn2" name="send_email" value="Send Email">

<input type="text" id="filterInput" placeholder="Enter filter value h...">
<button onclick="applyFilter()">Filter</button>
<button onclick="resetTable()">Return</button>


<table id="example" class="display nowrap" style="width:100%">
<thead>
<tr> 
    
    <th>Date</th>
    <th>Cell_Name</th>
    
    <th>DI_3g_Heure</th>
    <th>Site</th>
    
    <!-- <th>Commentaire</th> -->
    <th>TOC</th>
    <th>Date_début</th>
    <th>Date_fin</th>
    <!-- <th>Action</th> -->
      
</tr>
</thead>
<?php

$cnx=mysqli_connect("localhost","root","","pfe") or die("connection failed");
    


// Modify the queries to include the join condition with the Date comparison
$query = "SELECT t2.Date, t2.Cell_Name, t2.DI_3g_Heure, t2.Code_site, t3.TOC, t3.Date_debut, t3.Date_fin
 FROM ( 
    SELECT Date, Cell_Name, DI_3g_Heure, SUBSTR(Cell_Name, 1, 8) AS Code_site FROM `3g_prs`
     ) AS t2 
     JOIN(
         SELECT Code_sites, TOC, Date_debut, Date_fin 
         FROM `incidents` 
         ) AS t3
          ON t2.Code_site = t3.Code_sites AND t2.Date = SUBSTR(t3.Date_debut, 1, 10);";


// Execute the combined query
$result = mysqli_query($cnx, $query);

if (!$result) {
    printf("Error: %s\n", mysqli_error($cnx));
    exit();
}
$hasFilter = isset($_GET['filterValue']);
$filterValue = $hasFilter ? $_GET['filterValue'] : "";

if ($hasFilter) {
    echo "\n Le nbr d'heure > " . $filterValue;
}

// Fetch and display the data
while ($row = mysqli_fetch_array($result)) {
    $date = $row['Date'];
    $cellName = $row['Cell_Name'];
    $DI_3g_Heure = $row['DI_3g_Heure'];
    $codeSite = $row['Code_site'];
    $toc = $row['TOC'];
    $dateDebut = $row['Date_debut'];
    $dateFin = $row['Date_fin'];

    if ($hasFilter && $DI_3g_Heure > $filterValue) {
        ?>
    
    <tr>
        <td><?php echo $date ?></td>
        <td><?php echo $cellName ?></td>
        <td><?php echo $DI_3g_Heure ?></td>
        <td><?php echo $codeSite ?></td>
        <td><?php echo $toc ?></td>
        <td><?php echo $dateDebut ?></td>
        <td><?php echo $dateFin ?></td>
    </tr>
    <?php
    } else if (!$hasFilter) {
        ?>
    <tr>
        <td><?php echo $date ?></td>
        <td><?php echo $cellName ?></td>
        <td><?php echo $DI_3g_Heure ?></td>
        <td><?php echo $codeSite ?></td>
        <td><?php echo $toc ?></td>
        <td><?php echo $dateDebut ?></td>
        <td><?php echo $dateFin ?></td>
    <?php
}
}
mysqli_close($cnx);

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
function applyFilter() {
    var filterValue = document.getElementById("filterInput").value;
    var url = window.location.href;
    if (url.indexOf('?') > -1){
        url += '&filterValue=' + filterValue;
    } else {
        url += '?filterValue=' + filterValue;
    }
    window.location.href = url;
}

function resetTable() {
    window.location.href = window.location.pathname;
}
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        paging: false,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );


var copyBtn= document.querySelector('#copy_btn2');
copyBtn.addEventListener('click', function () {
  
   var urlField = document.querySelector('#example');
  // create a Range object
  var range = document.createRange();  
  // set the Node to select the "range"
  range.selectNode(urlField);
  // add the Range to the set of window selections
  window.getSelection().addRange(range);
   
  // execute 'copy', can't 'cut' in this case
  document.execCommand('copy');
  
  
  window.open('mailto:iheb.dabbabii@gmail.com?cc=hamraouikhoulouud@gmail.com&subject=Bilan 3G&body=','_self');
  

  
 
  
}, false);
</script>

</body>
</html>