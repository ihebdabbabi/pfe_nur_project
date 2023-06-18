<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <style> 
        body {
            background-color: #ffffff;
        }
        table {
            border-collapse: collapse;
            background-color: #ffffff;
        }
        td, th {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            color: black;
            background-color: #4bb4e6;
        }
        tbody{
            background-color: #E6E6E6;
        }
    </style>
</head>
<body>

<a href="../menu/maquette.php">
    <img src="../menu/logo-orange" alt="Description de l'image">
</a>
   
<!--main content start-->
<section login="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="content-panel">
                    <h4><a class="nav-link"><i class="fa fa-angle-right"></i> Liste des utilisateurs</a></h4>
                    <hr>
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th>Login</th>
                                <th>Mot de passe</th>
                                <th>Rôle</th>
                                <th>Mail</th>
                                <th>Tel</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $con = mysqli_connect("localhost","root","","pfe") or die("connection failed");

                                $sql = "SELECT * FROM `utilisateur`";
                                $result = mysqli_query($con, $sql);

                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $login = $row['Login'];
                                        $password = $row['Password'];
                                        $usertype = $row['usertype'];
                                        $mail = $row['Mail'];
                                        $tel = $row['Tel'];

                                        echo '<tr>
                                                <td>'.$login.'</td>
                                                <td>'.$password.'</td>
                                                <td>'.$usertype.'</td> 
                                                <td>'.$mail.'</td> 
                                                <td>'.$tel.'</td>
                                                <td>
                                                    <button class="btn btn-primary">
                                                        <a href="../Desktop/modifier_user.php?updatelogin='.$login.'" class="text-light">Update</a>
                                                    </button>
                                                    <button class="btn btn-danger">
                                                        <a href="../Desktop/deleteuser.php?deletelogin='.$login.'" class="text-light">Delete</a>
                                                    </button>
                                                </td>
                                            </tr>';
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div><!-- /content-panel -->
            </div><!-- /col-md-12 -->
        </div><!-- /row -->
    </section>
</section><!-- /MAIN CONTENT -->

<!--footer start-->
<footer class="site-footer">
    <div class="text-center">
        Copyright © Orange.TN 2023
        <a href="basic_table.php" class="go-top">
            <i class="fa fa-angle-up"></i>
        </a>
    </div>
</footer>
<!--footer end-->

<!-- js placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>
<script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>

</body>
</html>
