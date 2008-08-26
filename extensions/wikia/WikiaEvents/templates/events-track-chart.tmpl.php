<!-- s:<?= __FILE__ ?> -->
<p>
<table cellspacing="0" cellpadding="6" border="0" width="<?= $eventChartMaxSize ?>">
<tr><td colspan=3 align="center" style="text-decoration:underline; font-weight:bold;"><?= $eventChartTitle ?></td></tr>
<tr><td align="right" valign=top width="30%">
<TABLE style="font-family: Arial; font-size:7pt;" cellpadding=0 cellspacing=0 valign=bottom width="100%">
<?php
for ($i = 0; $i < sizeof($eventChartData); $i++)
{
	$td_height = $eventChartBarSize + 2;
?>	
	<tr><td valign="middle" style="height:<?= $td_height ?><?= $eventChartBarUnit ?>;width:100%; padding-right:5px;" align="right">
		<div style="font-weight:normal;height:<?= $eventChartBarSize ?><?= $eventChartBarUnit ?>;font-size:7pt;">
			<?= $eventChartData[$i]['field'] ?>
		</div>
	</td></tr>
<?php
}
?>
</table>
<?php

$iMax = 0;
$sum = 0;
for($iRow = 0; $iRow < sizeof($eventChartData); $iRow++) 
{
	if($eventChartData[$iRow]['cnt'] > $iMax)
	{
		$iMax = $eventChartData[$iRow]['cnt'];
	}
	$sum += $eventChartData[$iRow]['cnt']; 
}
$iScale = $iMax / $eventChartMaxSize;
?>
</td>
<td align="left" valign="top" width="65%">
<TABLE style="border-bottom:1px solid black;border-left:1px solid black;font-family:Arial;font-size:7pt;" cellpadding="0" cellspacing="0" valign="bottom" width="80%">
<?php
for ($iRow = 0; $iRow < sizeof($eventChartData); $iRow++)
{
	if($eventChartData[$iRow]['cnt'] > $iMax)
	{
		$iMax = $eventChartData[$iRow]['cnt'];
	}
	$iScale = $iMax / $eventChartMaxSize;
	$sColor = ($iRow % 2) ? "background-color:".$eventChartColors[1] : "background-color:".$eventChartColors[0]; 
	$iBarLength = $eventChartData[$iRow]['cnt'] / $iScale;
	$iBarLength = (empty($iBarLength)) ? 2 : $iBarLength;
	$td_height = $eventChartBarSize + 2;
	
	$percent = round( ($eventChartData[$iRow]['cnt']/$sum) * 100 ) ;
?>
<tr><td valign="bottom" style="height:<?= $td_height ?><?= $eventChartBarUnit ?>; width:<?= $percent ?>%;">
<TABLE cellpadding="0" cellspacing="0" valign="bottom" width="100%" border=0>
<tr>
<td style="width:<?= $percent ?>%;">
<div style="<?= $sColor ?>;text-align:right;color:white;height:<?= $eventChartBarSize ?><?= $eventChartBarUnit ?>;width:100%;font-size:<?= $psFontSize ?>;"></div>
</td>
<td valign=middle align="left" width="100%" style="height:<?= $td_height ?><?= $eventChartBarUnit ?>;color:<?= $sColor ?>;font-weight:bold;padding-left:3px;"><?= $percent ?>%</td>
</tr>
</table>
</td>
</tr>
<?php 
}
?>

</table>
</td><td width="5%">&nbsp;</td></tr>
<tr><td colspan=3 align="center" style="height:<?= $eventChartBarSize ?><?= $eventChartBarUnit ?>">&nbsp;</td></tr>
</table>
</p>
<!-- e:<?= __FILE__ ?> -->

