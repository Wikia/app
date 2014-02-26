<?= $app->renderView(
	'EditHub',
	'Header'
) ?>

<div class="EditHub WikiaGrid">
	<div class="grid-2 data">
		<img class="chevron border" src="<?= $wg->BlankImgUrl; ?>">
		<img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
		<div class="ml15">
			<h2><?= wfMessage('edit-hub-date-title')->escaped(); ?></h2>
			<div id="date-picker"><?=wfMessage('edit-hub-tooltip-calendar-placeholder')->escaped()?></div>
		</div>
	</div>
</div>


<div class="ui-widget ui-datepicker datepicker-example">
	<table class="ui-datepicker-calendar">
		<tr>
			<td class="ui-datepicker-current-day-legend">
				<a>&nbsp;&nbsp;</a>
				<?= wfMessage('edit-hub-tooltip-current-date')->escaped(); ?>
			</td>
			<td class="published">
				<a>&nbsp;&nbsp;</a>
				<?= wfMessage('edit-hub-tooltip-published')->escaped(); ?>
			</td>
			<td class="inProg">
				<a>&nbsp;&nbsp;</a>
				<?= wfMessage('edit-hub-tooltip-in-progress')->escaped(); ?>
			</td>
		</tr>
	</table>
</div>
