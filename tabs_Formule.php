<!DOCTYPE html>
<html>
<head>
    <title>Affichage des résultats</title>
    <style>
        .container {
            display: flex;
            justify-content: space-between;
        }
        .table {
            width: 45%;
            border-collapse: collapse;
            background-color:#ff7900;
        }
        .table td, th {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .cap {
             font-weight: bold ;
        }
        .yellow-bg {
    background-color: #ffd200;
}


    </style>



</head>
<body>
<input type="button"  id="copy_btn2" name="send_email" value="Send Email">
  


<p style="text-align: center; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif; font-size: 36px;"><strong>Resultat NUR-T/B</strong></p>
	
    <div id="example" class="container">
        <table class="table">
              <caption class="cap">NUR_B</caption> 
            <tbody>
                <?php
                // Connexion à la base de données MySQL
                $conn = mysqli_connect("localhost","root","","pfe");

                // Vérifier la connexion
                if (!$conn) {
                    die("Erreur de connexion : " . mysqli_connect_error());
                }

                // Récupérer les en-têtes depuis la table_resultats avec une requête SQL SELECT
                $query_headers = "SELECT DISTINCT nur_B_F_2g AS NUR_B_2G FROM nur_b_2g;";
                $result_headers = mysqli_query($conn, $query_headers);
                $headers = mysqli_fetch_assoc($result_headers);

                $queryb = "SELECT DISTINCT nur_B_F_3g AS NUR_B_3G FROM nur_b_3g";
                $resultb = mysqli_query($conn, $queryb);
                $headersb = mysqli_fetch_assoc($resultb);

                $queryb1 = "SELECT DISTINCT nur_B_F_4g_fdd AS NUR_B_4G_FDD FROM nur_b_4g_fdd";
                $resultb1 = mysqli_query($conn, $queryb1);
                $headersb1 = mysqli_fetch_assoc($resultb1);

                $queryb2 = "SELECT DISTINCT nur_B_F_4g_tdd AS NUR_B_4G_TDD FROM nur_b_4g_tdd";
                $resultb2 = mysqli_query($conn, $queryb2);
                $headersb2 = mysqli_fetch_assoc($resultb2);

                // Afficher les en-têtes dans la première colonne
                echo "<tr>";
                echo "<th>NUR_B_2G</th>";
                echo "<td>" . $headers['NUR_B_2G'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th>NUR_B_3G</th>";
                echo "<td>" . $headersb['NUR_B_3G'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th>NUR_B_4G_FDD</th>";
                echo "<td>" . $headersb1['NUR_B_4G_FDD'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th>NUR_B_4G_FDD</th>";
                echo "<td>" . $headersb2['NUR_B_4G_TDD'] . "</td>";
                echo "</tr>";
               

                // Fermer la connexion à la base de données
                mysqli_close($conn);
                ?>
            </tbody>
        </table>

        <table id="example" class="table">
            <caption class="cap">NUR_T</caption>
            <tbody>
                <?php
                // Connexion à la base de données MySQL
                $conn = mysqli_connect("localhost","root","","pfe");

                // Vérifier la connexion
                if (!$conn) {
                    die("Erreur de connexion : " . mysqli_connect_error());
                }

                // Récupérer les résultats depuis la table_resultats avec une requête SQL SELECT
                $query_headers = "SELECT DISTINCT di_2g_avg AS nur_2g_t, res_nur_T_GL AS nur_global FROM `2g_prs`";
                $result_headers = mysqli_query($conn, $query_headers);
                $headers = mysqli_fetch_assoc($result_headers);

                $query1 = "SELECT DISTINCT di_3g_avg AS NUR_T_3G FROM 3g_prs";
                $result1 = mysqli_query($conn, $query1);
                $headers1 = mysqli_fetch_assoc($result1);

                $query2 = "SELECT DISTINCT di_4g_avg AS NUR_T_4G FROM 4g_prs";
                $result2 = mysqli_query($conn, $query2);
                $headers2 = mysqli_fetch_assoc($result2);

                
                
                // Afficher les en-têtes dans la première colonne
                echo "<tr>";
                echo "<th>NUR_T_2G</th>";
                echo "<td>" . $headers['nur_2g_t'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th>NUR_T_3G</th>";
                echo "<td>" . $headers1['NUR_T_3G'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th>NUR_T_4G</th>";
                echo "<td>" . $headers2['NUR_T_4G'] . "</td>";
                echo "</tr>";

                echo "<tr class='yellow-bg'>";
echo "<th>NUR_T_GLOBAL</th>";
echo "<td>" . $headers['nur_global'] . "</td>";
echo "</tr>";


                // Fermer la connexion à la base de données
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>

<script>

var copyBtn= document.querySelector('#copy_btn2');
copyBtn.addEventListener('click', function () {
  
   var urlField = document.querySelector('#example');
  // create a Range object
  var range = document.createRange();  
  // set the Node to select the "range"
  range.selectNode(urlField);
  // add the Range to the set of window selections
  window.getSelection().addRange(range);
   
  // execute 'copy', can't 'cut' in this case
  document.execCommand('copy');
  
  
  window.open('mailto:iheb.dabbabii@gmail.com?cc=iheb.dabbabii@gmail.com&subject=Tab Result NUR-T/B&body=','_self');
  

  
 
  
}, false);

    </script>

</body>
</html>
