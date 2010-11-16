<!-- s:<?= __FILE__ ?> -->
<?
#---
$loop = 0;
$cities_list = "";
foreach ($cityStats as $id => $cityId)
{
	if (!empty($cityList[$cityId]))
	{
		$loop++;

		$readolny = ($cityId == 0) ? "checked disabled" : "";
		$cities_list .= "<input type=\"checkbox\" {$readolny} id=\"wscid\" name=\"wscid\" value=\"{$cityId}\" />". ucfirst($cityList[$cityId]['title']) ." (".ucfirst($cityList[$cityId]['urlshort']).") <br />";
		$cities_list .= ($cityId == 0) ? "<br />" : "";
	}
}
?>
<?=$cities_list?>
<!-- e:<?= __FILE__ ?> -->
