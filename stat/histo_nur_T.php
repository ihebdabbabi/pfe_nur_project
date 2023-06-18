<?php
include "calculMois.php";

$connection = mysqli_connect("localhost", "root", "", "pfe") or die("connection failed");
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

      .apexcharts-datalabel {
    fill: #000000 !important;
  }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
  </head>

  <body>
    <div id="chart"></div>

    <script>
      var options = {
        colors: ["#FF6600", "#48D1CC", "#a885d8"], 
        series: [
          {
            name: "NUR_T_2G",
            data: [],
          },
          {
            name: "NUR_T_3G",
            data: [],
          },
          {
            name: "NUR_T_4G",
            data: [],
          },
        ],
        chart: {
          type: "bar",
          height: 350,
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: "55%",
            endingShape: "flat",
            dataLabels: {
              position: "top",
              enabled: true,
              formatter: function (val) {
                return val + " ";
              },
            },
          },
        },
        dataLabels: {
          enabled: true,
          
          formatter: function (val) {
            return val + "";
          },
        },
        stroke: {
          show: true,
          width: 2,
          colors: ["transparent"],
        },
        xaxis: {
          categories: ['<?php echo $nommois4 ?>','<?php echo $nommois3 ?>','<?php echo $nommois2 ?>', '<?php echo $nommois1 ?>'],
        },
        yaxis: {
          title: {
            text: "NUR",
          },
          
        },
        fill: {
          colors: ["#FF6600", "#48D1CC", "#a885d8"],
          opacity: 1,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + "";
            },
          },
        },
        title: {
          text: "NUR_T",
          floating: true,
          offsetY: 1,
          align: "center",
          style: {
            color: "black",
            fontSize: "16px",
            fontWeight: "bold",
            fontFamily: "arial",
          },
        },
        legend: {
          labels: {
            colors: "black",
          },
          markers: {
            width: 12,
            height: 12,
            strokeWidth: 0,
            strokeColor: "#fff",
            fillColors: undefined,
            customHTML: undefined,
            onClick: undefined,
            offsetX: 0,
            offsetY: 0,
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

      <?php
      if ($connection) {
        $sql_janv = "SELECT nur_T_2G AS 'NUR_T' FROM monthly_results WHERE month='$nommois4'";
        $sql_fev = "SELECT nur_T_2G AS 'NUR_T' FROM monthly_results WHERE month='$nommois3'";
        $sql_mars = "SELECT nur_T_2G AS 'NUR_T' FROM monthly_results WHERE month='$nommois2'";
        $sql_avril = "SELECT nur_T_2G AS 'NUR_T' FROM monthly_results WHERE month='$nommois1'";

        $result = $connection->query($sql_janv);
        $result2 = $connection->query($sql_fev);
        $result3 = $connection->query($sql_mars);
        $result4 = $connection->query($sql_avril);

        $Nbinc_Janvier = 0;
        $Nbinc_Fevrier = 0;
        $Nbinc_Mars = 0;
        $Nbinc_Avril = 0;

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $Nbinc_Janvier = $row["NUR_T"];
          }
        }

        if ($result2->num_rows > 0) {
          while ($row2 = $result2->fetch_assoc()) {
            $Nbinc_Fevrier = $row2["NUR_T"];
          }
        }

        if ($result3->num_rows > 0) {
          while ($row3 = $result3->fetch_assoc()) {
            $Nbinc_Mars = $row3["NUR_T"];
          }
        }

        if ($result4->num_rows > 0) {
          while ($row4 = $result4->fetch_assoc()) {
            $Nbinc_Avril = $row4["NUR_T"];
          }
        }

        echo "chart.updateSeries([
          {
            name: 'NUR_T_2G',
            data: [$Nbinc_Janvier, $Nbinc_Fevrier, $Nbinc_Mars, $Nbinc_Avril],
          },
        ]);";

        $sql_janv_3g = "SELECT nur_T_3G AS 'NUR_T_3G' FROM monthly_results WHERE month='$nommois4'";
        $sql_fev_3g = "SELECT nur_T_3G AS 'NUR_T_3G' FROM monthly_results WHERE month='$nommois3'";
        $sql_mars_3g = "SELECT nur_T_3G AS 'NUR_T_3G' FROM monthly_results WHERE month='$nommois2'";
        $sql_avril_3g = "SELECT nur_T_3G AS 'NUR_T_3G' FROM monthly_results WHERE month='$nommois1'";

        $result3G = $connection->query($sql_janv_3g);
        $result2_3G = $connection->query($sql_fev_3g);
        $result3_3G = $connection->query($sql_mars_3g);
        $result4_3G = $connection->query($sql_avril_3g);

        $Nbinc_Janvier_3G = 0;
        $Nbinc_Fevrier_3G = 0;
        $Nbinc_Mars_3G = 0;
        $Nbinc_Avril_3G = 0;

        if ($result3G->num_rows > 0) {
          while ($row3G_1 = $result3G->fetch_assoc()) {
            $Nbinc_Janvier_3G = $row3G_1["NUR_T_3G"];
          }
        }

        if ($result2_3G->num_rows > 0) {
          while ($row3G_2 = $result2_3G->fetch_assoc()) {
            $Nbinc_Fevrier_3G = $row3G_2["NUR_T_3G"];
          }
        }

        if ($result3_3G->num_rows > 0) {
          while ($row3G_3 = $result3_3G->fetch_assoc()) {
            $Nbinc_Mars_3G = $row3G_3["NUR_T_3G"];
          }
        }

        if ($result4_3G->num_rows > 0) {
          while ($row3G_4 = $result4_3G->fetch_assoc()) {
            $Nbinc_Avril_3G = $row3G_4["NUR_T_3G"];
          }
        }

        echo "chart.updateSeries([
          {
            name: 'NUR_T_2G',
            data: [$Nbinc_Janvier, $Nbinc_Fevrier, $Nbinc_Mars, $Nbinc_Avril],
          },
          {
            name: 'NUR_T_3G',
            data: [$Nbinc_Janvier_3G, $Nbinc_Fevrier_3G, $Nbinc_Mars_3G, $Nbinc_Avril_3G],
          },
        ]);";


        $sql_janv_4g = "SELECT nur_T_4G AS 'NUR_T_4G' FROM monthly_results WHERE month='$nommois4'";
        $sql_fev_4g = "SELECT nur_T_4G AS 'NUR_T_4G' FROM monthly_results WHERE month='$nommois3'";
        $sql_mars_4g = "SELECT nur_T_4G AS 'NUR_T_4G' FROM monthly_results WHERE month='$nommois2'";
        $sql_avril_4g = "SELECT nur_T_4G AS 'NUR_T_4G' FROM monthly_results WHERE month='$nommois1'";

        $result4G = $connection->query($sql_janv_4g);
        $result2_4G = $connection->query($sql_fev_4g);
        $result3_4G = $connection->query($sql_mars_4g);
        $result4_4G = $connection->query($sql_avril_4g);

        $Nbinc_Janvier_4G = 0;
        $Nbinc_Fevrier_4G = 0;
        $Nbinc_Mars_4G = 0;
        $Nbinc_Avril_4G = 0;

        if ($result4G->num_rows > 0) {
          while ($row4G_1 = $result4G->fetch_assoc()) {
            $Nbinc_Janvier_4G = $row4G_1["NUR_T_4G"];
          }
        }

        if ($result2_4G->num_rows > 0) {
          while ($row4G_2 = $result2_4G->fetch_assoc()) {
            $Nbinc_Fevrier_4G = $row4G_2["NUR_T_4G"];
          }
        }

        if ($result3_4G->num_rows > 0) {
          while ($row4G_3 = $result3_4G->fetch_assoc()) {
            $Nbinc_Mars_4G = $row4G_3["NUR_T_4G"];
          }
        }

        if ($result4_4G->num_rows > 0) {
          while ($row4G_4 = $result4_4G->fetch_assoc()) {
            $Nbinc_Avril_4G = $row4G_4["NUR_T_4G"];
          }
        }

        echo "chart.updateSeries([
          {
            name: 'NUR_T_2G',
            data: [$Nbinc_Janvier, $Nbinc_Fevrier, $Nbinc_Mars, $Nbinc_Avril],
          },
          {
            name: 'NUR_T_3G',
            data: [$Nbinc_Janvier_3G, $Nbinc_Fevrier_3G, $Nbinc_Mars_3G, $Nbinc_Avril_3G],
          },
          {
            name: 'NUR_T_4G',
            data: [$Nbinc_Janvier_4G, $Nbinc_Fevrier_4G, $Nbinc_Mars_4G, $Nbinc_Avril_4G],
          },
        ]);";


      }
      ?>
     </script>
  </body>
</html>
