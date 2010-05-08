<!-- s:<?php print __FILE__; ?> -->
<?php
$blocker_link = $skin->makeKnownLinkObj( $titleObj, $blockInfo->blckby_blocker, 'filter=' . urlencode($blockInfo->blckby_blocker) );
$blockername_link = $skin->makeKnownLinkObj( $titleObj, $blockInfo->blckby_name, 'rfilter=' . urlencode($blockInfo->blckby_name) );
?>
<h5><?php print wfMsg('regexblock_stats_title'); ?> <strong> <?php print $blockername_link; ?></strong></h5>
<ul>
<li><?php print wfMsg('regexblock_blocker_name'); ?>: <b><?php print $blocker_link ?></b></li>
<li><?php print wfMsg('regexblock_reason'); ?> <?php print ($blockInfo->blckby_reason) ?  ('<b>' . $blockInfo->blckby_reason . '</b>') : ('<i>' . wfMsg('regexblock_generic_reason') . '</i>' ); ?></li>
<li>Type: <?php print (($blockInfo->blckby_exact) ? wfMsg('regexblock_exact_match') : wfMsg('regexblock_regex_match')) ?></li>
<li><?php print wfMsg('regexblock_block_date_from')?>: <b><?php print $lang->timeanddate( wfTimestamp( TS_MW, $blockInfo->blckby_timestamp ), true )?></b></li>
<li><?php print wfMsg('regexblock_block_date_to')?>: <?php print ($blockInfo->blckby_expire != 'infinite') ?  ('<b>' . $lang->timeanddate( wfTimestamp( TS_MW, $blockInfo->blckby_expire ), true ) . '</b>') : ('<i>infinite</i>'); ?></li>
</ul>
<?php
print "<a href=\"" . $titleObj->getFullURL( array('action'=>'delete', 'blckid'=>'6428') ) . "\">".wfMsg('regexblock_unblock')."</a><br/>\n";
?>
<br />
<?php if (!empty($stats_list)) { ?>
<p><?php print $pager?></p>
<br />
<ul id="regexblock_triggers">
<?php foreach ($stats_list as $id => $row) { ?>
<li><?php
print wfMsg('regexblock_match_stats_record', array($row->stats_match, $row->stats_user, htmlspecialchars($row->stats_dbname), $lang->timeanddate( wfTimestamp( TS_MW, $row->stats_timestamp ), true ), $row->stats_ip) );
?></li>
<?php } ?>
</ul>
<br />
<p><?php print $pager?></p>
<?php } else { ?>
<?php print wfMsg('regexblock_nodata_found') ?>
<?php } ?>
<!-- e:<?php print __FILE__; ?> -->
