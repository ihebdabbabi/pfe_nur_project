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





<table id="example" class="display nowrap" style="width:100%" >
<thead>
<tr> 
    <th>Date</th>
    <th>Cell Name</th>

    <th>Rev_Cell</th>
    <th>Coef_Cell</th>
    <th>IB</th>

    <th>nur_B_F_4g_fdd</th>
  
</tr>
</thead>   
<tbody>
<?php

    $cnx=mysqli_connect("localhost","root","","pfe") or die("connection failed");


   

 
    $queryb3 = "UPDATE nur_b_4g_fdd nb
       SET IB = Coef_Cell * (SELECT (Indispo_sys_F_group_DI_min) FROM 4g_prs nt
        WHERE nt.Cell_Name = nb.Cell_Name )";
$resultb3 = mysqli_query($cnx, $queryb3);



    $queryb2 = "UPDATE nur_b_4g_fdd
    SET Coef_Cell = Rev_Cell / (SELECT SUM(Rev_Cell) FROM (SELECT Rev_Cell FROM nur_b_4g_fdd) AS temp)";
$resultb2 = mysqli_query($cnx, $queryb2);



$queryb1 = "UPDATE nur_b_4g_fdd  SET Rev_Cell =
                        `FT_4G_4G_U2020_DL_TRAFFIC_VOLUME_GBYTES` + `FT_4G_4G_U2020_UL_TRAFFIC_VOLUME_GBYTES_`";

$reslutb1= mysqli_query($cnx,$queryb1);



   

$query1 = "SELECT Date, Cell_Name, Rev_Cell, Coef_Cell, IB ,nur_B_F_4g_fdd
   FROM nur_b_4g_fdd WHERE Cell_FDD_TDD_Indication = 'CELL_FDD' AND
 SUBSTR(Cell_Name, 1, 8) IN (SELECT Code_site FROM ssvok WHERE Techno = '4G' AND SSV = 'SSVOK' )";

$result1=mysqli_query($cnx,$query1);


$query2 = "SELECT * FROM nur_b_4g_fdd WHERE Cell_Name IN
              (SELECT Cell_Name FROM 4G_U2020 WHERE Activation_Status = 'Active')"; 


$result2=mysqli_query($cnx,$query2);




  
  
  if(mysqli_num_rows($result1) > 0) {
    if(mysqli_num_rows($result2) > 0) {
    

      while(($ligne = mysqli_fetch_array($result1)) &&
            ($lig = mysqli_fetch_array($result2))) {
        
    //Code pour afficher les résultats de des requêtes
  
   // Réinitialiser la position du pointeur du résultat de la deuxième requête
    mysqli_data_seek($result2, 0);
  
     
    ?>
    
   
       <tr>
         <td><?php echo $ligne['Date'] ?> </td>
        
         <td><?php echo $ligne['Cell_Name'] ?> </td>
        
         <td><?php echo $ligne['Rev_Cell'] ?> </td>
         <td><?php echo $ligne['Coef_Cell'] ?> </td>
       
         <td><?php echo $ligne['IB'] ?> </td>

         <td><?php echo $ligne['nur_B_F_4g_fdd'] ?> </td>
       
       
        
       
        
         
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