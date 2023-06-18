
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
</style>









</head>

<body>

	
	<p style="text-align: center; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif; font-size: 30px;">&nbsp;</p>
	<p style="text-align: center; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif; font-size: 30px;"><strong>Tableau Alerte impact client</strong></p>
	


<p>&nbsp; </p> 

<div align="center">
	
	<?php
	
	
	$id_toc="11111111";
	$sites="ARI_0004";
	$zones_sites="Jaafar";
	$type="Indisponibilité";
	$service="2G/3G/4G";
	$date_debut="07/06/2023 10:00";
	$nb2g=5;
	$nb3g=10;
	$nb4g=5;
	$nb4g_tdd=0;
	$causee="Coupure courant";
	
$body="TOC: ".$id_toc. "\nCode site: ".$sites."\nZone: ".$zones_sites. "\nType incident2: ".$type. "\nServices: ".$service. "\nDate d\351but: ".$date_debut;













?>

	
<table width="778" border="0"  id="table1">

  <tbody>
    <tr class="ligne">
      <th colspan="7" class="allligne" style="font-family: \'Impact\'; text-align: center; font-size: 45px; color: orange; border-width: 1px; border-style: solid; border-color: black;"><strong>ALERTE INCIDENT</strong></th>
    </tr>
    <tr>
      <td colspan="7" style="font-family: \'Gill Sans\', \'Gill Sans MT\', \'Myriad Pro\', \'DejaVu Sans Condensed\', Helvetica, Arial, sans-serif" class="vide">&nbsp;</td>
    </tr>
    
  </tbody>
</table>
		



<br><br><input class="submitstyle" id="copy_btn2" type="button" value="Envoyer le mail alerte"><br><br>


<?php


$sites_mail=substr($sites, 0, 3);

	//vérif corresp site et resp  boutique









	

$corps='';
$cca='';

$Sujet='[D\351but incident] ' .$type. '- '.$service.' - '.$zones_sites;	
	
?>

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
  
  
  window.open('mailto:nizar.saadi1@orange.com?cc=nizar.saadi1@orange.com&subject=[Début incident] <?php echo $type; ?> <?php echo $service; ?> <?php echo $zones_sites; ?>&body=','_self');
  
  window.close();
  
 
  
}, false);
</script>
	
	<?php
	
	
	
	
	
	
	

$alerte="<script>alert('Merci d\'appuyer sur le bouton Envoyer mail alerte et faire coller directement!');</script>";

echo $alerte;





    
?> 
</div>
</body>
</html>