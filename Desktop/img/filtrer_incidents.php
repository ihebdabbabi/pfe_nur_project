  <?php
session_start();
if(!empty($_POST) OR !empty($_FILES))
{
$_SESSION['sauvegarde'] = $_POST ;
$_SESSION['sauvegardeFILES'] = $_FILES ;

$fichierActuel = $_SERVER['PHP_SELF'] ;
if(!empty($_SERVER['QUERY_STRING']))
{
$fichierActuel .= '?' . $_SERVER['QUERY_STRING'] ;
}

header('Location: ' . $fichierActuel);
exit;
}

if(isset($_SESSION['sauvegarde']))
{
$_POST = $_SESSION['sauvegarde'] ;
$_FILES = $_SESSION['sauvegardeFILES'] ;

unset($_SESSION['sauvegarde'], $_SESSION['sauvegardeFILES']);
}



if($_SESSION['admin']=="")
		
	{
		
		?>
	<script type="text/javascript">

alert("Pas d'utilsateur connecté/ Prière de vous connecter");
	window.open("index.php","_self");
</script>
	<?php
		
	}

	 include "conn2.php";




?>
  
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
<link rel="stylesheet" type="text/css" href="css/page10.css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/style9.css" />
<link rel="shortcut icon" type="image/x-icon" href="img/1200px-Orange_logo.svg.png" />
	<title>Filtrer les incidents</title>
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
	<link rel="stylesheet" type="text/css" href="/media/css/site-examples.css?_=6239e0117a45e8466919cf6525f8d1f2">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
	<style type="text/css" class="init">
	
	</style>
	<script type="text/javascript" src="/media/js/site.js?_=09b203e247031aa5935209252694085f"></script>
	<script type="text/javascript" src="/media/js/dynamic.php?comments-page=extensions%2Fbuttons%2Fexamples%2Fhtml5%2Fsimple.html" async></script>
	<script type="text/javascript" language="javascript" src="media/js/jquery-3.5.1.js"></script>
	<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="media/js/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="media/js/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="media/js/vfs_fonts.js"></script>
	<script type="text/javascript" language="javascript" src="media/js/buttons.html5.min.js"></script>
	<script type="text/javascript" language="javascript" src="resources/js/demo.js"></script>
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
  <script src="js/bootstrap-datepicker.js"></script>
	
	
	
	
	
	
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="media/css/dataTables.bootstrap.css">
	<link rel="stylesheet" type="text/css" href="resources/syntax/shCore.css">
	<link rel="stylesheet" type="text/css" href="resources/demo.css">
	<style type="text/css" class="init">
	
	</style>
	
	
		<style  type="text/css">

thead input {
        width: 100%;
    }

</style>
	
	<script type="text/javascript" class="init">
	


$(document).ready(function() {
		$(".bar").fadeOut(3000,function(){
  $("#content").fadeIn(500);
});
	// Setup - add a text input to each footer cell
    $('#example thead tr').clone(true).appendTo( '#example thead' );
    $('#example thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Rechercher" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

 $('.input-daterange').datepicker({
  todayBtn:'linked',
  format: "dd/mm/yyyy",
 
  autoclose: true
 });



	var table=$('#example').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdfHtml5'
		],
		"order": [[ 0, "desc" ]],pageLength: 5,language: {
            url: "media/js/French.json"
},orderCellsTop: true,
		fixedHeader: true
	} );
} );




	</script>
	
   
	

</head>

<body class="dt-example dt-example-bootstrap">
<div class="container">
		<div class="bar">
			<span class="sphere"></span>
		</div>
		</div>
		 <div id="content">
<p>&nbsp;</p>
<p style="text-align: center; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif; font-size: 36px;"><strong>Filter les incidents RX</strong></p>

	

	
	
	
	
<div align="center">
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="myform">
	

<table><tr><td>
	 <div class="input-daterange">
      <div class="col-md-4">
       Date d&eacute;but entre &nbsp;<input type="text" name="Datedeb1" id="start_date"/>&nbsp;&nbsp;<input type="text" name="Datedeb2" id="end_date"/>
          
     </div>
	</div>
	</td><td><input type="submit" value="Afficher Incidents" name="filtre" class="submitstyle6"></td></tr></table>
	
	
