<?= $app->renderView(
	'VideoPageAdminSpecial',
	'Header'
) ?>

<div id="VPTDashboard" class="WikiaGrid">
	<div class="grid-2">
		<h2><?= wfMessage('videopagetool-language-title'); ?></h2>
		<select id="VideoPageToolRegionSelect" data-default-language="<?= Sanitizer::encodeAttribute( $language ); ?>">
			<option value="placeholder">
				<?= wfMessage( 'videopagetool-language-select-default-value' )->escaped(); ?>
			</option>
			<? asort( $languages ); ?>
			<? foreach ( $languages as $langCode => $langName ): ?>
				<option
					value="<?= $langCode ?>"
					<? if ( $language == $langCode ): ?>selected="selected"<? endif ?>
					>
					<?= $langName ?>
				</option>
			<? endforeach ?>
		</select>
	</div>
	<div class="grid-2 data">
		<img class="chevron border" src="<?= $wg->BlankImgUrl; ?>">
		<img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
		<div class="ml15">
			<h2><?= wfMessage( 'videopagetool-date-title' )->escaped(); ?></h2>
			<div class="date-picker">
				<?= wfMessage( 'videopagetool-tooltip-calendar-placeholder' )->escaped(); ?>
			</div>
		</div>
	</div>
</div>

<div class="ui-widget ui-datepicker datepicker-example">
	<table class="ui-datepicker-calendar">
		<tr>
			<td class="ui-datepicker-current-day-legend">
				<a>&nbsp;&nbsp;</a>
				<?= wfMessage( 'videopagetool-tooltip-current-date' )->escaped(); ?>
			</td>
			<td class="published">
				<a>&nbsp;&nbsp;</a>
				<?= wfMessage( 'videopagetool-tooltip-published' )->escaped(); ?>
			</td>
			<td class="in-prog">
				<a>&nbsp;&nbsp;</a>
				<?= wfMessage( 'videopagetool-tooltip-in-progress' )->escaped(); ?>
			</td>
		</tr>
	</table>
</div>
