<!-- s:<?= __FILE__ ?> -->
<style type="text/css">/*<![CDATA[*/
#entry-list div.entry { margin-top: 20px; padding-top: 10px; padding-left: 5px; padding-right: 5px;  display: block; clear: both; overflow: auto; border: 1px solid #DCDCDC;}
#entry-list label { display: block; width: 12em !important; float: left; padding-right: 1em; text-align: right;font-weight: bold; }
#entry-list div.entry-graph { margin-top: 20px; margin-bottom: 0; text-align: center;}
#entry-desc { background: #f4f4f4; }
#entry-controls { float: right; }
/*]]>*/</style>

<?php $entriesCount = count($entries); ?>
<a href="<?=$title->getFullUrl('action=edit');?>"><b>[add new entry]</b></a>
<div id="entry-list">
	<?php if($entriesCount): ?>
		<table border="1" cellspacing="0" cellpadding="6" valign="top">
			<tr bgcolor="#eeeeee">
				<th>Date</th>
			<?php foreach($entries as $entry): ?>
				<th><a href="<?=$title->getFullUrl('action=list&entryId=' . $entry->getId());?>"><?=$entry->getPhrase();?></a></th>
			<?php endforeach; ?>
			</tr>
			<?php foreach($resultDates as $date): ?>
			<tr>
				<td><strong><?=date('M d, Y', strtotime($date));?></strong></td>
				<?php foreach($entries as $entry): ?>
					<? $rank = $entry->getRankResultByDate($date); ?>
					<td align="center"><?=($rank == null) ? "-" : $rank; ?></td>
				<?php endforeach; ?>
			</tr>
			<?php endforeach; ?>
		</table>
	<?php else: ?>
		<br />
		<br />
		<i><?=wfMsg('searchranktracker-empty-list'); ?>
	<?php endif; // count($entries) ?>
</div>
<!-- e:<?= __FILE__ ?> -->