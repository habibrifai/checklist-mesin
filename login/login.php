<!-- ini kode buat fungsi login user -->
<?php 
include '../config.php';

 // waktu input username tadi, inputannya ditangkep disini
$user = $_POST['username'];
 // $password = md5($_POST['password']);

 //waktu input password adi, inputannya ditangkep disini
$pass = $_POST['password'];

$username = mysqli_real_escape_string($conn, $user);
$password = md5(mysqli_real_escape_string($conn, $pass));

 // cek apakah inputan username password sama dengan yang di database
$login = mysqli_query($conn, "select * from user where username='$username' and password='$password'");
$cek = mysqli_num_rows($login);

if ($cek > 0) {
	while($row = mysqli_fetch_assoc($login)){   

 //kalo username password sesuai sama yang di database, maka buka halaman home user
		if($cek > 0 && $row['jabatan']=='Petugas Inspeksi'){
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['status'] = "login user";
			header("location:../user/dashboard");
 //kalo username password tidak sesuai sama yang di database, maka akan kembali ke halaman login	
		}elseif($cek > 0 && $row['jabatan']=='Supervisor') {
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['status'] = "login supervisor";
			header("location:../supervisor");
	// header("location:../dashboard/index.php");
		}elseif($cek > 0 && $row['jabatan']=='Administrator'){
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['status'] = "login admin";
			header("location:../admin");
		}
	}
} else {
	 // header("location:index.php");	
	echo "<script>alert('Username atau password salah!!')</script>";
	echo "<script>location.href='index.php';</script>";	
}

?>

