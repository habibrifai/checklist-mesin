<?php 
include '../../config.php';

session_start();

$username = $_SESSION['username'];

 // cek apakah user telah login, jika belum login maka di alihkan ke halaman login
if($_SESSION['status'] !="login user")
	{
    	header("location:../login/index.php");
	}

// set zona waktu
date_default_timezone_set("Asia/Bangkok");

// mengambil nip petugas dari database
$user = mysqli_query($conn, "select nip_user from user where username='$username'");
$nip_p = mysqli_fetch_array($user);
$nip_pemeriksa = $nip_p['nip_user'];

// mengambil nip pj dari database
$user = mysqli_query($conn, "select nip_user from user where jabatan='Administrator'");
$nip_adm = mysqli_fetch_array($user);
$nip_pj = $nip_adm['nip_user'];

// menyimpan data nomor dokumen
$no_form = $_POST['no_dokumen'];

// mengambil tanggal waktu inspeksi
$tanggal = date("Y-m-d");

mysqli_query($conn, "INSERT INTO form(`no_form`, `tanggal`, `nip_pemeriksa`, `nip_pj`, `periode`) VALUES ('$no_form','$tanggal','$nip_pemeriksa','$nip_pj','Mingguan');");

for ($i=1; $i < 18; $i++) { 
	$kondisi = $_POST['radio'.''.$i];
	$keterangan = $_POST['kethb'.''.$i];

	$insert = mysqli_query($conn, "INSERT INTO hasil(`no_form`, `no_equipment_data`, `kondisi`, `keterangan`, `rekomendasi`) VALUES ('$no_form','$i','$kondisi','$keterangan','-');");
}

// ganti status inspeksi petugas menjadi belum disetujui
mysqli_query($conn, "UPDATE user SET status_inspeksi = 'Belum Disetujui' WHERE username = '$username';");

echo "<script>alert('Data Telah Tersimpan')</script>";
echo "<script>location.href='../dashboard';</script>";

?>