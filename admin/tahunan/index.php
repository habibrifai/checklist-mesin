<?php 
$base = "http://localhost/checklist_mesin/";

include '../../config.php';

// mengaktifkan session
session_start();

$username = $_SESSION['username'];

// print_r($s['isi_inspeksi']);

// cek apakah user telah login, jika belum login maka di alihkan ke halaman login
if($_SESSION['status'] !="login admin"){
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

    <title>Inspeksi Tahunan</title>

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
                <img style="float: left; margin-left: 4px" width="10%" height="auto" src="<?php echo $base; ?>assets/gambar/logo_kecil.png"><a class="navbar-brand" href="<?php echo $base; ?>admin">PT PETROKIMIA GRESIK</a>
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
                            <a href="../"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="../sop.php" target="_blank"><i class="fa fa-edit fa-fw"></i> SOP</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-file-o fa-fw"></i> Data Inspeksi<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="../harian"> Harian</a>
                                </li>
                                <li>
                                    <a href="../mingguan"> Mingguan</a>
                                </li>
                                <li>
                                    <a href="../bulanan"> Bulanan</a>
                                </li>
                                <li>
                                    <a class="active" href="../tahunan"> Tahunan</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Pengaturan<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo $base; ?>change_password/admin.php">Ganti Password</a>
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
            <div class="row">
                <div class="col-lg-12">
                    <h3 style="text-align: center;" class="page-header">CHECK LIST TAHUNAN/TA(TURN AROUND)/PERTA<br>
                        EQUIPMENT ROTARY DRUM GRANULATOR 09M - 109<br>
                        PABRIK PHONSKA I DEPARTEMEN PRODUKSI II A<br>
                    </h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p>Data Inspeksi Harian</p>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>No Dokumen</th>
                                            <th>Hari, Tanggal Inspeksi</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>

                                        <?php

                                        function tanggal_indo($tanggal, $cetak_hari = false)
                                        {
                                            $hari = array ( 1 =>    'Senin',
                                                'Selasa',
                                                'Rabu',
                                                'Kamis',
                                                'Jumat',
                                                'Sabtu',
                                                'Minggu'
                                            );
                                            
                                            $bulan = array (1 =>   'Januari',
                                                'Februari',
                                                'Maret',
                                                'April',
                                                'Mei',
                                                'Juni',
                                                'Juli',
                                                'Agustus',
                                                'September',
                                                'Oktober',
                                                'November',
                                                'Desember'
                                            );
                                            $split    = explode('-', $tanggal);
                                            $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
                                            
                                            if ($cetak_hari) {
                                                $num = date('N', strtotime($tanggal));
                                                return $hari[$num] . ', ' . $tgl_indo;
                                            }
                                            return $tgl_indo;
                                        }
                                        
                                        $dataTanggal = mysqli_query($conn, "SELECT form.no_form, hasil.no_equipment_data, form.tanggal FROM form JOIN hasil ON form.no_form = hasil.no_form WHERE form.periode = 'Tahunan' GROUP BY form.tanggal DESC HAVING COUNT(*) > 1");

                                        $storeArray = Array();

                                        $no = 1;

                                        while($row = mysqli_fetch_array($dataTanggal)){ ?>
                                        
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <form action="detail.php" method="POST">
                                                 <td><?php echo $row['no_form']; ?>
                                                    <input type="hidden" name="noform" value="<?php echo $row['no_form']; ?>">
                                                </td>
                                                <td><?php echo tanggal_indo($row['tanggal'], true); ?>
                                                    <input type="hidden" name="tanggal" value="<?php echo $row['tanggal']; ?>">
                                                </td>
                                                <td class="form-group">
                                                    <input class="btn btn-primary" type="submit" value="Detail">
                                                </td>
                                            </form>
                                        </tr>
                                        <?php $no++; } ?>
                                    </tbody>
                                    
                                    
                                </table>
                                
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>

        </div>
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