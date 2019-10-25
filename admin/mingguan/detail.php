<?php

$conn = mysqli_connect('localhost','root','');

// ini nama database yang di mysql
mysqli_select_db($conn, 'checklist_mesin'); 

date_default_timezone_set("Asia/Bangkok");

$tgl = $_POST['tanggal'];
$noForm = $_POST['noform'];

$data_inspeksi = mysqli_query($conn, "SELECT form.periode, hasil.no_equipment_data, hasil.kondisi, form.tanggal, form.nip_pemeriksa, form.nip_pj, hasil.keterangan FROM user JOIN form ON user.nip_user = form.nip_pemeriksa JOIN hasil ON form.no_form = hasil.no_form WHERE form.no_form = '$noForm'");

while($row = mysqli_fetch_array($data_inspeksi)){
	$nip_pemeriksa = $row['nip_pemeriksa'];
	$nip_pj = $row['nip_pj'];
}

$nama_supervisor = mysqli_query($conn, "SELECT nama FROM user WHERE jabatan = 'Supervisor'");
$namaSupervisor = mysqli_fetch_assoc($nama_supervisor);

$nama_petugas = mysqli_query($conn, "SELECT nama FROM user WHERE nip_user='$nip_pemeriksa'");
$namaPetugas = mysqli_fetch_assoc($nama_petugas);

$nama_pj = mysqli_query($conn, "SELECT nama FROM user WHERE nip_user='$nip_pj'");
$namaPj = mysqli_fetch_assoc($nama_pj);

require_once('../fpdf/fpdf.php');

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
	$split 	  = explode('-', $tanggal);
	$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	
	if ($cetak_hari) {
		$num = date('N', strtotime($tanggal));
		return $hari[$num] . ', ' . $tgl_indo;
	}
	return $tgl_indo;
}

class myPDF extends FPDF{

	function Header()
	{
		$this->Cell(10);
		$this->Cell(40,32,'',1,0,'L');
		$this->Image('../../assets/gambar/logo_kecil.png',23,11,35);
		$this->SetFont('Times','',13);

		// $this->Cell(40);
		$this->Cell(170,8,'Nomor Dokumen : '.$_POST['noform'],1,0,'L');
		$this->Cell(48,8,'Tanggal : '.date('d-m-Y', strtotime($_POST['tanggal'])),1,0,'L');
		$this->Ln();

		$this->Cell(50);
		$this->Cell(170,8,'CHECK LIST MINGGUAN',1,0,'C');
		$this->Cell(48,8,'Terbitan :',1,0,'L');
		$this->Ln();

		$this->Cell(50);
		$this->Cell(170,8,'EQUIPMENT ROTARY DRUM GRANULATOR 09M - 109',1,0,'C');
		$this->Cell(48,8,'Revisi    :',1,0,'L');
		$this->Ln();

		$this->Cell(50);
		$this->Cell(170,8,'DEPARTEMEN PRODUKSI II A',1,0,'C');
		$this->Cell(48,8,'Halaman :  '.$this->PageNo().' dari {nb}',1,0,'L');
		$this->Ln(15);
	}

	function headerTable()
	{
		$this->SetFont('Times','B',12);
		$this->Cell(10);
		$this->Cell(105,10,'Hari / Tanggal : '. tanggal_indo($_POST['tanggal'], true),1,0,'L');
		$this->Ln();
		$this->Cell(10);
		$this->Cell(80,10,'Equipment',1,0,'C');
		$this->Cell(25,10,'Kondisi',1,0,'C'); 
		$this->Cell(153,10,'Keterangan / Critical',1,0,'C'); 
		$this->Ln();
	}
}

$pdf = new myPDF();
$pdf->AliasNbPages(); // fungsi untuk mengitung jumlah total halaman
$pdf->AddPage('L'); // membuat halaman landscape
$pdf->SetFont('Times','',12);

$jenis = Array();
$hasil = Array();
$ket = Array();

$pdf->headerTable();

$data_inspeksi = mysqli_query($conn, "SELECT form.periode, hasil.no_equipment_data, hasil.kondisi, form.tanggal, form.nip_pemeriksa, form.nip_pj, hasil.keterangan FROM user JOIN form ON user.nip_user = form.nip_pemeriksa JOIN hasil ON form.no_form = hasil.no_form WHERE form.no_form = '$noForm'");

