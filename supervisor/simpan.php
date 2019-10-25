<?php
include '../config.php';

session_start();

 // cek apakah user telah login, jika belum login maka di alihkan ke halaman login
if($_SESSION['status'] !="login supervisor"){
	header("location:../login");
}

$nama_pegawai = $_POST['nama_pegawai'];

$ganti_status = mysqli_query($conn, "UPDATE user SET status_inspeksi = 'Disetujui' WHERE nama = '$nama_pegawai';");

echo "<script>alert('Anda telah menyetujui pegawai untuk melakukan inspeksi')</script>";
echo "<script>location.href='index.php';</script>";	

?>