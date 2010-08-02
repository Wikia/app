<!-- s:<?= __FILE__ ?> -->
<!-- WIKIANS ACTIVE TABLE -->
<div id="ws-wikians-active-table-stats<?=$anons?>" class="ws-main-table">
<?php if (!empty($wkActive)) { ?>	
<br />
<div id="ws-wikians-title<?=$anons?>">
	<?= wfMsgExt( 'wikistats_recently_active_wikians', 'parsemag', count( $wkActive ) ); ?>
	<br />
	<span class="small"><?= wfMsg('wikistats_active_wikians_subtitle_info') ?></span>
</div>
<table cellspacing="0" cellpadding="0" border="1" class="TablePager">
<thead>
<tr>
	<th rowspan="2"><b><?= wfMsg('wikistats_username') ?></b></th>
	<th colspan="6"><b><?= wfMsg('wikistats_edits') ?></b></th>
	<th rowspan="2" colspan="2"><b><?= wfMsg('wikistats_first_edit') ?></b></th>
	<th rowspan="2" colspan="2"><b><?= wfMsg('wikistats_last_edit') ?></b></th>
</tr>
<tr>
	<th colspan="4"><b><?= wfMsg('wikistats_articles_text') ?></b></th>
	<th colspan="2"><b><?= wfMsg('wikistats_other') ?></b></th>
</tr>
<tr>
	<th rowspan="2">&nbsp;</th>
	<th colspan="2"><?= wfMsg('wikistats_rank') ?></th>
	<th rowspan="2"><?= wfMsg('wikistats_month_ago', $cur_month, ($cur_month == 1) ? wfMsg('wikistats_active_month') : wfMsg('wikistats_active_months')) ?></th>
	<th rowspan="2"><?= wfMsg('wikistats_total') ?></th>
	<th rowspan="2"><?= wfMsg('wikistats_total') ?></th>
	<th rowspan="2"><?= wfMsg('wikistats_month_ago', $cur_month, ($cur_month == 1) ? wfMsg('wikistats_active_month') : wfMsg('wikistats_active_months')) ?></th>
	<th rowspan="2"><?= wfMsg('wikistats_date') ?></th>
	<th rowspan="2"><?= wfMsg('wikistats_days_ago') ?></th>
	<th rowspan="2"><?= wfMsg('wikistats_date') ?></th>
	<th rowspan="2"><?= wfMsg('wikistats_days_ago') ?></th>
</tr>
<tr>
	<th><?= wfMsg('wikistats_now') ?></th>
	<th><?= wfMsg('wikistats_prev_rank') ?></th>
</tr>
</thead>
<tbody>
<?php foreach ($wkActive as $rank => $data) {
	$rank_change = $data['rank_change'];
	if ($data['rank_change'] < 0) {
		$rank_change = "<font color=\"#800000\">".$rank_change."</font>";
	} elseif ($data['rank_change'] > 0) {
		$rank_change = "<font color=\"#008000\">+".$rank_change."</font>";
	} elseif ($data['rank_change'] == 0) {
		$rank_change = "...";
	}
	#---
	$outFirstEdit = $wgLang->sprintfDate($oStats->dateFormat(1), wfTimestamp(TS_MW, $data['first_edit']));
	#---
	$outLastEdit = $wgLang->sprintfDate($oStats->dateFormat(1), wfTimestamp(TS_MW, $data['last_edit']));
	
	$user_id = intval($data['user_id']);
	if ( !empty($user_id) ) {
		$oUser = User::newFromId($data['user_id']);
		$user_name = $oUser->getName();
		$user_url = sprintf("%s%s", trim($city_url), Title::makeTitle(NS_USER, $user_name)->getLocalURL());
		$user_url = "<a href=\"". $user_url . "\" target=\"new\">$user_name</a>";
	} else {
		$user_url = "<div style=\"font-weight:bold\">".$data['user_ip'] . "</div><div class=\"small\">( " . $data['user_host'] . " )</div> ";
	}
?>
<tr>
	<td style="white-space:nowrap;text-align:left;"><?= $user_url ?></td>
	<td style="white-space:nowrap;"><?= $rank ?></td>
	<td style="white-space:nowrap;"><?= $rank_change ?></td>
	<td style="white-space:nowrap;"><?= $data['edits_last'] ?></td>
	<td style="white-space:nowrap;"><?= $data['total'] ?></td>
	<td style="white-space:nowrap;"><?= $data['total_other'] ?></td>
	<td style="white-space:nowrap;"><?= $data['edits_other_last'] ?></td>
	<td style="white-space:nowrap;"><?= $outFirstEdit ?></td>
	<td style="white-space:nowrap;"><?= $data['first_edit_ago'] ?></td>
	<td style="white-space:nowrap;"><?= $outLastEdit ?></td>
	<td style="white-space:nowrap;"><?= $data['last_edit_ago'] ?></td>
</tr>	
<?php
}
?>
</tbody>
</table>
<?
}
?>
</div>
<br />
<!-- END OF WIKIANS ACTIVE TABLE -->
<!-- e:<?= __FILE__ ?> -->
