<div class="marketingToolbox WikiaGrid">
	<div class="grid-2">
		<h2><?= wfMsg('marketing-toolbox-region-title'); ?></h2>
		<select id="marketingToolboxRegionSelect">
			<option><?= wfMsg('marketing-toolbox-region-select-default-value'); ?></option>
			<? asort($corporateWikisLanguages); ?>
			<? foreach ($corporateWikisLanguages as $corporateWikiId => $corporateWikiLanguage): ?>
				<option value="<?=$corporateWikiId?>"><?=$corporateWikiLanguage?></option>
			<? endforeach ?>
		</select>
	</div>
	<div class="grid-1">
		<img class="chevron border" src="<?= $wg->BlankImgUrl; ?>">
		<img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
		<div class="ml15">
			<h2><?= wfMsg('marketing-toolbox-section-title'); ?></h2>
			<? foreach ($sections as $sectionId => $section): ?>
				<input class="big" type="button" value="<?=$section?>" />
			<? endforeach ?>
		</div>
	</div>
	<div class="grid-1">
		<img class="chevron border" src="<?= $wg->BlankImgUrl; ?>">
		<img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
		<div class="ml15">
			<h2><?= wfMsg('marketing-toolbox-vertical-title'); ?></h2>

			<? foreach ($verticals as $verticalId => $vertical): ?>
				<input class="big secondary" type="button" value="<?=$vertical?>" />
			<? endforeach ?>
		</div>
	</div>
	<div class="grid-2">
		<img class="chevron border" src="<?= $wg->BlankImgUrl; ?>">
		<img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
		<div class="ml15">
			<h2><?= wfMsg('marketing-toolbox-date-title'); ?></h2>
			<div id="date-picker"></div>
		</div>
	</div>
</div>


<div class="ui-datepicker-inline ui-datepicker datepicker-example">
	<table class="ui-datepicker-calendar">
		<tr>
			<td class="ui-datepicker-current-day">
				<a>&nbsp;&nbsp;</a>
				<?= wfMsg('marketing-toolbox-tooltip-current-date'); ?>
			</td>
			<td class="published">
				<a>&nbsp;&nbsp;</a>
				<?= wfMsg('marketing-toolbox-tooltip-published'); ?>
			</td>
			<td class="inProg">
				<a>&nbsp;&nbsp;</a>
				<?= wfMsg('marketing-toolbox-tooltip-in-progress'); ?>
			</td>
		</tr>
	</table>
</div>