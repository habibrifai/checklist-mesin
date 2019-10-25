<?php

$filedisplay="http://localhost/checklist_mesin/assets/sop/SOP_INSPEKSI.pdf";
$filename="SOP_INSPEKSI.pdf";
header('Content-type:application/pdf');
header('Content-disposition: inline; filename="'.$filename.'"');
header('content-Transfer-Encoding:binary');
header('Accept-Ranges:bytes');
@readfile($filedisplay);``

?>