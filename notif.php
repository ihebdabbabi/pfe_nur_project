<?php
$cnx = mysqli_connect("localhost", "root", "", "pfe") or die("Connection failed");

$query = "SELECT t2.Date, t2.Cell_Name, t2.DI_2G_h, t2.Code_site, t3.TOC, t3.Date_debut, t3.Date_fin
          INTO OUTFILE '2G.csv' FROM (
            SELECT Date, Cell_Name, DI_2G_h, SUBSTR(Cell_Name, 1, 8) AS Code_site
            FROM `2g_prs`
          ) AS t2
          JOIN (
            SELECT Code_sites, TOC, Date_debut, Date_fin
            FROM `incidents`
          ) AS t3
          ON t2.Code_site = t3.Code_sites AND t2.Date = SUBSTR(t3.Date_debut, 1, 10)";

$result = mysqli_query($cnx, $query);

  


// $query1 = "SELECT t2.Date, t2.Cell_Name, t2.DI_3g_Heure, t2.Code_site, t3.TOC, t3.Date_debut, t3.Date_fin
// INTO OUTFILE 'C:\\wamp64\\www\\NUR\\notif_import\\3G.csv' FROM (
//    SELECT Date, Cell_Name, DI_3g_Heure, SUBSTR(Cell_Name, 1, 8) AS Code_site FROM `3g_prs`
//     ) AS t2
//     JOIN (
//         SELECT Code_sites, TOC, Date_debut, Date_fin
//         FROM `incidents`
//     ) AS t3
//     ON t2.Code_site = t3.Code_sites AND t2.Date = SUBSTR(t3.Date_debut, 1, 10)";

// $result1 = mysqli_query($cnx, $query1);

// $query2 = "SELECT t2.Date, t2.Cell_Name, t2.Indispo_sys_F_group_DI_h, t2.Site, t3.TOC, t3.Date_debut, t3.Date_fin
// INTO OUTFILE 'C:\\wamp64\\www\\NUR\\notif_import\\4G_fdd.csv' FROM
// (SELECT Date, Cell_Name ,Indispo_sys_F_group_DI_h ,SUBSTR(Cell_Name, 1, 8) as Site FROM `4g_prs`
//  WHERE Cell_FDD_TDD_Indication='CELL_FDD' ) AS t2  JOIN( SELECT Code_sites, TOC, Date_debut, Date_fin FROM `incidents`) AS t3
//    ON t2.Site = t3.Code_sites AND t2.Date=SUBSTR(t3.Date_debut, 1, 10)";

// $result2 = mysqli_query($cnx, $query2);

// $query3 = "SELECT t2.Date, t2.Cell_Name, t2.Indispo_sys_F_group_DI_h, t2.Site, t3.TOC, t3.Date_debut, t3.Date_fin
// INTO OUTFILE 'C:\\wamp64\\www\\NUR\\notif_import\\4G_tdd.csv' FROM
// (SELECT Date, Cell_Name ,Indispo_sys_F_group_DI_h ,SUBSTR(Cell_Name, 1, 8) as Site FROM `4g_prs`
//  WHERE Cell_FDD_TDD_Indication='CELL_TDD' ) AS t2  JOIN( SELECT Code_sites, TOC, Date_debut, Date_fin FROM `incidents`) AS t3
//    ON t2.Site = t3.Code_sites AND t2.Date=SUBSTR(t3.Date_debut, 1, 10)";
// $result3 = mysqli_query($cnx, $query3);


?>

<!DOCTYPE html>
<html>
<head>
  <title>Query Results</title>
</head>
<body>

    <?php
    error_reporting(0); 
    ?>
<a href="http://localhost/NUR/notif_import/2G.csv">2G</a>
  <a href="http://localhost/NUR/notif_import/3G.csv">3G</a>
  <a href="http://localhost/NUR/notif_import/4G_fdd.csv">4G FDD</a>
  <a href="http://localhost/NUR/notif_import/4G_tdd.csv">4G TDD</a>
  <a href="mailto:iheb.dabbabii@gmail.com?subject=Query Results&amp;body=">Email Query</a>

    <input type="button"  id="copy_btn2" name="send_email" value="Send Email">
  

  <?php
   
  $email = "iheb.dabbabii@gmail.com"; // Replace with recipient email address
  $subject = "Query Results";
  $body = 'Voila les fichiers'; 
  $encoded_body = urlencode($body);

  ?>

  <script>
  
  
  var copyBtn= document.querySelector('#copy_btn2');
  copyBtn.addEventListener('click', function () {
    
    window.open('mailto:<?php echo $email; ?> ?subject= <?php echo $subject; ?> &body=<?php echo $encoded_body; ?> attachment&attachment=C:\\wamp64\bin\mysql\mysql8.0.31\data\pfe\2G.csv','_self');
     
    
  }, false);
  </script>
    
    <?php
    
 unlink( 'C:\\wamp64\bin\mysql\mysql8.0.31\data\pfe\2G.csv');


?>
</body>
</html>
