<!DOCTYPE html>
<html>
<head>
<title>charts-4G-works_FDD</title>
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



<table id="example" class="display nowrap" style="width:100%">
<thead>
<tr> 
    
    <th>Cell_Name</th>
    
    <th>Indispo_sys_F_group_DI_h</th>
    <th>Site</th>

    <!-- <th>Commentaire</th>
    <th>Ticket_Swan</th>
    <th>Date_début</th>
    <th>Date_fin</th>
    <th>Description</th> -->
      
</tr>
</thead>
<?php

       $cnx=mysqli_connect("localhost","root","","pfe") or die("connection failed");
    







$query2 = "SELECT Cell_Name ,Indispo_sys_F_group_DI_h ,SUBSTR(Cell_Name, 1, 8) as Site FROM `4g_prs` WHERE Cell_FDD_TDD_Indication='CELL_FDD'";

$result2=mysqli_query($cnx,$query2);

if(mysqli_num_rows($result2) > 0) {
while ($ligne = mysqli_fetch_array($result2)) {
    ?>
    <tr>
        
        <td><?php echo $ligne['Cell_Name'] ?></td>
       
        <td><?php echo $ligne['Indispo_sys_F_group_DI_h'] ?></td>
        <td><?php echo $ligne['Site'] ?></td>
        
        <!-- <td><?php echo $ligne['Commentaire'] ?></td>
        <td><?php echo $ligne['Ticket_Swan'] ?></td>
        <td><?php echo $ligne['Date_début'] ?></td>
        <td><?php echo $ligne['Date_fin'] ?></td>
        <td><?php echo $ligne['Action'] ?></td> -->
    </tr>
    <?php
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