<table id="example" class="table table-striped table-bordered" style="width:100%">
<thead>
	
	
	
	<tr>
<th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">ID</th>	
<th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">C.Noeud</th>
<th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">Zone</th>
<th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">Début</th>
<th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">Fin</th>
<th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">Type</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">S.Famille</th>
<th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">C2G</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">C3G</th>
<th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">C4G</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">Service</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">Nature</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">Cause Alerte</th>
<th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">Cause</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">Action</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">Ticket</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">Durée</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">Criticité</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">Semaine</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">Initiateur</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">Fermer par</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">FII par</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">FII enregistrée</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">FII envoyée</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">CL</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">MD</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">FII</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">Ennvoi FII</th><th style="text-align: center; font-size: 15px; color: #000000;" bgcolor="#C0C0C0">SUP</th>
	</tr>
	 </thead>
	<tbody>

	
	
	
	
<?php
	
	

if(isset($_POST['filtre'])){
	
	$dated1=$_POST['Datedeb1'];
	$dated2=$_POST['Datedeb2'];
	
	
	
		if($dated1!="" AND $dated2!="" ){
		
		$ddebi1=	$dated1." 00:00:00";


$d1 = explode(" ", $ddebi1); 


$d1date = explode("/", $d1[0]);
$d1heure = explode(":", $d1[1]);


//$newdatedeb1=$d1date[2]."-".$d1date[1]."-".$d1date[0]." ".$d1heure[0].":".$d1heure[1].":".$d1heure[2];
			$newdatedeb1=$d1date[2]."-".$d1date[1]."-".$d1date[0];

		
		
		$ddebi2=	$dated2." 00:00:00";


$d2 = explode(" ", $ddebi2); 

$d2date = explode("/", $d2[0]);
$d2heure = explode(":", $d2[1]);


$newdatedeb2=$d2date[2]."-".$d2date[1]."-".$d2date[0];
		
		
		
		
$sql = "SELECT *,DATE_FORMAT(Date_debut,'%d/%m/%Y %H:%i') As Date_debut,DATE_FORMAT(Date_fin,'%d/%m/%Y %H:%i') As Date_fin FROM incident2 WHERE (Date_debut >= '$newdatedeb1%') AND (Date_debut <'$newdatedeb2%' or Date_debut like '$newdatedeb2%') ";
			
$result = $bdd->query($sql);



if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		
		
		$tinc=$row["T_incident"];
		$toccs=$row["TOC"];
		$urltoc="https://calipso-oceane.sso.infra.ftgroup/binOceane/Ticket/Detail/defaultPopup?COOKIENAME=ticketOceane.net&PAGEPOPUP=/binOceane/Ticket/Detail/FrameTic%3FSEQUENCE%3D%26TicketAction%3DVis%26ITEM%3D".$toccs."%26BLNGESTIONDROIT%3DFALSE%26ARCHIVE%3D0%26QUICKSEARCH%3D1%26GRPID%3D595054%26COOKIENAME%3DticketOceane.net&PAGE_REFERER=/binOceane/Home/BodyMnuGen&ACTION=undefined&ITEM=undefined&NUMFEN=4";
		
  
?>

<tr>

<form method="post" action="fii2.php" target="_blank">
<td style="text-align: center;envoyer_fii.php font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><input type="hidden"  name="varID" value=<?php echo $row["Id_incident"]; ?>><?php echo $row["Id_incident"]; ?></td>
     <td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><input type="hidden"  name="sites" value=<?php echo $row["Code_sites"]; ?>><?php echo $row["Code_sites"]; ?></td> 
    <td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><input type="hidden"  name="Zonesimp2" value=<?php echo $row["Zones"]; ?>><?php echo $row["Zones"]; ?>	 </td>  
    <td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><input type="hidden"  name="ddeb" value=<?php echo $row["Date_debut"]; ?>><?php echo $row["Date_debut"]; ?> </td>  
    <td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><input type="hidden"  name="ddfin" value=<?php echo $row["Date_fin"]; ?>><?php echo $row["Date_fin"]; ?></td>  
    <td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><input type="hidden"  name="familles" value=<?php echo $row["famille"]; ?>><?php echo $row["famille"]; ?>	 </td>  
    <td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><input type="hidden"  name="Sfamilles" value=<?php echo $row["sous_famille"]; ?>><?php echo $row["sous_famille"]; ?>	 </td>  
    <td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><input type="hidden"  name="2g" value=<?php echo $row["Nb_2G"]; ?>><?php echo $row["Nb_2G"]; ?> </td>  
    <td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><input type="hidden"  name="3g" value=<?php echo $row["Nb_3G"]; ?>><?php echo $row["Nb_3G"]; ?> </td>   
    <td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><input type="hidden"  name="4g" value=<?php echo $row["Nb_4G"]; ?>><?php echo $row["Nb_4G"]; ?> </td> 
    <td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><input type="hidden"  name="serv" value=<?php echo $row["services"]; ?>><?php echo $row["services"]; ?>	 </td> 
    <td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><input type="hidden"  name="typi" value=<?php echo $row["Type_incident"]; ?>><?php echo $row["Type_incident"]; ?> </td> 
	<td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><input type="hidden"  name="calerte" value=<?php echo $row["cause_alerte"]; ?>><?php echo $row["cause_alerte"]; ?> </td> 
	
    <td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><input type="hidden"  name="causes" value=<?php echo $row["cause"]; ?>><?php echo $row["cause"]; ?>	 </td> 
    <td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><input type="hidden"  name="actions" value=<?php echo $row["action"]; ?>><?php echo $row["action"]; ?> </td> 
	<td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><input type="hidden"  name="TOCCS" value=<?php echo $row["TOC"]; ?>><a href=<?php echo $urltoc; ?> target="_blank"><?php echo $row["TOC"]; ?></a> </td> 
	<td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><?php echo $row["Duree"]; ?> </td> 
	<td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><?php echo $row["Criticite"]; ?> </td> 
	<td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><?php echo $row["Semaine"]; ?> </td> 
	<td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><?php echo $row["initiateur"]; ?> </td> 
	<td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><?php echo $row["fermer_par"]; ?> </td> 
	<td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><?php echo $row["FII_par"]; ?> </td> 
	<td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><?php echo $row["FII_enregistree"]; ?> </td> 
	<td style="text-align: center; font-size: 14px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;"><?php echo $row["FII_envoyee"]; ?> </td> 
	
	</form>
	<form method="post" action="fermer_incident2.php" target="_blank">
<input type="hidden"  name="varID" value=<?php echo $row["Id_incident"]; ?>>
<td align="center"><input type=submit  value="" class="clos" title="Fermer incident"></td> 
</form>
<form method="post"  action="modifier_incident2.php" target="_blank" id="supr">
<input type="hidden"  name="varID" value=<?php echo $row["Id_incident"]; ?>>
<td align="center"><input type=submit  value="" class="modif" title="Modifier incident" onClick="confirmation();"></td> 
</form>

<?php if($tinc=="RX") { ?>
<form method="post" action="fii2.php" target="_blank">
<input type="hidden"  name="varID" value=<?php echo $row["Id_incident"]; ?>>
<td align="center"><input type=submit  value="" class="liste" title="Créer FII"></td> 
</form>
<?php } else {
	?>
	<form method="post" action="fii_it.php" target="_blank">
<input type="hidden"  name="varID" value=<?php echo $row["Id_incident"]; ?>>
<td align="center"><input type=submit  value="" class="liste" title="Créer FII"></td> 
</form>

<?php }
	?>
<form method="post" action="envoyer_fii.php" target="_blank">
<input type="hidden"  name="varID" value=<?php echo $row["Id_incident"]; ?>>
<td align="center"><input type=submit  value="" class="liste" title="Envoyer mail FII"></td> 
</form>



<form method="post"  action="supprimer_incident2.php" target="_blank" id="supr">
<input type="hidden"  name="varID" value=<?php echo $row["Id_incident"]; ?>>
<td align="center"><input type=submit  value="" class="supp" title="Supprimer incident" onClick="confirmation();"></td> 
</form>
 </tr>    	

<?php



    
}
}



		
			
		}
		
		
		
		
	
	
}


		
		

    
?> 


</table>
	</div>	
	</div>




</body>
</html>
