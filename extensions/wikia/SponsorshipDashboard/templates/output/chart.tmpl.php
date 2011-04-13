<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->
<div class="description">
	<b><?= isset( $title ) ? $title : '' ?></b>
	<?= isset( $description ) ? $description : '' ?>
</div>

<div class="sponsorship-dashboard-panel left">
	<h3 id="show<?= $number ?>" class="sponsorship-dashboard-show"><?= wfMsg('sponsorship-dashboard-variables') ?></h3>
	<p id="choices<?= $number ?>" class="sponsorship-dashboard-choices"></p>
	<div>
		<a class="wikia-button secondary" href="#" id="sponsorship-dashboard-select<?= $number ?>">select all</a>
		<a class="wikia-button secondary" href="#" id="sponsorship-dashboard-deselect<?= $number ?>">deselect all</a>
	</div>
	<h3><?= wfMsg('sponsorship-dashboard-other-options') ?></h3>
	<label><input id="sponsorshipDashboardShowTrends" type="checkbox" value="1"><?= wfMsg('sponsorship-dashboard-from-checkbox-show-trends') ?></label><br>
	<a href="#" id="sponsorshipDashboardDownloadChart"><?= wfMsg('sponsorship-dashboard-download-chart') ?></a><br />
	<a href="<?=$path ?>" id="sponsorshipDashboardDownloadCSV"><?= wfMsg('sponsorship-dashboard-download-csv') ?></a>
</div>
<div class="sponsorship-dashboard-panel right">
	<div class="sponsorship-dashboard-panel-header">
		<div class="datepicker left">
			<div id="overviewLabel<?= $number ?>" class="overviewLabel"><?= wfMsg('sponsorship-dashboard-from-label') ?></div>
			<select id="sd-year-from" class="sd-datepicker">
				<?
					$currentYear = date('Y');
					for ( $i = $fromYear; $i <= $currentYear; $i++ ) {
						echo '<option value="' . $i . '"';
						if ( ( $currentYear - 1 ) == $i ) {echo ' selected="selected" ';}
						echo '>' . $i . '</option>';
					}
				?>
			</select>-<select id="sd-month-from" class="sd-datepicker">
				<?
					$currentMonth = date('m');
					for ( $i = 1; $i <= 12; $i++ ) {
						echo '<option value="';
						if ( $i < 10 ) {echo '0';}
						echo $i . '"';
						if ( $currentMonth == $i ) {echo ' selected="selected" ';}
						echo '>' . $i . '</option>';
					}
				?>
			</select><? if ( empty( $monthly ) ) { ?>-<select id="sd-day-from" class="sd-datepicker">
				<?
					$currentDay = date('d');
					for ( $i = 1; $i <= 31; $i++ ) {
						echo '<option value="';
						if ( $i < 10 ) {echo '0';};
						echo $i.'"';
						if ( $currentDay == $i ) {echo ' selected="selected" ';}
						echo '>' . $i . '</option>';
					}
				?>
			</select>
			<? } ?>
		</div>
		<div class="datepicker">
			<div id="overviewLabel<?= $number ?>" class="overviewLabel"><?= wfMsg('sponsorship-dashboard-to-label') ?></div>
			<select id="sd-year-to" class="sd-datepicker">
				<?
					for ( $i = $fromYear; $i <= $currentYear; $i++ ) {
						echo '<option value="' . $i . '"';
						if ( $currentYear == $i ) {echo ' selected="selected" ';}
						echo '>' . $i . '</option>';
					}
				?>
			</select>-<select id="sd-month-to" class="sd-datepicker">
				<?
					for ( $i = 1; $i <= 12; $i++ ) {
						echo '<option value="';
						if ( $i < 10 ) {echo '0';}
						echo $i . '"';
						if ( $currentMonth == $i ) {echo ' selected="selected" ';}
						echo '>' . $i . '</option>';
					}
				?>
			</select><? if ( empty( $monthly ) ) { ?>-<select id="sd-day-to" class="sd-datepicker">
				<?
					for ( $i = 1; $i <= 31; $i++ ) {
						echo '<option value="';
						if ( $i < 10 ) {echo '0';}
						echo $i . '"';
						if ( $currentDay == $i ) {echo ' selected="selected" ';}
						echo '>' . $i . '</option>';
					}
				?>
			</select>
			<? } ?>
		</div>
		<div id="overviewWrapper<?= $number ?>" class="overviewWrapper" >
			<div id="overviewLabel<?= $number ?>" class="overviewLabel"><?= wfMsg('sponsorship-dashboard-overview-label') ?></div>
			<div id="overview<?= $number ?>" class="overview" ></div>
		</div>

	</div>
	<div class="sponsorship-dashboard-panel-body">
		<div id="placeholder<?= $number ?>" class="placeholder" ></div>
	</div>
	<div class="sponsorship-dashboard-panel-cachedate"><?= isset( $date ) ? wfMsg('sponsorship-dashboard-cachedate-label', $date) : '' ?></div>
</div>
<!-- TODO: no excanvas.pack.js !! -->
<!--[if IE]><script language="javascript" type="text/javascript" src="excanvas.pack.js"></script><![endif]-->
<? global $wgExtensionsPath ?>
<script language="javascript" type="text/javascript" src="<?= $wgExtensionsPath ?>/wikia/SponsorshipDashboard/js/SponsorshipDashboardChart.js">
</script>
<?
$jsParams = array(
	'chartId' => $number,
	'datasets' => $datasets,
	'fullTicks' => $fullTicks,
	'hiddenSeries' => $hiddenSeries,
	'monthly' => $monthly,
	'ticks' => $ticks
);
?>
<script id="source<?= $number ?>" language="javascript" type="text/javascript">
SponsorshipDashboard.init(
<?= Wikia::json_encode($jsParams) ?>
);
</script>
<!-- END OF MAIN-PAGE -->
<!-- e:<?= __FILE__ ?> -->