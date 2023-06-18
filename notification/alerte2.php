
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/page4.css" media="all"/>


  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>test mail</title>

  <style type="text/css">
	  
.inputcell4{
padding:10px;
		border-radius:5px;
		border:solid 1px #ccc;
		width:900px;
}


  body,td,th {
    font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif;
}
  </style>
 
<style>
	
.inputcell2{
padding:10px;
		border-radius:5px;
		border:solid 1px #ccc;
		width:80px;
}

	
	
	
	.time-input{
		padding:10px;
		border-radius:5px;
		border:solid 1px #ccc;
		width:90px;
	}

    table{border-collapse: collapse; }
td,th  {border: 1px solid black;}
th{color: black; background-color: #f07900;}
tbody{background-color: #67b4e7}
</style>









</head>

<body>

	
	<p style="text-align: center; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif; font-size: 30px;">&nbsp;</p>
	<p style="text-align: center; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif; font-size: 30px;"><strong>Tableau Alerte impact client</strong></p>
	


<p>&nbsp; </p> 

<div style="text-align:center"> 
	
	<?php
    $cnx=mysqli_connect("localhost","root","","pfe") or die("connection failed");
	
    $query = "SELECT t2.Date, t2.Cell_Name, t2.DI_2G_h, t2.Code_site, t3.TOC, t3.Date_debut, t3.Date_fin
    FROM (
      SELECT Date, Cell_Name, DI_2G_h, SUBSTR(Cell_Name, 1, 8) AS Code_site
      FROM `2g_prs`
    ) AS t2
    JOIN (
      SELECT Code_sites, TOC, Date_debut, Date_fin
      FROM `incidents`
    ) AS t3
    ON t2.Code_site = t3.Code_sites AND t2.Date = SUBSTR(t3.Date_debut, 1, 10)";

$result = mysqli_query($cnx, $query);

$query2= "SELECT t2.Date, t2.Cell_Name, t2.DI_3g_Heure, t2.Code_site, t3.TOC, t3.Date_debut, t3.Date_fin
FROM ( 
   SELECT Date, Cell_Name, DI_3g_Heure, SUBSTR(Cell_Name, 1, 8) AS Code_site FROM `3g_prs`
    ) AS t2 
    JOIN(
        SELECT Code_sites, TOC, Date_debut, Date_fin 
        FROM `incidents` 
        ) AS t3
         ON t2.Code_site = t3.Code_sites AND t2.Date = SUBSTR(t3.Date_debut, 1, 10)";

$result2 = mysqli_query($cnx, $query2);

$query3 = "SELECT t2.Date, t2.Cell_Name, t2.Indispo_sys_F_group_DI_h, t2.Site, t3.TOC, t3.Date_debut, t3.Date_fin FROM
 (SELECT Date, Cell_Name ,Indispo_sys_F_group_DI_h ,SUBSTR(Cell_Name, 1, 8) as Site FROM `4g_prs` 
  WHERE Cell_FDD_TDD_Indication='CELL_FDD' ) AS t2  JOIN( SELECT Code_sites, TOC, Date_debut, Date_fin FROM `incidents`) AS t3 
    ON t2.Site = t3.Code_sites AND t2.Date=SUBSTR(t3.Date_debut, 1, 10)";

$result3 = mysqli_query($cnx, $query3);


?>

	
<br><br><input class="submitstyle" id="copy_btn2" type="button" value="Envoyer le mail alerte"><br><br>
<table width="778"  id="table1">

  <tbody>
    <tr class="ligne">
    <th>Date</th>
    <th>Cell_Name</th>
    
    <th>DI_2G_h</th>
    <th>Site</th>
    
    <!-- <th>Commentaire</th> -->
    <th>TOC</th>
    <th>Date_début</th>
    <th>Date_fin</th>
    <!-- <th>Action</th> -->

    </tr>

<?php
    while ($row = mysqli_fetch_array($result)) {
        $date = $row['Date'];
        $cellName = $row['Cell_Name'];
        $di2Gh = $row['DI_2G_h'];
        $codeSite = $row['Code_site'];
        $toc = $row['TOC'];
        $dateDebut = $row['Date_debut'];
        $dateFin = $row['Date_fin'];
   
        ?>


    
    
        <tr>
            <td><?php echo $date ?></td>
            <td><?php echo $cellName ?></td>
            <td><?php echo $di2Gh ?></td>
            <td><?php echo $codeSite ?></td>
            <td><?php echo $toc ?></td>
            <td><?php echo $dateDebut ?></td>
            <td><?php echo $dateFin ?></td>
        </tr>
        

   
  
 
  
   
<?php

    }
  ?>  
    


  </tbody>





  <tbody>
    <tr class="ligne">
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

<?php
    while ($row2 = mysqli_fetch_array($result2)) {
        $date = $row2['Date'];
        $cellName = $row2['Cell_Name'];
        $DI_3g_Heure = $row2['DI_3g_Heure'];
        $codeSite = $row2['Code_site'];
        $toc = $row2['TOC'];
        $dateDebut = $row2['Date_debut'];
        $dateFin = $row2['Date_fin'];
   
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

    }
  ?>  
    


  </tbody>

  </tbody>





  <tbody>
    <tr class="ligne">
    <th>Date</th>
    <th>Cell_Name</th>
    
    <th>Indispo_sys_F_group_DI_h</th>
    <th>Site</th>
    
    <!-- <th>Commentaire</th> -->
    <th>TOC</th>
    <th>Date_début</th>
    <th>Date_fin</th>
    <!-- <th>Action</th> -->

    </tr>

<?php
    while ($row3 = mysqli_fetch_array($result3)) {
        $date = $row3['Date'];
    $cellName = $row3['Cell_Name'];
    $Indispo_sys_F_group_DI_h = $row3['Indispo_sys_F_group_DI_h'];
    $Site = $row3['Site'];
    $toc = $row3['TOC'];
    $dateDebut = $row3['Date_debut'];
    $dateFin = $row3['Date_fin'];
   
        ?>


    
    
        <tr>
            <td><?php echo $date ?></td>
            <td><?php echo $cellName ?></td>
            <td><?php echo $Indispo_sys_F_group_DI_h ?></td>
            <td><?php echo $codeSite ?></td>
            <td><?php echo $toc ?></td>
            <td><?php echo $dateDebut ?></td>
            <td><?php echo $dateFin ?></td>
        </tr>
        

   
  
 
  
   
<?php

    }
  ?>  
    


  </tbody>


</table>







<script>


var copyBtn= document.querySelector('#copy_btn2');
copyBtn.addEventListener('click', function () {
  
   var urlField = document.querySelector('#table1');
  // create a Range object
  var range = document.createRange();  
  // set the Node to select the "range"
  range.selectNode(urlField);
  // add the Range to the set of window selections
  window.getSelection().addRange(range);
   
  // execute 'copy', can't 'cut' in this case
  document.execCommand('copy');
  
  
  window.open('mailto:nizar.saadi1@orange.com?cc=nizar.saadi1@orange.com&subject=tableau NUR&body=','_self');
  

  
 
  
}, false);
</script>
	
	<?php
	
	
	
	
	
	
	

$alerte="<script>alert('Merci d\'appuyer sur le bouton Envoyer mail  et faire coller directement!');</script>";

echo $alerte;





    
?> 
</div>
</body>
</html>