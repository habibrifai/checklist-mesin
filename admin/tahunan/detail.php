<?php

$conn = mysqli_connect('localhost','root','');

mysqli_select_db($conn, 'checklist_mesin'); 

date_default_timezone_set("Asia/Bangkok");

$tgl = $_POST['tanggal'];
$noForm = $_POST['noform'];

$data_inspeksi = mysqli_query($conn, "SELECT form.periode, hasil.no_equipment_data, hasil.kondisi, form.tanggal, form.nip_pemeriksa, form.nip_pj, hasil.keterangan FROM user JOIN form ON user.nip_user = form.nip_pemeriksa JOIN hasil ON form.no_form = hasil.no_form WHERE form.no_form = '$noForm'");

while($row = mysqli_fetch_array($data_inspeksi)){
	$nip_pemeriksa = $row['nip_pemeriksa'];
	$nip_pj = $row['nip_pj'];
}
// var_dump($data_inspeksi);

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
		$this->Cell(170,8,'CHECK LIST TAHUNAN/TA(TURN AROUND)/PERTA',1,0,'C');
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
		$this->Cell(78,10,'Hari / Tanggal : '. tanggal_indo($_POST['tanggal'], true),1,0,'L');
		$this->Ln();
		$this->Cell(10);
		$this->Cell(53,10,'Equipment',1,0,'C');
		$this->Cell(25,10,'Kondisi',1,0,'C'); 
		$this->Cell(90,10,'Hasil Pemeriksaan',1,0,'C'); 
		$this->Cell(90,10,'Rekomendasi',1,0,'C'); 
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

$data_inspeksi = mysqli_query($conn, "SELECT form.periode, hasil.no_equipment_data, hasil.kondisi, form.tanggal, form.nip_pemeriksa, form.nip_pj, hasil.keterangan, hasil.rekomendasi FROM user JOIN form ON user.nip_user = form.nip_pemeriksa JOIN hasil ON form.no_form = hasil.no_form WHERE form.no_form = '$noForm'");

