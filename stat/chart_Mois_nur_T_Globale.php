
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

include "calculMois.php";
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



if (!$connection){ // Contrôler la connexion
    $MessageConnexion = die ("connection impossible");
}
else {
	
	

	$sql_janv = "SELECT COUNT(Code_liaison) As 'Nbr_des_incidents' FROM incident WHERE MONTH (Date_debut)='$moism4'";		
	$sql_fev = "SELECT COUNT(Code_liaison) As 'Nbr_des_incidents' FROM incident WHERE MONTH (Date_debut)='$moism3'";
	$sql_mars = "SELECT COUNT(Code_liaison) As 'Nbr_des_incidents' FROM incident WHERE MONTH (Date_debut)='$moism2'";
	$sql_avril = "SELECT COUNT(Code_liaison) As 'Nbr_des_incidents' FROM incident WHERE MONTH (Date_debut)='$moism1'";
	
	    $result = $connection->query($sql_janv);
        $result2 = $connection->query($sql_fev);
		$result3 = $connection->query($sql_mars);
        $result4 = $connection->query($sql_avril);
	
	
	
	 if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		
	$Nbinc_Janvier=$row["Nbr_des_incidents"];
  

     	
	}
         }
		 
		 
		  if ($result2->num_rows > 0) {
    // output data of each row
    while($row2 = $result2->fetch_assoc()) {
		
	$Nbinc_Fevrier=$row2["Nbr_des_incidents"];
  

     	
	}
         }
         
        if ($result3->num_rows > 0) {
    // output data of each row
    while($row3 = $result3->fetch_assoc()) {
		
	$Nbinc_Mars=$row3["Nbr_des_incidents"];
  

     	
	}
         }
		 
		  if ($result4->num_rows > 0) {
    // output data of each row
    while($row4 = $result4->fetch_assoc()) {
		
	$Nbinc_Avril=$row4["Nbr_des_incidents"];
  

     	

         
		}
}
		

}

?>
	 
	 
	 

    <script>
      
        var options = {
			
		colors: ['#FF6600'],	
			
          series: [{
          name: 'Nombre des incidents',
          data: [<?php echo $Nbinc_Janvier ?>, <?php echo $Nbinc_Fevrier; ?>,<?php echo $Nbinc_Mars; ?>,<?php echo $Nbinc_Avril; ?>]
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'flat'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['<?php echo $nommois4 ?>','<?php echo $nommois3 ?>','<?php echo $nommois2 ?>', '<?php echo $nommois1 ?>'],
        },
        yaxis: {
          title: {
            text: 'Incidents'
          }
        },
        fill: {
		  colors: ['#FF6600'],	
          opacity: 1
        },
		
			
			dataLabels: {
					 
				opacity: 1,
				
				 style: {
            
					 fontSize:  '15px',
             
          }
				
				
			},  
			
        tooltip: {
			
			
          y: {
			  
		
            formatter: function (val) {
              return val + " Incidents"
            }
          }
        },
			
			 title: {
          text: 'Nombre des incidents FO par mois',
          floating: true,
          offsetY: 1,
          align: 'center',
          style: {
            color: 'black',
			   fontSize:  '16px',
               fontWeight:  'bold',
               fontFamily:  'arial'
          }
        },
			 legend: {
      
				 labels: {
					 colors: 'black',
					 
				 },
				markers: {
          width: 12,
          height: 12,
          strokeWidth: 0,
          strokeColor: '#fff',
          fillColors: undefined,
          customHTML: undefined,
          onClick: undefined,
          offsetX: 0,
          offsetY: 0
      },
				 
				 
    },
			
        
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
      
      
    </script>

    
  </body>
</html>

