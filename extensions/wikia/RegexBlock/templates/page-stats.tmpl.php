<!-- s:<?= __FILE__ ?> -->
<? 
$blocker_link = $skin->makeKnownLinkObj( $titleObj, $blockInfo->blckby_blocker, 'filter=' . urlencode($blockInfo->blckby_blocker) );
$blockername_link = $skin->makeKnownLinkObj( $titleObj, $blockInfo->blckby_name, 'rfilter=' . urlencode($blockInfo->blckby_name) );
?>
<h5><?=wfMsg('regexblock_stats_title')?> <strong> <?=$blockername_link?></strong> (<?=wfMsg('regexblock_blocker_name')?>: <b><?=$blocker_link?></b>, <i><?= ($blockInfo->blckby_reason) ? wfMsg('regexblock_reason') . $blockInfo->blckby_reason : wfMsg('regexblock_generic_reason');?></i>)</h5>
<br />
<? if (!empty($stats_list)) { ?>
<p><?=$pager?></p>
<br />
<ul>
<? foreach ($stats_list as $id => $row) { ?>
<li style="border-bottom:1px dashed #778899; padding-bottom:2px;font-size:11px">
    <?=wfMsg('regexblock_match_stats_record', array($row->stats_match, $row->stats_user, htmlspecialchars($row->stats_dbname), $lang->timeanddate( wfTimestamp( TS_MW, $row->stats_timestamp ), true ), $row->stats_ip) )?>
</li>
<? } ?>
</ul>
<br />
<p><?=$pager?></p>
<? } else { ?>
<?= wfMsg('regexblock_nodata_found') ?>
<? } ?>
<!-- e:<?= __FILE__ ?> -->
