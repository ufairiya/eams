<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Maintence Document View</title>
<script type="text/javascript">
<!--
    function printPartOfPage(elementId) {
        var printContent = document.getElementById(elementId);
        var windowUrl = '';
        var uniqueName = new Date();
        var windowName = 'Print' + uniqueName.getTime();
        var printWindow = window.open(windowUrl, windowName, 'left=0,top=0,width=0,height=0');
        printWindow.document.write(printContent.innerHTML);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }
    // -->
    </script>
</head>

<body>
<?php 
$aRequest = $_REQUEST;
$fileName = $aRequest['fdocument'];
$ext      = explode(".", $fileName);
$acond = array('pdf','doc','docx');
if(isset($ext[1]) && !in_array($ext[1],$acond) )
{
?>
<a onClick="JavaScript:printPartOfPage('docprint');" style="cursor:pointer;"><img src="assets/img/printer.png" title="printer" height="50" width="50"></a>
    <div id="docprint"><img src="uploads/servicedocument/<?php echo $fileName;?>"></div>
<?php    
}
?>
</body>
</html>