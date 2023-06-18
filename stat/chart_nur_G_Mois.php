<?php
$connection = mysqli_connect("localhost","root","","pfe") or die("connection failed");



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
	
	

	$sql_janv = "SELECT nur_T_Global As 'NUR_G' FROM monthly_results where month='$nommois4'";		
	$sql_fev = "SELECT nur_T_Global As 'NUR_G' FROM monthly_results where month='$nommois3'";
	$sql_mars = "SELECT nur_T_Global As 'NUR_G' FROM monthly_results where month='$nommois2'";
	$sql_avril = "SELECT nur_T_Global As 'NUR_G' FROM monthly_results where month='$nommois1'";
	
	    $result = $connection->query($sql_janv);
        $result2 = $connection->query($sql_fev);
		$result3 = $connection->query($sql_mars);
        $result4 = $connection->query($sql_avril);
	
	
	
	 if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		
	$Nbinc_Janvier=$row["NUR_G"];
  

     	
	}
         }
		 
		 
		  if ($result2->num_rows > 0) {
    // output data of each row
    while($row2 = $result2->fetch_assoc()) {
		
	$Nbinc_Fevrier=$row2["NUR_G"];
  

     	
	}
         }
         
        if ($result3->num_rows > 0) {
    // output data of each row
    while($row3 = $result3->fetch_assoc()) {
		
	$Nbinc_Mars=$row3["NUR_G"];
  

     	
	}
         }
		 
		  if ($result4->num_rows > 0) {
    // output data of each row
    while($row4 = $result4->fetch_assoc()) {
		
	$Nbinc_Avril=$row4["NUR_G"];
  

     	

         
		}
}
		

}

?>
	 
	 
	 

    <script>
      
      var options = {
  colors: ['#FF6600', '#48D1CC'],
  series: [{
    name: 'Nombre des cellules',
    data: [<?php echo $Nbinc_Janvier ?>, <?php echo $Nbinc_Fevrier; ?>, <?php echo $Nbinc_Mars; ?>, <?php echo $Nbinc_Avril; ?>]
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
    categories: ['<?php echo $nommois4 ?>', '<?php echo $nommois3 ?>', '<?php echo $nommois2 ?>', '<?php echo $nommois1 ?>'],
  },
  yaxis: {
    title: {
      text: 'NUR'
    },
    plotLines: [{
      value: 250,
      color: 'red',
      width: 2,
      offsetX: 0,
      offsetY: 0,
      zIndex: 0
    }]
  },
  fill: {
    colors: ['#FF6600'],
    opacity: 1
  },
  dataLabels: {
    opacity: 1,
    style: {
      fontSize: '15px',
    }
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return val + " NUR_G"
      }
    }
  },
  title: {
    text: 'NUR_T_Globale',
    floating: true,
    offsetY: 1,
    align: 'center',
    style: {
      color: 'black',
      fontSize: '16px',
      fontWeight: 'bold',
      fontFamily: 'arial'
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
  annotations: {
    yaxis: [{
      y: 250,
      borderColor: '#FF0000',
      label: {
        borderColor: '#FF0000',
        style: {
          color: '#fff',
          background: '#FF0000'
        },
        text: 'Seuil',
        position: 'right'
      }
    }]
  }
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();





      
      
    </script>

    
  </body>
</html>
