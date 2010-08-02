<!-- s:<?= __FILE__ ?> -->
<!-- WIKIANS ABSENT TABLE -->
<div id="ws-wikians-absent-table-stats<?=$anons?>">
<?php if (!empty($wkAbsent)) { ?>	
<div id="ws-wikians-title<?=$anons?>">
	<?= wfMsgExt( 'wikistats_recently_absent_wikians', 'parsemag', count( $wkAbsent ) ); ?>
</div>
<div class="ws-main-table">
<table cellspacing="0" cellpadding="0" border="1" class="TablePager">
<thead>
<tr>
	<th><b><?= wfMsg('wikistats_username') ?></b></th>
	<th colspan="2"><b><?= wfMsg('wikistats_edits') ?></b></th>
	<th colspan="2"><b><?= wfMsg('wikistats_first_edit') ?></b></th>
	<th colspan="2"><b><?= wfMsg('wikistats_last_edit') ?></b></th>
</tr>
<tr>
	<th>&nbsp;</th>
	<th><?= wfMsg('wikistats_rank') ?></th>
	<th><?= wfMsg('wikistats_total') ?></th>
	<th><?= wfMsg('wikistats_date') ?></th>
	<th><?= wfMsg('wikistats_days_ago') ?></th>
	<th><?= wfMsg('wikistats_date') ?></th>
	<th><?= wfMsg('wikistats_days_ago') ?></th>
</tr>
</thead>
<tbody>
<?php foreach ($wkAbsent as $rank => $data) {
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
	<td style="white-space:nowrap;"><?= $data['total'] ?></td>
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
</div>
<?
}
?>
</div>
<!-- END OF WIKIANS ABSENT TABLE -->
<!-- e:<?= __FILE__ ?> -->
