<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->
<div class="sponsorship-dashboard-description">
	<strong class="bigFont"><?= isset( $title ) ? $title : '' ?></strong>
	<?= isset( $description ) ? $description : '' ?>
</div>
<?php
if( !empty( $showActionsButton ) ){ ?>
	<div class="sponsorship-dashboard-actions">
		<?
			$dropdown = array(
				array("href" => "#", "text" => wfMsg('sponsorship-dashboard-download-chart')),
				array("href" => $path, "text" => wfMsg('sponsorship-dashboard-download-csv'))
			);
		?>
		<?= F::app()->renderView('MenuButton',
				'Index',
				array(
					'action' => array("href" => "#", "text" => wfMsg('sponsorship-dashboard-download')),
					'dropdown' => $dropdown
				)
			) ?>
	</div>
<?php } ?>
<div class="sponsorship-dashboard-panel">
	<div class="sponsorship-dashboard-panel-body">
		<div id="placeholder<?= $number ?>" class="placeholder" ></div>
	</div>
</div>
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
<div class="sponsorship-dashboard-panel-variables">
	<h3 id="show<?= $number ?>" class="sponsorship-dashboard-show"><?= wfMsg('sponsorship-dashboard-variables') ?></h3>
	<div id="choices<?= $number ?>" class="sponsorship-dashboard-choices" ><div class="sd-variable-wrapper">
		<div class="colorHolder">
			<input id="sponsorshipDashboardShowTrends" type="checkbox" value="1" />
		</div>
		<label><?= wfMsg('sponsorship-dashboard-from-checkbox-show-trends') ?></label>
	</div></div>
	<div class="sd-select-deselect-all">
		<a class="wikia-button secondary" href="#" id="sponsorship-dashboard-select<?= $number ?>"><?= wfMsg('sponsorship-dashboard-select-all') ?></a>
		<a class="wikia-button secondary" href="#" id="sponsorship-dashboard-deselect<?= $number ?>"><?= wfMsg('sponsorship-dashboard-deselect-all') ?></a>
	</div>
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
var sd = new SponsorshipDashboard();
sd.init(
<?= json_encode($jsParams) ?>
);
</script>
<div class="sponsorship-dashboard-panel-cachedate"><?= isset( $date ) ? wfMsg('sponsorship-dashboard-cachedate-label', $date) : '' ?></div>
<!-- END OF MAIN-PAGE -->
<!-- e:<?= __FILE__ ?> -->
