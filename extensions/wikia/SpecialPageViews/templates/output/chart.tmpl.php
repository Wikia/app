<!-- s:<?= __FILE__ ?> -->
<!-- MAIN-PAGE -->
<div class="special-pageviews-beta-info">
	<strong><?= wfMessage( 'special-pageviews-beta-info' )->escaped() ?></strong>
</div>
<div class="sponsorship-dashboard-description">
	<strong class="bigFont"><?= isset( $title ) ? $title : '' ?></strong>
	<?= isset( $description ) ? $description : '' ?>
</div>
<?php
if( isset( $showActionsButton ) ){ ?>
	<div class="sponsorship-dashboard-actions">
		<?php
		$dropdown = [
			[
				"href" => "#",
				"text" => wfMessage( 'sponsorship-dashboard-download-chart' )->escaped(),
				"id" => 'sponsorshipDashboardDownloadChartPNG',
			],
			[
				"href" => "#",
				"text" => wfMessage( 'sponsorship-dashboard-download-csv' )->escaped(),
				"id" => 'sponsorshipDashboardDownloadChartCSV',
			]
		];
		?>
		<?=
		F::app()->renderView( 'MenuButton',
			'Index',
			[
				'action' => [ "href" => "#", "text" => wfMessage( 'sponsorship-dashboard-download' )->escaped() ],
				'dropdown' => $dropdown
			] );
		?>
	</div>
<?php } ?>
<div class="sponsorship-dashboard-panel">
	<div class="sponsorship-dashboard-panel-body">
		<div id="placeholder<?= $number ?>" class="placeholder" ></div>
	</div>
</div>
<div class="sponsorship-dashboard-panel-header">
	<div class="datepicker left">
		<div id="overviewLabel<?= $number ?>" class="overviewLabel"><?= wfMessage( 'sponsorship-dashboard-from-label' )->escaped() ?></div>
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
		<p>
			<a href="#" class="submitDatePickers"><?= wfMessage( 'special-pageviews-redraw-link-text' )->escaped() ?></a>
		</p>
	</div>
	<div class="datepicker">
		<div id="overviewLabel<?= $number ?>" class="overviewLabel"><?= wfMessage( 'sponsorship-dashboard-to-label' )->escaped() ?></div>
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
		<div id="overviewLabel<?= $number ?>" class="overviewLabel"><?= wfMessage( 'sponsorship-dashboard-overview-label' )->escaped() ?></div>
		<div id="overview<?= $number ?>" class="overview"></div>
	</div>
</div>
<div class="sponsorship-dashboard-panel-variables">
	<h3 id="show<?= $number ?>" class="sponsorship-dashboard-show"><?= wfMessage( 'sponsorship-dashboard-variables' )->escaped() ?></h3>
	<div id="choices<?= $number ?>" class="sponsorship-dashboard-choices" ><div class="sd-variable-wrapper">
			<div class="colorHolder">
				<input id="sponsorshipDashboardShowTrends" type="checkbox" value="1" />
			</div>
			<label><?= wfMessage( 'sponsorship-dashboard-from-checkbox-show-trends' )->escaped() ?></label>
		</div></div>
	<div class="sd-select-deselect-all">
		<a class="wikia-button secondary" href="#" id="sponsorship-dashboard-select<?= $number ?>"><?= wfMessage('sponsorship-dashboard-select-all')->escaped() ?></a>
		<a class="wikia-button secondary" href="#" id="sponsorship-dashboard-deselect<?= $number ?>"><?= wfMessage('sponsorship-dashboard-deselect-all')->escaped() ?></a>
	</div>
</div>
<div class="sponsorship-dashboard-panel-cachedate"><?= isset( $date ) ? wfMessage( 'sponsorship-dashboard-cachedate-label', $date )->escaped() : '' ?></div>
<!-- END OF MAIN-PAGE -->
<!-- e:<?= __FILE__ ?> -->