while($baris = mysqli_fetch_array($data_inspeksi)){

	$pdf->SetFont('Times','',12);
	$w = 90;
	$h = 8;

	if ($pdf->GetStringWidth($baris['rekomendasi']) < $w) {
		$line=1;
	} else {
		$textLength = strlen($baris['rekomendasi']);
		$errMargin = 8;
		$startChar = 0;
		$maxChar = 0;
		$textArray = Array();
		$tmpString = "";

		while ($startChar < $textLength) {
			while ($pdf->GetStringWidth($tmpString) < ($w - $errMargin) && ($startChar+$maxChar) < $textLength) {
				$maxChar++;
				$tmpString = substr($baris['rekomendasi'],$startChar,$maxChar);
			}
			$startChar = $startChar+$maxChar;
			array_push($textArray, $tmpString);

			$maxChar = 0;
			$tmpString = '';
		}
		$line = count($textArray)+1;
	}

	if ($pdf->GetStringWidth($baris['keterangan']) < $w) {
		$line1=1;
	} else {
		$textLength1 = strlen($baris['keterangan']);
		$errMargin1 = 8;
		$startChar1 = 0;
		$maxChar1 = 0;
		$textArray1 = Array();
		$tmpString1 = "";

		while ($startChar1 < $textLength1) {
			while ($pdf->GetStringWidth($tmpString1) < ($w - $errMargin1) && ($startChar1+$maxChar1) < $textLength1) {
				$maxChar1++;
				$tmpString1 = substr($baris['keterangan'],$startChar1,$maxChar1);
			}
			$startChar1 = $startChar1+$maxChar1;
			array_push($textArray1, $tmpString1);

			$maxChar1 = 0;
			$tmpString1 = '';
		}
		$line1 = count($textArray1)+1;
	}



	if ($baris['no_equipment_data'] == 35) {
		$jenis = '  Shell';
	} 
	if ($baris['no_equipment_data'] == 36) {
		$jenis = '  Sparger';
	}
	if ($baris['no_equipment_data'] == 37) {
		$jenis = '  Riding Gear';
	}
	if ($baris['no_equipment_data'] == 38) {
		$jenis = '  Pinion Gear';
	}
	if ($baris['no_equipment_data'] == 39) {
		$jenis = '  Riding Ring inlet dan outlet';
	}
	if ($baris['no_equipment_data'] == 40) {
		$jenis = '  Turnion roll inlet dan outlet';
	}
	if ($baris['no_equipment_data'] == 41) {
		$jenis = '  Support bearing pinion gear';
	}

	if ($line1 > $line) {
		$l = $line1;
		$ls = $line1 - $line;
		$space_rek = " ";

		if ($ls == 1) {
			$GLOBALS['space_rek'] = "\n\n ";
		} 
		if ($ls == 2) {
			$GLOBALS['space_rek'] = "\n\n\n ";
		} 
		if ($ls == 3) {
			$GLOBALS['space_rek'] = "\n\n\n\n ";
		}
		if ($ls == 4) {
			$GLOBALS['space_rek'] = "\n\n\n\n\n ";
		}
		if ($ls == 5) {
			$GLOBALS['space_rek'] = "\n\n\n\n\n\n ";
		}
		if ($ls == 6) {
			$GLOBALS['space_rek'] = "\n\n\n\n\n\n\n ";
		}
		if ($ls == 7) {
			$GLOBALS['space_rek'] = "\n\n\n\n\n\n\n\n ";
		}
		if ($ls == 8) {
			$GLOBALS['space_rek'] = "\n\n\n\n\n\n\n\n\n ";
		}
		if ($ls == 9) {
			$GLOBALS['space_rek'] = "\n\n\n\n\n\n\n\n\n\n ";
		}
		if ($ls == 10) {
			$GLOBALS['space_rek'] = "\n\n\n\n\n\n\n\n\n\n\n ";
		}

		$space_ket = "\n ";
		
	} elseif ($line > $line1) {
		$l = $line;
		$ls = $line - $line1;
		$space_ket = "\n ";

		if ($ls == 1) {
			$GLOBALS['space_ket'] = "\n\n ";
		} 
		if ($ls == 2) {
			$GLOBALS['space_ket'] = "\n\n\n ";
		} 
		if ($ls == 3) {
			$GLOBALS['space_ket'] = "\n\n\n\n ";
		}
		if ($ls == 4) {
			$GLOBALS['space_ket'] = "\n\n\n\n\n ";
		}
		if ($ls == 5) {
			$GLOBALS['space_ket'] = "\n\n\n\n\n\n ";
		}
		if ($ls == 6) {
			$GLOBALS['space_ket'] = "\n\n\n\n\n\n\n ";
		}
		if ($ls == 7) {
			$GLOBALS['space_ket'] = "\n\n\n\n\n\n\n\n ";
		}
		if ($ls == 8) {
			$GLOBALS['space_ket'] = "\n\n\n\n\n\n\n\n\n ";
		}
		if ($ls == 9) {
			$GLOBALS['space_ket'] = "\n\n\n\n\n\n\n\n\n\n ";
		}
		if ($ls == 10) {
			$GLOBALS['space_ket'] = "\n\n\n\n\n\n\n\n\n\n\n ";
		}

		$space_rek = "\n ";
	}

	elseif ($line == $line1) {
		$l = $line;

		$space_ket = " ";
		$space_rek = " ";
	}

	$pdf->Cell(10);
	$pdf->Cell(53,($l * $h), $jenis,1,0);
	$pdf->Cell(25,($l * $h), $baris['kondisi'],1,0,'C');

	$xPos = $pdf->GetX();
	$yPos = $pdf->GetY();
	$pdf->MultiCell($w,$h,$baris['keterangan'].$space_ket,1);
	$pdf->SetXY($xPos + $w , $yPos);

	$xPos = $pdf->GetX();
	$yPos = $pdf->GetY();
	$pdf->MultiCell($w,$h,$baris['rekomendasi'].$space_rek,1);
	$pdf->SetXY($xPos + $w , $yPos);

	$pdf->Cell(0,($l * $h), '',0,0);

	$pdf->Ln();

}

$pdf->Ln(25);
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