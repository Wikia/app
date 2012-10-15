<section id="QuickStatsWidget" class="QuickStatsWidget">
	<h1><?= wfMsg('quickstats-header-label') ?></h1>
	<table class="WikiaDataTable">
		<thead class="AdminDashboardGeneralHeader">
			<tr>
				<th><?= wfMsg('quickstats-header-date') ?></th>
				<th><div class="highlight-top"><?= wfMsg('quickstats-header-views'); ?></div></th>
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
				<td><div class="highlight-bottom"><?= QuickStatsController::shortenNumberDecorator($totals['pageviews']) ?></div></td>
				<td><?= QuickStatsController::shortenNumberDecorator($totals['edits']) ?></td>
				<td><?= QuickStatsController::shortenNumberDecorator($totals['photos']) ?></td>
				<?php if(isset($totals['likes'])) { ?>
				<td><?= QuickStatsController::shortenNumberDecorator($totals['likes']) ?></td>
				<? } ?>
			</tr>
			<tr>
				<td colspan="<?= isset($totals['likes']) ? 5 : 4 ?>" class="supplemental-info">
					<?= wfMsgExt('quickstats-see-more-stats-link', array('parseinline')) ?>
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
					<td><?= QuickStatsController::shortenNumberDecorator($row['pageviews']) ?></td>
					<td><?= QuickStatsController::shortenNumberDecorator($row['edits']) ?></td>
					<td><?= QuickStatsController::shortenNumberDecorator($row['photos']) ?></td>
					<?php if(isset($totals['likes'])) { ?>
					<td><?= QuickStatsController::shortenNumberDecorator($row['likes']) ?></td>
					<? } ?>
				</tr>
			<? } ?>
		</tbody>
	</table>
</section>
