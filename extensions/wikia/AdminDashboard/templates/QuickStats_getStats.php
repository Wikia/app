<section id="QuickStatsWidget" class="QuickStatsWidget admin-dashboard-module">
	<h1><?= wfMsg('quickstats-header-label') ?></h1>
	<table class="WikiaDataTable">
		<thead class="AdminDashboardGeneralHeader">
			<tr>
				<th><?= wfMessage( 'quickstats-header-date' )->escaped() ?></th>
				<th><div class="highlight-top"><?= wfMessage( 'quickstats-header-views' )->escaped(); ?></div></th>
				<th><?= wfMessage( 'quickstats-header-edits' )->escaped() ?></th>
				<th><?= wfMessage( 'quickstats-header-photos' )->escaped() ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr class="totals">
				<td>
					<div class="pointer">
						<?= wfMessage( 'quickstats-totals-label' )->escaped() ?>
					</div>
				</td>
				<td><div class="highlight-bottom"><?= $wg->Lang->shortenNumberDecorator($totals['pageviews']) ?></div></td>
				<td><?= $wg->Lang->shortenNumberDecorator($totals['edits']) ?></td>
				<td><?= $wg->Lang->shortenNumberDecorator($totals['photos']) ?></td>
			</tr>
			<tr>
				<td colspan="4" class="supplemental-info">
					<?= wfMessage( 'quickstats-see-more-stats-link' )->parse() ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?
				foreach ($stats as $date => $row) {
					$dateObject = new DateTime($date);
					$formattedDate = $dateObject->format( wfMessage( 'quickstats-date-format' )->escaped() );  ?>
				<tr>
					<td><?= $formattedDate ?></td>
					<td><?= $wg->Lang->shortenNumberDecorator($row['pageviews']) ?></td>
					<td><?= $wg->Lang->shortenNumberDecorator($row['edits']) ?></td>
					<td><?= $wg->Lang->shortenNumberDecorator($row['photos']) ?></td>
				</tr>
			<? } ?>
		</tbody>
	</table>
</section>
