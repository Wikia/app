<?php
	if ( !empty( $wg->EnableMonetizationModuleExt ) && !empty( $monetizationModules[MonetizationModuleHelper::SLOT_TYPE_ABOVE_TITLE] ) ) {
		echo $monetizationModules[MonetizationModuleHelper::SLOT_TYPE_ABOVE_TITLE];
	}

	if ( ( !empty( $wg->EnableNjordExt ) && WikiaPageType::isMainPage() ) ) {
		// edit button with actions dropdown
		if (!empty($action)) {
			echo F::app()->renderView('MenuButton', 'Index', array('action' => $action, 'image' => $actionImage, 'dropdown' => $dropdown, 'name' => $actionName));
		}
	} else {
?>
		<header id="WikiaPageHeader" class="WikiaPageHeader wikia-page-header">
			<div class="header-container">
				<div class="header-column header-title">
					<h1><?= !empty($displaytitle) ? $title : htmlspecialchars($title) ?></h1>
					<?php if (!empty($pageSubtitle)): ?>
						<h2><?= $pageSubtitle ?></h2>
					<? endif; if (!empty($subtitle)): ?>
						<div class="subtitle"><?= $subtitle ?></div>
					<? endif; ?>
				</div>
				<div class="header-column header-tally">
					<?php if ( !empty( $wg->EnablePageShareExt ) && ( !empty( $wg->EnablePageShareWorldwide ) || ($wg->Lang->getCode() == 'en'))) {
						echo F::app()->renderView('PageShare', 'index');
					} ?>
					<? if (!is_null($tallyMsg)): ?>
						<div class="tally"><?= $tallyMsg ?></div>
					<? endif; ?>
				</div>
			</div>
		<?php
		// edit button with actions dropdown
		if (!empty($action)) {
			echo F::app()->renderView('MenuButton', 'Index', array('action' => $action, 'image' => $actionImage, 'dropdown' => $dropdown, 'name' => $actionName));
		}

		// TODO: use PageHeaderIndexExtraButtons hook for these buttons
		// "Add a photo" button
		if (!empty($isNewFiles) && !empty($wg->EnableUploads)) {
			echo Wikia::specialPageLink('Upload', 'oasis-add-photo', 'wikia-button upphotos', 'blank.gif', 'oasis-add-photo-to-wiki', 'sprite photo');
		}

		// "Add a video" button
		if (!empty($isSpecialVideos) && !empty($wg->EnableUploads) && $showAddVideoBtn): ?>
			<a class="button addVideo" href="#" rel="tooltip" title="<?= wfMsg('related-videos-tooltip-add'); ?>">
				<img src="<?= wfBlankImgUrl(); ?>" class="sprite addRelatedVideo"/> <?= wfMsg('videos-add-video') ?>
			</a>
		<? endif;

		// comments & like button
		if (!$isWallEnabled) {
			echo F::app()->renderView('CommentsLikes', 'Index', array('comments' => $comments));
		}

		foreach ($extraButtons as $button) {
			echo $button;
		}
		?>
	</header>
	<?php
	if (!empty($wg->EnableMonetizationModuleExt) && !empty($monetizationModules[MonetizationModuleHelper::SLOT_TYPE_BELOW_TITLE])) {
		echo $monetizationModules[MonetizationModuleHelper::SLOT_TYPE_BELOW_TITLE];
	}
}
?>
