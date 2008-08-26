<!-- s:<?= __FILE__ ?> -->
<?
#---
$loop = 0;
$wikia_rows = "";
foreach ($cityStats as $id => $cityId)
{
	if (!empty($cityList[$cityId]))
	{
		$loop++;

		$wikia_rows .= "<table><tr id=\"wkri-{$cityId}\">";
		$wikia_rows .= "<td class=\"wktd\" id=\"wkcn-{$cityId}\">";
		$wikia_rows .= "<a target=\"new\" href=\"".$cityList[$cityId]['url']."\">";
		$wikia_rows .= ($cityId != 0) ? ucfirst($cityList[$cityId]['dbname']): wfMsg('wikiastats_trend_all_wikia_text') ;
		$wikia_rows .= "</a></td>";
		$wikia_rows .= "<td width=\"250\" class=\"wktdr\"><a href=\"/index.php?title=Special:WikiaStats&action=citystats&city={$cityId}\">".wfMsg('wikiastats_tables')."</a>&nbsp;-&nbsp;";
		$wikia_rows .= "<a href=\"/index.php?title=Special:WikiaStats&action=citycharts&city={$cityId}\">".wfMsg('wikiastats_charts')."</a>&nbsp;-&nbsp;";
		$wikia_rows .= "<a href=\"javascript:void(0)\" onClick=\"XLSShowMenu('{$cityId}');\">".wfMsg('wikiastats_xls_files_stats')."</a></td></tr></table>";
	}
}
?>
<?=$wikia_rows?>
<!-- e:<?= __FILE__ ?> -->
