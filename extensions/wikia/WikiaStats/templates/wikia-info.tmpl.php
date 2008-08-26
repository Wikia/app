<?php
$outDate = "";
$created = (is_object($city_row)) ? $city_row->city_created : null;
if (!empty($created) && ($created != "0000-00-00 00:00:00"))
{
	$dateTime = explode(" ", $created);
	#---
	$dateArr = explode("-", $dateTime[0]);
	#---
	$stamp = mktime(0,0,0,$dateArr[1],$dateArr[2],$dateArr[0]);
	$outDate = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . $dateArr[2] .", ". $dateArr[0]. " ".$dateTime[1];
}
$langName = (is_object($city_row)) ? $wgContLang->getLanguageName( $city_row->city_lang ) : " - ";
$catName = (is_object($city_row) && !empty($cats) && array_key_exists($city, $cats)) ? $cats[$city]['name'] : " - ";
$cityTitle = (is_object($city_row) && $city > 0) ? ucfirst($city_row->city_title) : (($city == 0) ? wfMsg("wikiastats_trend_all_wikia_text") : " - ");
$cityUrl = (is_object($city_row) && $city > 0) ? "<a target=\"new\" href=\"".$city_row->city_url."\">".$city_row->city_url."</a>" : " - ";
$rights = $user->getGroups(); $is_special = 0;
foreach ($rights as $id => $right) {
	if (in_array($right, array('staff', 'sysop', 'janitor', 'bureaucrat'))) {
		$is_special = 1;
	} 
}
?>
<!-- s:<?= __FILE__ ?> -->
<!-- WIKI's INFORMATION -->	
<table cellspacing="0" cellpadding="1" border="0" style="width:250px; font-size:8.5pt;font-family: verdana,arial,sans-serif,helvetica;">
<? if ($is_special) { ?>
<tr><td align="left"><strong><?= wfMsg('wikiastats_wikiid')?></strong> <?= (!empty($city)) ? $city : " - " ?></td></tr>
<? } ?>
<tr><td align="left"><strong><?= wfMsg('wikiastats_wikiname') ?></strong> <?= $cityTitle ?></td></tr>
<tr><td align="left"><strong><?= wfMsg('wikiastats_wikiurl') ?></strong> <?= $cityUrl ?></td></tr>
<tr><td align="left"><strong><?= wfMsg('wikiastats_wikilang') ?></strong> <?= (!empty($langName)) ? $langName : $city_row->city_lang ?></td></tr>
<tr><td align="left"><strong><?= wfMsg('wikiastats_wikicategory') ?></strong> <?= $catName ?></td></tr>
<tr><td align="left"><strong><?= wfMsg('wikiastats_wikicreated') ?></strong> <?= (!empty($outDate)) ? $outDate : " - " ?></td></tr>
<tr><td align="left"><input type="hidden" id="ws-city-dbname" value="<?= (!empty($city_row)) ? $city_row->city_dbname : "ZZ" ?>"></td></tr>
</table>
<!-- END OF WIKI's INFORMATION -->
