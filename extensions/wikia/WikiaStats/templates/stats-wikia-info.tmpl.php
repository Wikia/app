<?php
$outDate = "";
$created = (is_object($cityInfo)) ? $cityInfo->city_created : null;
if (!empty($created) && ($created != "0000-00-00 00:00:00")) {
	$dateTime = explode(" ", $created);
	#---
	$dateArr = explode("-", $dateTime[0]);
	#---
	$stamp = mktime(0,0,0,$dateArr[1],$dateArr[2],$dateArr[0]);
	$outDate = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . $dateArr[2] .", ". $dateArr[0]. " ".$dateTime[1];
}
$langName = (is_object($cityInfo)) ? $wgContLang->getLanguageName( $cityInfo->city_lang ) : " - ";
$catName = (is_object($cityInfo) && !empty($cats) && array_key_exists($cityId, $cats)) ? $cats[$cityId]['name'] : " - ";
$cityTitle = (is_object($cityInfo) && $cityId > 0) ? ucfirst($cityInfo->city_title) : (($cityId == 0) ? wfMsg("wikiastats_trend_all_wikia_text") : " - ");
$cityUrl = (is_object($cityInfo) && $cityId > 0) ? "<a target=\"new\" href=\"".$cityInfo->city_url."\">".$cityInfo->city_url."</a>" : " - ";
?>
<!-- s:<?= __FILE__ ?> -->
<!-- WIKI's INFORMATION -->
<fieldset style="width:auto; margin:-9px 2px 10px 0px">
<legend><?=wfMsg("wikiastats_wikia_information")?></legend>
<table cellspacing="1" cellpadding="2" border="0" style="font-size:8.5pt;font-family:Trebuchet MS,arial,sans-serif,helvetica;padding-bottom:1px;">
<tr>
	<td align="left" valign="top" width="40%"><strong><?= wfMsg('wikiastats_wikiid')?></strong> <?= (!empty($cityId)) ? $cityId : " - " ?></td>
	<td align="left" valign="top" width="60%" style="padding-left:10px;" nowrap><strong><?= wfMsg('wikiastats_wikiname') ?></strong> <?= $cityTitle ?></td>
</tr>
<tr>
	<td align="left" valign="top"><strong><?= wfMsg('wikiastats_wikilang') ?></strong> <?= (!empty($langName)) ? $langName : $cityInfo->city_lang ?></td>
	<td align="left" valign="top" style="padding-left:10px;"><strong><?= wfMsg('wikiastats_wikiurl') ?></strong> <?= $cityUrl ?></td></tr>
</tr>
<tr>
	<td align="left" valign="top" nowrap><strong><?= wfMsg('wikiastats_wikicategory') ?></strong> <?= $catName ?></td>
	<td align="left" valign="top" style="padding-left:10px;"><strong><?= wfMsg('wikiastats_wikicreated') ?></strong> <?= (!empty($outDate)) ? $outDate : " - " ?></td>
</tr>
<tr>
	<td align="left" valign="top" nowrap><strong><?= wfMsg('wikiastats_code_version') ?></strong> <a href="<?=Title::newFromText("Version", NS_SPECIAL)->getLocalURL();?>">Special:Version</a></td>
	<td align="left" valign="top" style="padding-left:10px;"><strong><?= wfMsg('wikiastats_mediawiki_stats') ?></strong> <a href="<?=Title::newFromText("Statistics", NS_SPECIAL)->getLocalURL();?>">Special:Statistics</a></td>
</tr>
</table>
</fieldset>
<div style="padding-bottom:5px;">
<table cellspacing="0" cellpadding="1" border="0" style="font-size:8.5pt;font-family: Trebuchet MS,arial,sans-serif,helvetica;">
<tr>
	<td align="left" colspan="2"><strong><?= wfMsg('wikiastats_see_wikia_wide_stats') ?></strong> <a href="http://www.wikia.com/wiki/Special:WikiaStats" target="new">http://www.wikia.com/wiki/Special:WikiaStats</a> </td>
</tr>
<tr>
	<td align="left" colspan="2"><strong><?= wfMsg('wikiastats_see_help_page') ?></strong> <a href="http://help.wikia.com/wiki/Help:WikiaStats" target="new">http://help.wikia.com/wiki/Help:WikiaStats</a> </td>
</tr>
</table>
</div>
