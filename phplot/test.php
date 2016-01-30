<?php
# PHPlot Example:  Flat Pie with options
require_once 'phplot.php';

$data = array(
  array('a', 10000),
  array('b', 15000),
  array('c', 2000),
  array('e', 0),
 
);

$plot = new PHPlot(600, 400);
$plot->SetImageBorderType('none');
$plot->SetDataType('text-data-single');
$plot->SetDataValues($data);
$plot->SetPlotType('pie');
function mycallback($str)
{
 list($value, $label) = explode(' ', $str, 2);
 return sprintf('%s (%.1f)', $label, $value);
}
$colors = array('red', 'green', 'blue', 'yellow');
$plot->SetDataColors($colors);
//$plot->SetLegend($colors);
$plot->SetShading(15);
$plot->SetPieLabelType(array('value', 'label'), 'custom', 'mycallback');
//$plot->SetPieLabelType('value', 'data', 2);
//$plot->SetLabelScalePosition(0.3);

$plot->DrawGraph();

?>
