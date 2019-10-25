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

$dataTahunan = array(array('no' => 35, 'nama_inspeksi' => 'Shell'), 
                    array('no' => 36, 'nama_inspeksi' => 'Sparger'),
                    array('no' => 37, 'nama_inspeksi' => 'Riding Gear'),
                    array('no' => 38, 'nama_inspeksi' => 'Pinion Gear'),
                    array('no' => 39, 'nama_inspeksi' => 'Riding Ring inlet dan outlet'),
                    array('no' => 40, 'nama_inspeksi' => 'Turnion roll inlet dan outlet'),
                    array('no' => 41, 'nama_inspeksi' => 'Support bearing pinion gear'));

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
                                <a href="../inspeksi_mingguan"> Mingguan</a>
                            </li>
                            <li>
                                <a href="../inspeksi_bulanan"> Bulanan</a>
                            </li>
                            <li>
                                <a class="active" href="../inspeksi_tahunan"> Tahunan</a>
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
                    <h3 style="text-align: center;" class="page-header">CHECK LIST TAHUNAN/TA(TURN AROUND)/PERTA<br>
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
                                <form action="save_inspeksi_tahunan.php" method="POST">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Equipment</th>
                                                <th>Kondisi</th>
                                                <th>Hasil Pemeriksaan</th>
                                                <th>Rekomendasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; foreach ($dataTahunan as $value) { ?>
                                            <tr>
                                                <td>
                                                    <p><?php echo $no; ?></p>
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
                                                    <input class="form-control" type="text" <?php echo "name=hasilpemhb".$value['no']; ?> required="">
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" <?php echo "name=rekomhb".$value['no']; ?> required="">
                                                </td>
                                            </tr>
                                            <?php $no++; } ?>
                                            <!-- <input style="float: right;" class="btn btn-primary" type="submit" value="Simpan"><br> -->

                                            <?php
                                                $no_doc = mysqli_query($conn, "SELECT no_form FROM form WHERE periode = 'Tahunan' ORDER BY ABS(SUBSTRING(no_form,6,LENGTH(no_form))) DESC LIMIT 1");
                                                $no_dokumen = mysqli_fetch_assoc($no_doc);

                                                if (isset($no_dokumen)) {
                                                    $nomor = 'FM-T-'.(substr($no_dokumen['no_form'], -(strlen($no_dokumen['no_form'])-5)) + 1);
                                                } else {
                                                    $nomor = 'FM-T-1';
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