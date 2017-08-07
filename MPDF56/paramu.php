<?php
echo "hai";
$html = '
<h1><a name="top"></a>mPDF</h1>
<h2>Basic HTML Example</h2>
<img src="http://localhost/phplot-5.8.0/test.php"/>
';


include("pdfconverter/mpdf.php");

$mpdf=new mPDF(); 

$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>