while($baris = mysqli_fetch_array($data_inspeksi)){

	$pdf->SetFont('Times','',12);
	$w = 153;
	$h = 8;

	if ($pdf->GetStringWidth($baris['keterangan']) < $w) {
		$line=1;
	} else {
		$textLength = strlen($baris['keterangan']);
		$errMargin = 8;
		$startChar = 0;
		$maxChar = 0;
		$textArray = Array();
		$tmpString = "";

		while ($startChar < $textLength) {
			while ($pdf->GetStringWidth($tmpString) < ($w - $errMargin) && ($startChar+$maxChar) < $textLength) {
				$maxChar++;
				$tmpString = substr($baris['keterangan'],$startChar,$maxChar);
			}
			$startChar = $startChar+$maxChar;
			array_push($textArray, $tmpString);

			$maxChar = 0;
			$tmpString = '';
		}
		$line = count($textArray);
	}

	if ($baris['no_equipment_data'] == 1) {
		$jenis = '  Area & penerangan';
	} 
	if ($baris['no_equipment_data'] == 2) {
		$jenis = '  Motor / fan';
	}
	if ($baris['no_equipment_data'] == 3) {
		$jenis = '  Turbo coupling';
	}
	if ($baris['no_equipment_data'] == 4) {
		$jenis = '  Bearing / reducer';
	}
	if ($baris['no_equipment_data'] == 5) {
		$jenis = '  Greasing system';
	}
	if ($baris['no_equipment_data'] == 6) {
		$jenis = '  Outlet granul';
	}
	if ($baris['no_equipment_data'] == 7) {
		$jenis = '  Line / Spray gas duct';
	}
	if ($baris['no_equipment_data'] == 8) {
		$jenis = '  Blast aerator';
	}
	if ($baris['no_equipment_data'] == 9) {
		$jenis = '  Sparger';
	}
	if ($baris['no_equipment_data'] == 10) {
		$jenis = '  Line / nozzle SA';
	}
	if ($baris['no_equipment_data'] == 11) {
		$jenis = '  Line / nozzle NH3';
	}
	if ($baris['no_equipment_data'] == 12) {
		$jenis = '  Line / nozzle Steam';
	}
	if ($baris['no_equipment_data'] == 13) {
		$jenis = '  Line / nozzle slurry';
	}
	if ($baris['no_equipment_data'] == 14) {
		$jenis = '  Ploughshare';
	}
	if ($baris['no_equipment_data'] == 15) {
		$jenis = '  Rubber panel';
	}
	if ($baris['no_equipment_data'] == 16) {
		$jenis = '  Caping';
	}
	if ($baris['no_equipment_data'] == 17) {
		$jenis = '  Steam Caping';
	}

	$pdf->Cell(10);
	$pdf->Cell(80,($line * $h), $jenis,1,0);
	$pdf->Cell(25,($line * $h), $baris['kondisi'],1,0,'C');

	$xPos = $pdf->GetX();
	$yPos = $pdf->GetY();
	$pdf->MultiCell($w,$h,$baris['keterangan'],1);

	$pdf->SetXY($xPos + $w , $yPos);

	$pdf->Cell(0,($line * $h), '',0,0);

	$pdf->Ln();

}

$pdf->Ln(20);
$pdf->Cell(10);
$pdf->Cell(70,10,'Pemeriksa,',0,0,'C');
$pdf->Cell(118,10,'',0,0,'L');
$pdf->Cell(70,10,'Penanggungjawab,',0,0,'C');
$pdf->Ln();
$pdf->Cell(10);
$pdf->Cell(70,25,$pdf->Image('../../assets/gambar/'.$nip_pemeriksa.'.png',$pdf->GetX(), $pdf->GetY(), 65),0,0,'C',false);
$pdf->Cell(118,25,'',0,0,'L');
$pdf->Cell(70,25,$pdf->Image('../../assets/gambar/ttd_pj.png',$pdf->GetX(), $pdf->GetY(), 65),0,0,'C',false);
$pdf->Ln();
$pdf->Cell(10);
$pdf->Cell(70,10,'( '.$namaPetugas['nama'].' )',0,0,'C');
$pdf->Cell(118,10,'',0,0,'L');
$pdf->Cell(70,10,'( '.$namaPj['nama'].' )',0,0,'C');

$pdf->Output(''.$tgl.'.pdf','I');

?>