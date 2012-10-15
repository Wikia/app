<section class="WikiaHomePageStaffTool" id="WikiaHomePageStaffTool">
	<p>
		<?= wfMsg('manage-wikia-home-visualization-wikis'); ?>
		<select id="visualizationLanguagesList">
			<?php foreach($visualizationWikisData as $lang => $wiki): ?>
			<?php if( $lang === $visualizationLang ): ?>
				<option value="<?= $lang; ?>" selected="selected"><?= $wiki['url']; ?></option>
				<?php else: ?>
				<option value="<?= $lang; ?>"><?= $wiki['url']; ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
		<input type="hidden" id="visualizationLang" name="visualizationLang" value="<?= $visualizationLang ?>" />
		<input type="hidden" id="visualizationWikiId" name="visualizationWikiId" value="<?= $corpWikiId ?>" />
	</p>

	<hr />

	<h2 class="heading">
		<?= wfMsg('manage-wikia-home-wikis-in-slots-heading') ?>
	</h2>

	<?php if( !empty($errorMsg) ): ?>
	<p class="error">
		<?= $errorMsg; ?>
	</p>
	<?php endif; ?>

	<?php if( !empty($infoMsg) ): ?>
	<p class="success">
		<?= $infoMsg; ?>
	</p>
	<?php endif; ?>

	<p>
		<?= wfMsg('manage-wikia-home-wikis-in-slots-total'); ?>
		<?= $slotsInTotal; ?>
	</p>
	
	<div class="slot-forms">
		<form id="wikis-in-slots-verticals" class="wikis-in-slots" name="wikis-in-slots" method="post">
			<h3><?= wfMsg('manage-wikia-home-verticals-proportions'); ?></h3>
			<p><label for="video-games-amount"><?= wfMsg('hub-Video_Games'); ?></label><input type="text" id="video-games-amount" name="video-games-amount" value="<?= $videoGamesAmount; ?>" /></p>
			<p><label for="entertainment-amount"><?= wfMsg('hub-Entertainment'); ?></label><input type="text" id="entertainment-amount" name="entertainment-amount" value="<?= $entertainmentAmount; ?>" /></p>
			<p><label for="lifestyle-amount"><?= wfMsg('hub-Lifestyle'); ?></label><input type="text" id="lifestyle-amount" name="lifestyle-amount" value="<?= $lifestyleAmount; ?>" /></p>
			<p><input type="hidden" name="visualization-lang" value="<?= $visualizationLang; ?>"></p>
			<span class="status-msg"></span>
			<p><input type="submit" value="<?= wfMsg('manage-wikia-home-change-button'); ?>"></p>
		</form>
	</div>

	<h2 class="heading">
		<?= wfMsg('manage-wikia-home-wikis-in-visualization-heading') ?>
	</h2>

	<form id="wiki-name-filter" class="wiki-name-filter" name="wiki-name-filter" method="get">
		<p><?= wfMsg('manage-wikia-home-wiki-name-filter'); ?></p>
		<p><input type="text" id="wiki-name-filer-input" name="wiki-name-filer-input" value="" /></p>
	</form>

	<div id="wikisWithVisualizationList">
		<?= F::app()->renderView('ManageWikiaHome', 'renderWikiListPage', array(
			'page' => $currentPage,
			'visualizationLang' => $visualizationLang,
		)); ?>
	</div>
</section>