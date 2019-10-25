<?php 
$base = "http://localhost/checklist_mesin/";

include '../config.php';
// mengaktifkan session
session_start();

// cek apakah user telah login, jika belum login maka di alihkan ke halaman login
if($_SESSION['status'] !="login supervisor"){
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

	<title>Dashboard Supervisor</title>

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
				<img style="float: left; margin-left: 4px" width="10%" height="auto" src="<?php echo $base; ?>assets/gambar/logo_kecil.png"><a class="navbar-brand" href="<?php echo $base; ?>supervisor">PT PETROKIMIA GRESIK</a>
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
							<a href="<?php echo $base; ?>supervisor"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
						</li>
						<li>
							<a href="sop.php" target="_blank"><i class="fa fa-edit fa-fw"></i> SOP</a>
						</li>
						<li>
							<a class="active" href="supervisi_petugas.php"><i class="fa fa-user fa-fw"></i> Supervisi Petugas</a>
						</li>
						<li>
							<a href="#"><i class="fa fa-wrench fa-fw"></i> Pengaturan<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="<?php echo $base; ?>change_password/supervisor.php">Ganti Password</a>
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
        <form action="simpan.php" method="POST">
        <?php

        $result = mysqli_query($conn, "SELECT nama FROM user WHERE jabatan='Petugas Inspeksi'");
        $storeArray = Array();

        while($row = mysqli_fetch_array($result)){
        	$storeArray[] = $row['nama'];                                          
        } ?>

        <div id="page-wrapper">
        	<div class="row">
        		<div class="col-lg-12">
        			<br>
        			<h4>Pilih Petugas Untuk di Supervisi</h4>
        			<div class="form-group">
        				<select name="nama_pegawai" class="form-control">
        					<?php foreach ($storeArray as $key) { ?>

        					<option><?php echo $key; ?></option>
        					<?php } ?>

        				</select>

        			</div>
        		</div>
        	</div>
        	<br>
        	<div class="row">
        		
        			<div style="text-align: center;" class="col-lg-12">
        				<h4>Alat Pelindung Diri</h4>
        				<br>
        				<table width="100%" >
        					<col width="80">
        					<col width="80">
        					<col width="80">
        					<tr>
        						<td><img src="../assets/gambar/gas-mask.png"></td>
        						<td><img style="width: 100px" src="../assets/gambar/protection-gloves.png"></td>
        						<td><img style="width: 100px" src="../assets/gambar/worker-helmet.png"></td>
        					</tr>
        					<tr>
        						<td class="form-group">
                                    <input class="form-control" type="checkbox" value="" required="">
        							<label>Masker Gas</label><br><br><br>
        						</td>
        						<td>
        							<input class="form-control" type="checkbox" value="" required="">
                                    <label>Sarung Tangan</label><br><br><br>
        						</td>
        						<td>
        							<input class="form-control" type="checkbox" value="" required="">
                                    <label>Safety Helmet</label><br><br><br>
        						</td>
        					</tr>
        					<tr>
        						<td><img style="width: 100px" src="../assets/gambar/safety-glasses.png"></td>
        						<td><img style="width: 100px" src="../assets/gambar/dr-mateen-boot.png"></td>
        						<td><img style="width: 100px" src="../assets/gambar/safety-shirt.png"></td>
        					</tr>
        					<tr>
        						<td>
        							<input class="form-control" type="checkbox" value="" required="">
                                    <label>Goggles</label><br><br><br>
        						</td>
        						<td>
        							<input class="form-control" type="checkbox" value="" required="">
                                    <label>Safety Shoes</label><br><br><br>
        						</td>
        						<td>
        							<input class="form-control" type="checkbox" value="" required="">
                                    <label>Cattle Pack</label><br><br><br>
        						</td>
        					</tr>
                            <tr>
                                <td><img style="width: 100px" src="../assets/gambar/safety-belt.png"></td>
                            </tr>
                            <tr>
                                <td>
                                    <input class="form-control" type="checkbox" value="" required="">
                                    <label>Safety Belt</label><br><br><br>
                                </td>
                                <td>
                           
                                </td>
                                <td>
                              
                                </td>
                            </tr>
        				</table> <br><br><br>
        				<?php
        				$username = $_SESSION['username'];
        				$login = mysqli_query($conn, "select nama from user where username='$username'");

        				while($row = mysqli_fetch_assoc($login)){  ?>
        				<div>
        					<textarea style="resize: none; width: 70%; height: 20%;" disabled="" >Dengan ini saya <?php echo $row['nama']; ?> selaku supervisor telah bertanggung jawab terhadap petugas yang terpilih telah menggunakan APD sesuai dengan Standart yang ditentukan
        						<?php } ?>
        					</textarea><br>
        					<label>
        						<input type="checkbox" value="" required="">Saya menyetujui pernyataan diatas.
        					</label>
        				</div>
        				<br>
        				<input style="float: none; margin-bottom: 100px; width: 35%;" class="btn btn-success" type="submit" value="Simpan">
        			</div>  
        		  		
        	</div>
        </div>
    </form>
</body>
<!-- jQuery -->
<script src="<?php echo $base; ?>user/dashboard/vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo $base; ?>user/dashboard/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo $base; ?>user/dashboard/vendor/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="<?php echo $base; ?>user/dashboard/dist/js/sb-admin-2.js"></script>


</html>