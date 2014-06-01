<section class="WikiaHomePageStaffTool" id="WikiaHomePageStaffTool">
	<p>
		<?= wfMessage('manage-wikia-home-visualization-wikis')->text(); ?>
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

	<div class="slots-setup">
		<h2 class="heading">
			<?= wfMessage('manage-wikia-home-wikis-in-slots-heading')->text() ?>
		</h2>

		<p>
			<?= wfMessage('manage-wikia-home-wikis-in-slots-total')->numParams([$slotsInTotal])->text(); ?>
		</p>

		<div class="slot-forms">
			<form id="wikis-in-slots-verticals" class="wikis-in-slots" name="wikis-in-slots" method="post">
				<h3><?= wfMessage('manage-wikia-home-verticals-proportions')->text(); ?></h3>
				<p><label for="video-games-amount"><?= wfMessage('hub-Video_Games')->text(); ?></label><input type="text" id="video-games-amount" name="video-games-amount" value="<?= $videoGamesAmount; ?>" /></p>
				<p><label for="entertainment-amount"><?= wfMessage('hub-Entertainment')->text(); ?></label><input type="text" id="entertainment-amount" name="entertainment-amount" value="<?= $entertainmentAmount; ?>" /></p>
				<p><label for="lifestyle-amount"><?= wfMessage('hub-Lifestyle')->text(); ?></label><input type="text" id="lifestyle-amount" name="lifestyle-amount" value="<?= $lifestyleAmount; ?>" /></p>
				<p><input type="hidden" name="visualization-lang" value="<?= $visualizationLang; ?>"></p>
				<span class="status-msg"></span>
				<p><input type="submit" name="wikis-in-slots" value="<?= wfMessage('manage-wikia-home-change-button')->text(); ?>"></p>
			</form>
		</div>
	</div>

	<div class="collections-setup">
		<h2 class="heading">
			<?= wfMessage('manage-wikia-home-collections-setup-header')->text() ?>
		</h2>
		
		<form method="post" class="WikiaForm" id="collectionsSetupForm">
			<? for($i=0; $i < WikiaCollectionsModel::COLLECTIONS_COUNT; $i++): ?>

				<?php
					$enabled = isset($form->getField('enabled')['value'][$i]) ? $form->getField('enabled')['value'][$i] : false;
					$collectionId = isset($form->getField('id')['value'][$i]) ? $form->getField('id')['value'][$i] : 0;
					$wikisCounter = isset($wikisPerCollection[$collectionId]) ? $wikisPerCollection[$collectionId] : 0;
				?>
				
				<div class="collection-module" data-collection-id="<?= $collectionId; ?>">
					<?php if( $enabled && $wikisCounter != WikiaHomePageHelper::SLOTS_IN_TOTAL ): ?>
						<div class="input-group">
							<p class="error"><?= wfMessage('manage-wikia-home-collections-invalid-wikis-number')->numParams([WikiaHomePageHelper::SLOTS_IN_TOTAL])->text(); ?></p>
						</div>
					<?php endif; ?>
					
					<?=$form->renderField('enabled', $i)?>
					<?=$form->renderField('id', $i)?>
					<?=$form->renderField('name', $i)?>
					
					<div class="image-input-container">
						<?=$form->renderField('sponsor_hero_image', $i)?>
						<input type="button" class="wmu-show" value="<?= wfMessage('manage-wikia-home-collection-add-file-button')->text() ?>" />
					</div>
					<p class="alternative">
						<?= wfMessage('manage-wikia-home-collection-hero-image-tooltip')->numParams(SpecialManageWikiaHomeModel::HERO_IMAGE_WIDTH, SpecialManageWikiaHomeModel::HERO_IMAGE_HEIGHT)->text() ?>
					</p>

					<div class="image-input-container">
						<?=$form->renderField('sponsor_image', $i)?>
						<input type="button" class="wmu-show" value="<?= wfMessage('manage-wikia-home-collection-add-file-button')->text() ?>" />
					</div>
					<p class="alternative">
						<?= wfMessage('manage-wikia-home-collection-sponsor-image-tooltip')->numParams(SpecialManageWikiaHomeModel::SPONSOR_IMAGE_WIDTH, SpecialManageWikiaHomeModel::SPONSOR_IMAGE_HEIGHT)->text() ?>
					</p>
					<?=$form->renderField('sponsor_url', $i)?>

					<div class="input-group collection-wikis-counter">
						<p><?= wfMessage('manage-wikia-home-collections-wikis-in-collection')->numParams( [$wikisCounter, WikiaHomePageHelper::SLOTS_IN_TOTAL])->text(); ?></p>
					</div>
				</div>
			<? endfor ?>

			<input type="submit" name="collections" value="<?= wfMessage('manage-wikia-home-collections-setup-save-button')->text(); ?>" />
		</form>
	</div>

	<div class="wikis-setup">
		<h2 class="heading">
			<?= wfMessage('manage-wikia-home-wikis-in-visualization-heading')->text() ?>
		</h2>

		<form id="wiki-name-filter" class="wiki-name-filter" name="wiki-name-filter" method="get">
			<p class="wiki-filter-group">
				<input type="hidden" name="vl" value="<?= $visualizationLang ?>" />
                <label><?= wfMessage('manage-wikia-home-wiki-list-headline')->text() ?></label>
				<input type="text" id="wiki-name-filer-input" name="wiki-name-filer-input" value="<?= $filterOptions['wiki-name-filer-input'] ?>" />
				<label for="collections-filter"><?= wfMessage('manage-wikia-home-wiki-list-collection')->text() ?></label>
				<select id="collections-filter" name="collections-filter">
					<option value="0"><?= wfMessage('manage-wikia-home-wiki-list-all-collections')->text() ?></option>
					<? foreach ($collectionsList as $collection): ?>
						<option value="<?= $collection['id'] ?>" <? if ($filterOptions['collections-filter'] == $collection['id']): ?>selected="selected"<? endif ?>><?= $collection['name'] ?></option>
					<? endforeach ?>
				</select>
				<label for="vertical-filter"><?= wfMessage('manage-wikia-home-wiki-list-vertical')->text() ?></label>
				<select id="vertical-filter" name="vertical-filter">
					<option value="0"><?= wfMessage('manage-wikia-home-wiki-list-all-verticals')->text() ?></option>
					<? foreach ($verticals as $id => $vertical): ?>
						<option value="<?= $id ?>" <? if ($filterOptions['vertical-filter'] == $id): ?>selected="selected"<? endif ?>><?= $vertical ?></option>
					<? endforeach ?>
				</select>
				<label for="wiki-blocked-filter"><input id="wiki-blocked-filter" type="checkbox" name="wiki-blocked-filter" value="1" <? if ($filterOptions['wiki-blocked-filter']): ?>checked="checked"<? endif ?>/> <?= wfMessage('manage-wikia-home-wiki-list-blocked')->text() ?></label>
				<label for="wiki-promoted-filter"><input id="wiki-promoted-filter" type="checkbox" name="wiki-promoted-filter" value="1" <? if ($filterOptions['wiki-promoted-filter']): ?>checked="checked"<? endif ?>/>  <?= wfMessage('manage-wikia-home-wiki-list-promoted')->text() ?></label>
				<label for="wiki-official-filter"><input id="wiki-official-filter" type="checkbox" name="wiki-official-filter" value="1" <? if ($filterOptions['wiki-official-filter']): ?>checked="checked"<? endif ?>/> <?= wfMessage('manage-wikia-home-wiki-list-official')->text() ?></label>
				<input id="wiki-filter-reset" type="reset" value="<?= wfMessage('manage-wikia-home-wiki-filter-reset')->text() ?>"/>
				<input type="submit" name="wikis-filter" value="<?= wfMessage('manage-wikia-home-wiki-filter')->text() ?>" />
			</p>
		</form>

		<div id="wikisWithVisualizationList">
			<?= $app->renderView('ManageWikiaHome', 'renderWikiListPage', array(
				'page' => $currentPage,
				'visualizationLang' => $visualizationLang,
				'filterOptions' => $filterOptions
			)); ?>
		</div>
	</div>
</section>