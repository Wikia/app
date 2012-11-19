<div class="marketingToolbox WikiaGrid">
	<div class="grid-2">
		<h2><?= wfMsg('marketing-toolbox-region-title'); ?></h2>
		<select id="marketingToolboxRegionSelect">
			<option><?= wfMsg('marketing-toolbox-region-select-default-value'); ?></option>
		</select>
	</div>
	<div class="grid-1">
		<img class="chevron border" src="<?= $wg->BlankImgUrl; ?>">
		<img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
		<div class="ml15">
			<h2><?= wfMsg('marketing-toolbox-section-title'); ?></h2>
			<input class="big" type="button" value="<?= wfMsg('marketing-toolbox-section-hubs-button'); ?>" />
			<input class="big" type="button" value="<?= wfMsg('marketing-toolbox-section-bar-button'); ?>" />
			<input class="big secondary"  type="button" value="<?= wfMsg('marketing-toolbox-section-homepage-button'); ?>" />
		</div>
	</div>
	<div class="grid-1">
		<img class="chevron border" src="<?= $wg->BlankImgUrl; ?>">
		<img class="chevron" src="<?= $wg->BlankImgUrl; ?>">
		<div class="ml15">
			<h2><?= wfMsg('marketing-toolbox-vertical-title'); ?></h2>
			<input class="big" type="button" value="<?= wfMsg('marketing-toolbox-section-games-button'); ?>" />
			<input class="big secondary"  type="button" value="<?= wfMsg('marketing-toolbox-section-entertainment-button'); ?>" />
			<input class="big secondary" type="button" value="<?= wfMsg('marketing-toolbox-section-lifestyle-button'); ?>" />
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