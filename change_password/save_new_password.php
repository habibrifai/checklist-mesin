<!-- ini kode buat fungsi ganti password user -->
<?php 
include '../config.php';

session_start();

$username = $_SESSION['username'];

// waktu input password lama tadi, inputannya ditangkep disini
$old_pass = md5($_POST['old_pass']);

// waktu input password baru 1 tadi, inputannya ditangkep disini
$new_pass1 = md5($_POST['new_pass1']);

// waktu input password baru 2 tadi, inputannya ditangkep disini
$new_pass2 = md5($_POST['new_pass2']);

$old_pass_db = mysqli_query($conn, "select password from user where username='$username'");

$p = mysqli_fetch_array($old_pass_db);

if ($old_pass == $p['password']) {
	if ($new_pass1 == $new_pass2) {
		$ganti = mysqli_query($conn, "UPDATE user SET password = '$new_pass1' WHERE username = '$username';");
		echo "<script>alert('Password berhasil diganti, silakan login kembali.')</script>";
		echo "<script>location.href='../logout';</script>";
	} else {
 		// header("location:index.php");
		echo "<script>alert('Password baru tidak sama')</script>";
		echo "<script>location.href='index.php';</script>";
	}
} else {
 	// header("location:index.php");
	echo "<script>alert('Password lama tidak sesuai')</script>";
	echo "<script>location.href='index.php';</script>";
}

?>