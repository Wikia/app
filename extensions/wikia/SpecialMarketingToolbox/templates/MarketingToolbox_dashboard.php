<?= $app->renderView(
	'MarketingToolbox',
	'Header'
) ?>

<div class="marketingToolbox WikiaGrid">
	<div class="grid-2">
		<h2><?= wfMsg('marketing-toolbox-region-title'); ?></h2>
		<select id="marketingToolboxRegionSelect">
			<option class="placeholder-option"><?= wfMsg('marketing-toolbox-region-select-default-value'); ?></option>
			<? asort($corporateWikisLanguages); ?>
			<? foreach ($corporateWikisLanguages as $corporateWikiId => $corporateWikiLanguage): ?>
				<option
					value="<?=$corporateWikiId?>"
					<? if ($selectedLanguage == $corporateWikiId): ?>selected="selected"<? endif ?>
				>
					<?=$corporateWikiLanguage?>
				</option>
			<? endforeach ?>
		</select>
	</div>
	<div class="grid-1 section">
		<img class="chevron border" src="<?= $wg->BlankImgUrl; ?>">
		<img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
		<div class="ml15">
			<h2><?= wfMsg('marketing-toolbox-section-title'); ?></h2>
			<? foreach ($sections as $sectionId => $section): ?>
				<input
					class="big <? if (!isset($selectedLanguage)): ?>secondary<? endif ?>"
					<? if (!isset($selectedLanguage)): ?>disabled="disabled"<? endif ?>
					type="button"
					value="<?=$section?>"
					data-section-id="<?=$sectionId;?>"
				/>
			<? endforeach ?>
		</div>
	</div>
	<div class="grid-1 vertical">
		<img class="chevron border" src="<?= $wg->BlankImgUrl; ?>">
		<img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
		<div class="ml15">
			<h2><?= wfMsg('marketing-toolbox-vertical-title'); ?></h2>

			<? foreach ($verticals as $verticalId => $vertical): ?>
				<input
					class="big<? if ($selectedVertical != $verticalId): ?> secondary<? endif ?>"
					<? if (!isset($selectedLanguage)): ?>disabled="disabled"<? endif ?>
					type="button" value="<?=$vertical?>"
					data-vertical-id="<?=$verticalId;?>"
				/>
			<? endforeach ?>
		</div>
	</div>
	<div class="grid-2 data">
		<img class="chevron border" src="<?= $wg->BlankImgUrl; ?>">
		<img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
		<div class="ml15">
			<h2><?= wfMsg('marketing-toolbox-date-title'); ?></h2>
			<div id="date-picker"><?=wfMsg('marketing-toolbox-tooltip-calendar-placeholder')?></div>
		</div>
	</div>
</div>


<div class="ui-widget ui-datepicker datepicker-example">
	<table class="ui-datepicker-calendar">
		<tr>
			<td class="ui-datepicker-current-day-legend">
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