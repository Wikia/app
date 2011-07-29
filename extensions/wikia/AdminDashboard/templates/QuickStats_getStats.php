<?
	function shortenNumberDecorator($number) {
		$number = intval($number);
		$d = $number / 1000;
		if ($d >= 10) {
			return round($d, 1).'K';
		} else {
			return $number;
		}
	}
?>
<section id="QuickStatsWidget" class="QuickStatsWidget">
	<h1><?= wfMsg('quickstats-header-label') ?></h1>
	<table class="WikiaDataTable">
		<thead class="AdminDashboardGeneralHeader">
			<tr>
				<th><?= wfMsg('quickstats-header-date') ?></th>
				<th><?= wfMsg('quickstats-header-views') ?></th>
				<th><?= wfMsg('quickstats-header-edits') ?></th>
				<th><?= wfMsg('quickstats-header-photos') ?></th>
				<?php if(isset($totals['likes'])) { ?>
				<th><?= wfMsg('quickstats-header-likes') ?></th>
				<? } ?>
			</tr>
		</thead>
		<tfoot>
			<tr class="totals">
				<td>
					<div class="pointer">
						<?= wfMsg('quickstats-totals-label') ?>
					</div>
				</td>
				<td><?= shortenNumberDecorator($totals['pageviews']) ?></td>
				<td><?= shortenNumberDecorator($totals['edits']) ?></td>
				<td><?= shortenNumberDecorator($totals['photos']) ?></td>
				<?php if(isset($totals['likes'])) { ?>
				<td><?= shortenNumberDecorator($totals['likes']) ?></td>
				<? } ?>
			</tr>
			<tr>
				<td colspan="<?= isset($totals['likes']) ? 5 : 4 ?>" class="supplemental-info">
					<?= wfMsgExt('quickstats-see-more-stats-link', 'parseinline') ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<? 
  				foreach ($stats as $date => $row) { 
					$dateObject = new DateTime($date);
					$formattedDate = $dateObject->format(wfMsg('quickstats-date-format'));  ?>
				<tr>
					<td><?= $formattedDate ?></td>
					<td><?= shortenNumberDecorator($row['pageviews']) ?></td>
					<td><?= shortenNumberDecorator($row['edits']) ?></td>
					<td><?= shortenNumberDecorator($row['photos']) ?></td>
					<?php if(isset($totals['likes'])) { ?>
					<td><?= shortenNumberDecorator($row['likes']) ?></td>
					<? } ?>
				</tr>
			<? } ?>
		</tbody>
	</table>
</section>
