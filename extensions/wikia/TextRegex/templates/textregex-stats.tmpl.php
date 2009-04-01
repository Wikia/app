<!-- s:<?= __FILE__ ?> -->
<style>
.trs_list {
	border-bottom:1px dashed #778899; 
	padding-bottom:2px;
	font-size:12px;
}
</style>
<h5><?=wfMsgExt( 'textregex-phrase-statistics', 'parse', $regexInfo->tr_text, $numStatResults )?></h5>
<? if (!empty($stats_list)) { ?>
<p><?=$pager?></p>
<ul>
<? foreach ($stats_list as $id => $row) { 
	$oUser = User::newFromId($row['user']); 
?>	
<li class="trs_list">
    <?=wfMsgExt('textregex-stats-record', 'parse', htmlspecialchars($row['text']), $oUser->getName(), $row['timestamp'], $row['comment'] )?>
</li>
<? } ?>
</ul>
<p><?=$pager?></p>
<? } else { ?>
<?= wfMsg('textregex-nodata-found') ?>
<? } ?>
<!-- e:<?= __FILE__ ?> -->
