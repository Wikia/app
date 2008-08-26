<!-- s:<?= __FILE__ ?> -->
<!-- NAMESPACE COUNTS TABLE -->
<?php
$kB = 1000;
$mB = $kB * $kB;
if (!empty($namespaceCount))
{
?>	
<br />
<table cellspacing="0" cellpadding="0" border="1" id="table_namespace_stats" style="width:auto; font-family: arial,sans-serif,helvetica; font-size:9pt;background-color:#ffffdd;">
<tr bgcolor="#ffdead">
	<td class="cb" rowspan="2"><b><?= wfMsg('wikiastats_date') ?></b></td>
	<td class="cb" colspan="<?= count($allowedNamespaces) ?>"><b><?= wfMsg('wikiastats_namespace') ?></b></td>
</tr>
<tr bgcolor="#ffeecc">
<?php
	foreach ($namespaces as $n => $nName)
	{
		if (in_array($n, $allowedNamespaces))
		{
?>
	<td class="cb"><?= $nName ?></td>
<?
		}
	}
?>	
</tr>
<?php
foreach ($namespaceCount as $date => $monthStats)
{
	$cntAll = (array_key_exists('count', $monthStats) && !empty($monthStats['count'])) ? intval( $monthStats['count'] ) : 0;
	#---
	$dateArr = explode("-",$date);
	$stamp = mktime(0,0,0,$dateArr[1],1,$dateArr[0]);
	$out = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . $dateArr[0];
	if ($date == sprintf("%s-%s", date("Y"), date("m")))
	{
		$out = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . date("d") . ", " . $dateArr[0];
	}

?>
<tr>
	<td class="eb" nowrap><?= $out ?></td>
<?
	foreach ($namespaces as $n => $nName)
	{
		if (in_array($n, $allowedNamespaces))
		{
			$val = (array_key_exists($n, $monthStats)) ? intval($monthStats[$n]) : 0;
			$out = 
				(empty($val)) ? "" : 
				($val >= $kB) ? sprintf ("%.1f", $val/$kB)." k" : (($val >= $mB) ? sprintf ("%.1f", $val/$mB)." M" : $val);
?>	
	<td class="eb" nowrap><?= $out ?></td>
<?
		}
	}
?>
</tr>	
<?php
}
?>
</table>
<?
}
?>
</div>
<!-- END OF NAMESPACE COUNTS TABLE -->
<!-- e:<?= __FILE__ ?> -->
