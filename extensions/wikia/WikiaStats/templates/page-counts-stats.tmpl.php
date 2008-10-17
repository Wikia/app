<!-- s:<?= __FILE__ ?> -->
<!-- PAGE EDITED COUNTS TABLE -->
<div id="ws-page-edits-table-stats">
<div id="ws-page-edits-subtitle">
	<?= wfMsg('wikiastats_page_edits_count', count($statsCount)); ?>
</div>
<br />
<?php
if (!empty($statsCount))
{
  $Kb = 1024 ;
  $Mb = $Kb * $Kb ;
  $Gb = $Kb * $Kb * $Kb ;
?>	
<input type="hidden" id="wk-page-edits-stats-page-id" value="" />
<div style="float:left; padding-bottom: 5px;">
<table cellspacing="0" cellpadding="0" border="1" id="table_page_edited_stats" style="width:auto; font-family: arial,sans-serif,helvetica; font-size:9pt;background-color:#ffffdd;">
<tr bgcolor="#ffdead">
	<td class="cb" rowspan="2">#</td>
	<td class="cb" colspan="2"><b><?= wfMsg('wikiastats_edits') ?></b></td>
	<td class="cb" colspan="2"><b><?= wfMsg('wikiastats_unique_users') ?></b></td>
	<td class="cb" rowspan="2"><b><?= wfMsg('wikiastats_articles_text') ?></b></td>
	<td class="cb" rowspan="2"><b><?= wfMsg('wikiastats_archived') ?></b></td>
	<td class="cb" rowspan="2">&nbsp;</td>
</tr>
<tr bgcolor="#ffeecc">
	<td class="cb"><?= ucfirst(wfMsg('wikiastats_total')) ?></td>
	<td class="cb"><?= wfMsg('wikiastats_register') ?></td>
	<td class="cb"><?= wfMsg('wikiastats_register') ?></td>
	<td class="cb"><?= wfMsg('wikiastats_unregister') ?></td>
</tr>
<?php
$rank = 0;
foreach ($statsCount as $cnt => $stats)
{
	$rank++;
	$reg_edits = ($stats['reg_edits']) ? sprintf("%0.0f%%", ($stats['reg_edits']/$cnt) * 100) : sprintf("%0.0f%%", $stats['reg_edits']);
    if ($stats['archived'] < $Mb) { 
    	$mbT = wfMsg('size-megabytes', 1);
    	$size = "<font color=#AAAAAA>&lt; ".$mbT."</font> &nbsp;" ; 
    } else {
		$mbT = wfMsg('size-megabytes', $wgLang->formatNum(sprintf ("%.1f", $stats['archived'] / $Mb)));
    	$size = $mbT . "&nbsp;"; 
    }
    #---
    $url = "";
    if (!empty($centralVersion)) {
		$naName = (array_key_exists($stats['namespace'], $canonicalNamespace)) ? $canonicalNamespace[$stats['namespace']] : "";
		if (in_array($stats['namespace'], array(NS_PROJECT, NS_PROJECT_TALK))) {
			$canonName = (array_key_exists($stats['namespace'], $canonicalNamespace)) ? $canonicalNamespace[$stats['namespace']] : "";
			$naName = (!empty($projectNamespace)) ? $projectNamespace : $canonName;
			if ( ($stats['namespace'] == NS_PROJECT_TALK) && (!empty($projectNamespace)) ) {
				$aC = explode("_", $canonName);
				if ( count( $aC ) > 1 ) {
					$naName = $projectNamespace."_".$aC[ count( $aC ) - 1 ];
				}
			}
		}
		$title = ($naName) ? $naName . ":" . $stats['page_title'] : $stats['page_title'];
		$url = $city_url . $_wgScript . "?title=$title";
	} else {
		$t = Title::newFromText($stats['page_title'], $stats['namespace']);
		$title = $t->getPrefixedDBKey();
		$url = $t->getFullURL();
	}
?>
<tr id="wk-page-edited-row-<?=$stats['page_id']?>">
	<td class="eb" style="white-space:nowrap;"><?= $rank ?></td>
	<td class="eb" style="white-space:nowrap;"><?= $cnt ?></td>
	<td class="eb" style="white-space:nowrap;"><?= $reg_edits ?></td>
	<td class="eb" style="white-space:nowrap;"><?= $stats['reg_users'] ?></td>
	<td class="eb" style="white-space:nowrap;"><?= $stats['unreg_users'] ?></td>
	<td class="ebl" style="white-space:nowrap;"><a href="<?= $url ?>" target="new"><?= $title ?></a></td>
	<td class="eb" style="white-space:nowrap;"><?= $size ?></td>
	<td class="ebl" style="white-space:nowrap;"><span onClick="wk_show_page_edited_details('<?=$stats['page_id']?>','<?=$otherNspaces?>');" style="cursor:pointer; padding: 2px;" id="wk-page-edited-details-<?=$stats['page_id']?>"><?= wfMsg('wikiastats_more_txt') ?></span></td>
</tr>	
<?php
}
?>
</table>
</div>
<div id="<?=($otherNspaces==0)?'wk-page-count-details-stats':'wk-othernpaces-count-details-stats'?>" style="padding-left: 10px;">
</div>
<?
}
?>
</div>
<!-- END OF PAGE EDITED COUNT TABLE -->
<!-- e:<?= __FILE__ ?> -->
