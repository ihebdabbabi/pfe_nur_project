<?php
session_start();



if($_SESSION['login']=="")
		
	{
		
		?>
	<script type="text/javascript">

alert("Pas d'utilsateur connecté/ Prière de vous connecter");
	window.open("index.php","_self");
</script>
	<?php
		
	}


include "conn.php";
include "calcul_semaine.php";

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Basic Column - Grouped</title>

    <link href="css/styles.css" rel="stylesheet" />

    <style>
      
        #chart {
      max-width: 650px;
      margin: 35px auto;
    }
      
    </style>

    <script>
      window.Promise ||
        document.write(
          '<script src="js/polyfill.min.js"><\/script>'
        )
      window.Promise ||
        document.write(
          '<script src="js/classList.min.js"><\/script>'
        )
      window.Promise ||
        document.write(
          '<script src="js/findindex_polyfill_mdn"><\/script>'
        )
    </script>

    
    <script src="js/apexcharts.js"></script>
    

    
  </head>

  <body>
     <div id="chart"></div>



<?php

$Nbinc_Janvier_aimp="";
$Nbinc_Janvier_simp="";
$Nbinc_Fevrier_aimp="";
$Nbinc_Fevrier_simp="";

$Nbinc_Mars_aimp="";
$Nbinc_Mars_simp="";
$Nbinc_Avril_aimp="";
$Nbinc_Avril_simp="";


 

if (!$connection){ // Contrôler la connexion
    $MessageConnexion = die ("connection impossible");
}
else {
	
	
	

			
		
	$sql_Janvier_aimp = "SELECT COUNT(Code_liaison) As 'Nbr_des_incidents' FROM incident WHERE Semaine='$weekm4' AND Nature_impact='Avec impact'";
$sql_Janvier_simp = "SELECT COUNT(Code_liaison) As 'Nbr_des_incidents' FROM incident WHERE Semaine='$weekm4' AND Nature_impact='Sans impact'"; 
$sql_Fevrier_aimp = "SELECT COUNT(Code_liaison) As 'Nbr_des_incidents' FROM incident WHERE Semaine='$weekm3' AND Nature_impact='Avec impact'"; 
	$sql_Fevrier_simp = "SELECT COUNT(Code_liaison) As 'Nbr_des_incidents' FROM incident WHERE Semaine='$weekm3' AND Nature_impact='Sans impact'";
	
	$sql_Mars_aimp = "SELECT COUNT(Code_liaison) As 'Nbr_des_incidents' FROM incident WHERE Semaine='$weekm2' AND Nature_impact='Avec impact'";
$sql_Mars_simp = "SELECT COUNT(Code_liaison) As 'Nbr_des_incidents' FROM incident WHERE Semaine='$weekm2' AND Nature_impact='Sans impact'"; 
$sql_Avril_aimp = "SELECT COUNT(Code_liaison) As 'Nbr_des_incidents' FROM incident WHERE Semaine='$weekm1' AND Nature_impact='Avec impact'"; 
	$sql_Avril_simp = "SELECT COUNT(Code_liaison) As 'Nbr_des_incidents' FROM incident WHERE Semaine='$weekm1' AND Nature_impact='Sans impact'";
	
	
		$result = $connection->query($sql_Janvier_aimp);
        $result2 = $connection->query($sql_Janvier_simp);
		$result3 = $connection->query($sql_Fevrier_aimp);
        $result4 = $connection->query($sql_Fevrier_simp);
		
		$result5 = $connection->query($sql_Mars_aimp);
        $result6 = $connection->query($sql_Mars_simp);
		$result7 = $connection->query($sql_Avril_aimp);
        $result8 = $connection->query($sql_Avril_simp);
		
		
	
         
       if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		
	$Nbinc_Janvier_aimp=$row["Nbr_des_incidents"];
  

     	
	}
         }
		 
		  if ($result2->num_rows > 0) {
    // output data of each row
    while($row2 = $result2->fetch_assoc()) {
		
	$Nbinc_Janvier_simp=$row2["Nbr_des_incidents"];
  

     	

         
		}
}
		
		
		
		  if ($result3->num_rows > 0) {
    // output data of each row
    while($row3 = $result3->fetch_assoc()) {
		
	$Nbinc_Fevrier_aimp=$row3["Nbr_des_incidents"];
  

     	

         
		}
}




  if ($result4->num_rows > 0) {
    // output data of each row
    while($row4 = $result4->fetch_assoc()) {
		
	$Nbinc_Fevrier_simp=$row4["Nbr_des_incidents"];
  

     	

         
		}
}




if ($result5->num_rows > 0) {
    // output data of each row
    while($row5 = $result5->fetch_assoc()) {
		
	$Nbinc_Mars_aimp=$row5["Nbr_des_incidents"];
  

     	
	}
         }
		 
		  if ($result6->num_rows > 0) {
    // output data of each row
    while($row6 = $result6->fetch_assoc()) {
		
	$Nbinc_Mars_simp=$row6["Nbr_des_incidents"];
  

     	

         
		}
}
		
		
		
		  if ($result7->num_rows > 0) {
    // output data of each row
    while($row7 = $result7->fetch_assoc()) {
		
	$Nbinc_Avril_aimp=$row7["Nbr_des_incidents"];
  

     	

         
		}
}




  if ($result8->num_rows > 0) {
    // output data of each row
    while($row8 = $result8->fetch_assoc()) {
		
	$Nbinc_Avril_simp=$row8["Nbr_des_incidents"];
  

     	

         
		}
}








}

?>
	 
	 
	 
	 

    <script>
      
      var options = {
		  colors: ['#008000','#FF0000'],	
        series: [{
			name: 'Sans impact',
          data: [<?php echo $Nbinc_Janvier_simp; ?>, <?php echo $Nbinc_Fevrier_simp; ?>,<?php echo $Nbinc_Mars_simp; ?>, <?php echo $Nbinc_Avril_simp; ?>]
        },{
          name: 'Avec impact',
          data: [<?php echo $Nbinc_Janvier_aimp; ?>, <?php echo $Nbinc_Fevrier_aimp; ?>,<?php echo $Nbinc_Mars_aimp; ?>, <?php echo $Nbinc_Avril_aimp; ?>]
        }],
          
          chart: {
          type: 'bar',
          height: 350,
          stacked: true,
          toolbar: {
            show: true
          },
          zoom: {
            enabled: true
          }
        },
        responsive: [{
          breakpoint: 480,
          options: {
            legend: {
              position: 'bottom',
              offsetX: -10,
              offsetY: 0
            }
          }
        }],
        plotOptions: {
          bar: {
            horizontal: false,
          },
        },
        xaxis: {
 categories: ['<?php echo $nameweekm4 ?>','<?php echo $nameweekm3 ?>','<?php echo $nameweekm2 ?>', '<?php echo $nameweekm1 ?>'],
        },
        legend: {
          position: 'right',
          offsetY: 40,
		  offsetY: 1
        },
        fill: {
			colors: ['#008000','#FF0000'],	
          opacity: 1
        },
        
		
		 title: {
          text: 'Répartition des incidents FO par type d’impact',
          floating: true,
          offsetY: 1,
          align: 'center',
          style: {
            color: 'black',
			   fontSize:  '16px',
               fontWeight:  'bold',
               fontFamily:  'arial'
          }
        }
			};

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
      
      
    
      
		
    </script>

    
  </body>
</html>

