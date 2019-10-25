<?php 
$base = "http://localhost/checklist_mesin/";

include '../../config.php';
// mengaktifkan session
session_start();

// cek apakah user telah login, jika belum login maka di alihkan ke halaman login
if($_SESSION['status'] !="login user"){
    header("location:". $base."login");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard User</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo $base; ?>user/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo $base; ?>user/dashboard/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo $base; ?>user/dashboard/dist/css/sb-admin-2.css" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="<?php echo $base; ?>user/dashboard/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img style="float: left; margin-left: 4px" width="20%" height="auto" src="<?php echo $base; ?>assets/gambar/logo_kecil.png">
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li>
                    <a href="<?php echo $base; ?>/logout">
                        <i class="fa fa-sign-out fa-fw"></i> Logout
                    </a>
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a class="active" href="<?php echo $base; ?>user/dashboard"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <!-- <li>
                            <a href="#"><i class="fa fa-edit fa-fw"></i> Data Inspeksi</a>
                        </li> -->
                        <li>
                            <a href="#"><i class="fa fa-file-o fa-fw"></i> Pengisian Inspeksi<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="../inspeksi_harian"> Harian</a>
                                </li>
                                <li>
                                    <a href="../inspeksi_mingguan"> Mingguan</a>
                                </li>
                                <li>
                                    <a href="../inspeksi_bulanan"> Bulanan</a>
                                </li>
                                <li>
                                    <a href="../inspeksi_tahunan"> Tahunan</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Pengaturan<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo $base; ?>change_password">Ganti Password</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <!-- <li>
                            <a href="pages/tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                        </li> -->
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row" align="center">
                <!-- <div class="col-lg-12"> -->
                    <!-- <h1 class="page-header">Dashboard</h1> -->

                    <?php
                    $username = $_SESSION['username'];
                    $login = mysqli_query($conn, "select nama from user where username='$username'");

                    while($row = mysqli_fetch_assoc($login)){  ?>              

                    <h3>SELAMAT DATANG, <?php echo $row['nama'] ?></h3>
                    <?php } ?>
                    <h4>SISTEM INFORMASI PENDUKUNG PELAYANAN CHECKLIST K3 PADA DIESEL ENGINE GENERATOR SET</h4>
                    

                    <!-- </div> -->

                </div>
                <!-- /.row -->
                <div class="row" align="center">
                 <img width="70%" height="auto" src="<?php echo $base; ?>assets/gambar/logo.png">
             </div>
             <!-- /.row -->
         </div>
         <!-- /#page-wrapper -->

     </div>
     <!-- /#wrapper -->

     <!-- jQuery -->
     <script src="<?php echo $base; ?>user/dashboard/vendor/jquery/jquery.min.js"></script>

     <!-- Bootstrap Core JavaScript -->
     <script src="<?php echo $base; ?>user/dashboard/vendor/bootstrap/js/bootstrap.min.js"></script>

     <!-- Metis Menu Plugin JavaScript -->
     <script src="<?php echo $base; ?>user/dashboard/vendor/metisMenu/metisMenu.min.js"></script>

     <!-- Custom Theme JavaScript -->
     <script src="<?php echo $base; ?>user/dashboard/dist/js/sb-admin-2.js"></script>

 </body>

 </html>