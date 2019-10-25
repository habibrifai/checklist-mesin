<?php 
$base = "http://localhost/checklist_mesin/";

include '../../config.php';

// mengaktifkan session
session_start();

// mengambil session username
$username = $_SESSION['username'];

// mengambil status inspeksi dari petugas
$status = mysqli_query($conn, "select status_inspeksi from user where username='$username'");
$s = mysqli_fetch_assoc($status);

// cek apakah user telah login, jika belum login maka di alihkan ke halaman login
if($_SESSION['status'] !="login user"){
    header("location:". $base."login");
} 

// kalau belum disetujui oleh supervisor, tidak dapat melakukan inspeksi mesin
if ($s['status_inspeksi'] != "Disetujui") {
    echo "<script>alert('Anda belum mendapat izin dari supervisor, silakan hubungi supervisor sebelum melakukan pengisian inspeksi')</script>";
    echo "<script>location.href='../dashboard';</script>";
}

$dataMingguan = array(array('no' => 1, 'nama_inspeksi' => 'Area & penerangan'), 
                    array('no' => 2, 'nama_inspeksi' => 'Motor / fan'),
                    array('no' => 3, 'nama_inspeksi' => 'Turbo coupling'),
                    array('no' => 4, 'nama_inspeksi' => 'Bearing / reducer'),
                    array('no' => 5, 'nama_inspeksi' => 'Greasing system'),
                    array('no' => 6, 'nama_inspeksi' => 'Outlet granul'),
                    array('no' => 7, 'nama_inspeksi' => 'Line / Spray gas duct'),
                    array('no' => 8, 'nama_inspeksi' => 'Blast aerator'),
                    array('no' => 9, 'nama_inspeksi' => 'Sparger'),
                    array('no' => 10, 'nama_inspeksi' => 'Line / nozzle SA'),
                    array('no' => 11, 'nama_inspeksi' => 'Line / nozzle NH3'),
                    array('no' => 12, 'nama_inspeksi' => 'Line / nozzle Steam'),
                    array('no' => 13, 'nama_inspeksi' => 'Line / nozzle slurry'),
                    array('no' => 14, 'nama_inspeksi' => 'Ploughshare'),
                    array('no' => 15, 'nama_inspeksi' => 'Rubber panel'),
                    array('no' => 16, 'nama_inspeksi' => 'Caping'),
                    array('no' => 17, 'nama_inspeksi' => 'Steam Caping'));

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
    <link href="../dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../dashboard/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dashboard/dist/css/sb-admin-2.css" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="../dashboard/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                <img style="float: left; margin-left: 4px" width="10%" height="auto" src="<?php echo $base; ?>assets/gambar/logo_kecil.png"><a class="navbar-brand" href="<?php echo $base; ?>user/dashboard">PT PETROKIMIA GRESIK</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li>
                    <a href="<?php echo $base; ?>logout">
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
                            <a href="../dashboard"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-file-o fa-fw"></i> Pengisian Inspeksi<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                             <li>
                                <a href="../inspeksi_harian"> Harian</a>
                            </li>
                            <li>
                                <a class="active" href="../inspeksi_mingguan"> Mingguan</a>
                            </li>
                            <li>
                                <a href="../inspeksi_bulanan"> Bulanan</a>
                            </li>
                            <li>
                                <a href="../inspeksi_tahunan"> Tahunan</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-wrench fa-fw"></i> Pengaturan<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo $base; ?>change_password">Ganti Password</a>
                            </li>
                        </ul>
                    </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 style="text-align: center;" class="page-header">CHECK LIST MINGGUAN<br>
                        EQUIPMENT ROTARY DRUM GRANULATOR 09M - 109<br>
                        DEPARTEMEN PRODUKSI II A<br>
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p>Tanggal Hari Ini     : <?php echo date("d-m-Y"); ?> </p>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <form action="save_inspeksi_mingguan.php" method="POST">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Equipment</th>
                                                <th>Kondisi</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($dataMingguan as $value) { ?>
                                            <tr>
                                                <td>
                                                    <p><?php echo $value['no']; ?></p>
                                                    <input type="hidden" <?php echo "name=nohb".$value['no']; ?> value="<?php echo $value['no']; ?>">
                                                </td>
                                                <td>
                                                    <p><?php echo $value['nama_inspeksi']; ?></p>
                                                </td>
                                                <td>
                                                    <div class="form_group">
                                                        <label class="radio-inline">
                                                            <input type="radio" <?php echo "name=radio".''.$value['no']; ?> <?php echo "id=baik".''.$value['no']; ?> value="baik" checked >Baik
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" <?php echo "name=radio".''.$value['no']; ?> <?php echo "id=tidak".''.$value['no']; ?> value="tidak baik">Tidak
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" <?php echo "name=kethb".$value['no']; ?> required="">
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <!-- <input style="float: right;" class="btn btn-primary" type="submit" value="Simpan"><br> -->

                                            <?php
                                                $no_doc = mysqli_query($conn, "SELECT no_form FROM form WHERE periode = 'Mingguan' ORDER BY ABS(SUBSTRING(no_form,6,LENGTH(no_form))) DESC LIMIT 1");
                                                $no_dokumen = mysqli_fetch_assoc($no_doc);

                                                if (isset($no_dokumen)) {
                                                    $nomor = 'FM-M-'.(substr($no_dokumen['no_form'], -(strlen($no_dokumen['no_form'])-5)) + 1);
                                                } else {
                                                    $nomor = 'FM-M-1';
                                                }

                                            ?>

                                            <div class="form_group">
                                                <label>Nomor Dokumen</label>
                                                <input class="form-control" type="text" name="no_dokumen" value="<?php echo $nomor; ?>" readonly="">
                                            </div><br>
                                        </tbody>

                                    </table>
                                    <input style="float: right;" class="btn btn-primary" type="submit" value="Simpan">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../dashboard/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../dashboard/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../dashboard/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dashboard/dist/js/sb-admin-2.js"></script>

</body>

</html>