
<?php


$connection = mysqli_connect("localhost","root","","pfe") or die("connection failed");

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



if (!$connection){ // Contrôler la connexion
    $MessageConnexion = die ("connection impossible");
}
else {
	
	

	$sql_janv = "SELECT di_3g_avg_works As 'Nbr_des_incidents' FROM 3g_prs  ";		
	$sql_fev = "SELECT di_4g_avg_works_fdd As 'Nbr_des_incidents' FROM 4g_prs  ";	
  
	
	    $result = $connection->query($sql_janv);
        $result2 = $connection->query($sql_fev);
		
	
	
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
         
        
  

     	

         
		}


?>
	 
	 
	 

    <script>
      
        var options = {
			
		colors: ['#FF6600','#48D1CC'],	
			
          series: [{
          name: 'Nur_works_3G ',
          data: [<?php echo $Nbinc_Janvier ?>, ]
        },
        {
          name: 'Nur_works_4G',
          data: [ <?php echo $Nbinc_Fevrier; ?>]
      }
    ],
        
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
          enabled: true
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['<?php echo $nameweekm4 ?>','<?php echo $nameweekm3 ?>','<?php echo $nameweekm2 ?>', '<?php echo $nameweekm1 ?>'],
        },
        yaxis: {
          title: {
            text: 'WORKS' 
          }
        },
        fill: {
		  colors: ['#FF6600','#48D1CC'],	
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
              return val + " Works"
            }
          }
        },
			
			 title: {
          text: 'Nur Works',
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

