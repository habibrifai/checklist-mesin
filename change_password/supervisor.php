<?php 
$base = "http://localhost/checklist_mesin/";

include '../config.php';
 
// mengaktifkan session
session_start();
 
// cek apakah user telah login, jika belum login maka di alihkan ke halaman login
if($_SESSION['status'] == NULL){
        header("location:../login");
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ganti Password User</title>

    <!-- Bootstrap Core CSS -->
    <link href="../user/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../user/dashboard/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../user/dashboard/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../user/dashboard/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                <img style="float: left; margin-left: 4px" width="10%" height="auto" src="../assets/gambar/logo_kecil.png"><a class="navbar-brand" href="index.html">PT PETROKIMIA GRESIK</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li>
                    <a href="../logout">
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
                            <a href="<?php echo $base; ?>supervisor"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="<?php echo $base; ?>supervisor/sop.php" target="_blank"><i class="fa fa-edit fa-fw"></i> SOP</a>
                        </li>
                        <li>
                            <a href="<?php echo $base; ?>supervisor/supervisi_petugas.php"><i class="fa fa-user fa-fw"></i> Supervisi Petugas</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Pengaturan<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="active" href="<?php echo $base; ?>change_password/supervisor.php">Ganti Password</a>
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
	        <br>
	        <br>
	        <div class="row">
	        <div class="col-lg-6 col-md-offset-3">
	        <div class="panel panel-default">
                <div class="panel-heading">
                    Ganti Password
                </div>
                <div class="panel-body">
                    <form action="save_new_password.php" method="POST">
                    	<div class="form-group">
							<input class="form-control" name="old_pass" placeholder="password lama" required="">
						</div>
						<div class="form-group">
							<input class="form-control" name="new_pass1" placeholder="password baru" required="">
						</div>
						<div class="form-group">
							<input class="form-control" name="new_pass2" placeholder="password baru" required="">
						</div>
						<br>
						<input style="float: right;" class="btn btn-outline btn-primary" type="submit" value="Simpan">
					</form> 
                </div>
            </div>
        	</div>
        	</div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../user/dashboard/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../user/dashboard/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../user/dashboard/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../user/dashboard/dist/js/sb-admin-2.js"></script>	

</body>
</html>