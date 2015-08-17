<?php
if ( !empty( $wg->EnableMonetizationModuleExt ) ) {
	if ( !empty( $wg->AdDriverUseMonetizationService ) ) {
		echo $app->renderView( 'Ad', 'Index', ['slotName' => 'MON_ABOVE_TITLE'] );
	} else if ( !empty( $monetizationModules[MonetizationModuleHelper::SLOT_TYPE_ABOVE_TITLE] ) ) {
		echo $monetizationModules[MonetizationModuleHelper::SLOT_TYPE_ABOVE_TITLE];
	}
}

$runNjord = ( !empty( $wg->EnableNjordExt ) && WikiaPageType::isMainPage() );
if ( $runNjord ) {
	// edit button with actions dropdown
	if ( !empty( $action ) ) {
		echo F::app()->renderView( 'MenuButton', 'Index', array( 'action' => $action, 'image' => $actionImage, 'dropdown' => $dropdown, 'name' => $actionName ) );
	}
} else {
	?>
	<!-- @TODO CONCF-189 everything inside this if should be removed when social buttons are live -->
	<? if ( empty( $wg->EnablePageShareExt ) ): ?>
		<header id="WikiaPageHeader" class="WikiaPageHeader">
			<h1><?= !empty( $displaytitle ) ? $title : htmlspecialchars( $title ) ?></h1>

			<?php
			// edit button with actions dropdown
			if ( !empty( $action ) ) {
				echo F::app()->renderView( 'MenuButton', 'Index', array( 'action' => $action, 'image' => $actionImage, 'dropdown' => $dropdown, 'name' => $actionName ) );
			}

			// TODO: use PageHeaderIndexExtraButtons hook for these buttons

			// "Add a photo" button
			if ( !empty( $isNewFiles ) && !empty( $wg->EnableUploads ) ) {
				echo Wikia::specialPageLink( 'Upload', 'oasis-add-photo', 'wikia-button upphotos', 'blank.gif', 'oasis-add-photo-to-wiki', 'sprite photo' );
			}

			// "Add a video" button
			if ( !empty( $isSpecialVideos ) && !empty( $wg->EnableUploads ) && $showAddVideoBtn ): ?>
				<a class="button addVideo" href="#" rel="tooltip"
				   title="<?= wfMsg( 'related-videos-tooltip-add' ); ?>"><img src="<?= wfBlankImgUrl(); ?>"
																			  class="sprite addRelatedVideo"/> <?= wfMsg( 'videos-add-video' ) ?>
				</a>
			<? endif;

			// comments & like button
			if (!$isWallEnabled) {
				echo F::app()->renderView('CommentsLikes', 'Index', array('comments' => $comments));
			}
			foreach ($extraButtons as $button) {
				echo $button;
			}

			// "pages on this wiki" counter
			if (!is_null($tallyMsg)) {
				?>
				<div class="tally">
					<?= $tallyMsg ?>
				</div>
			<?php
			}

			// render page type line
			if ( !empty( $pageSubtitle ) ) {
				?>
				<h2><?= $pageSubtitle ?></h2>
			<?php
			}

			// MW subtitle
			// include undelete message (BugId:1137)
			if ( !empty( $subtitle ) ) {
				?>
				<div class="subtitle"><?= $subtitle ?></div>
			<?php
			}
			?>
		</header>
	<? else: ?>
		<header id="WikiaPageHeader" class="WikiaPageHeader wikia-page-header">
			<div class="header-container">
				<div class="header-column header-title">
					<h1><?= !empty( $displaytitle ) ? $title : htmlspecialchars( $title ) ?></h1>
					<?php if ( !empty( $pageSubtitle ) ): ?>
						<h2><?= $pageSubtitle ?></h2>
					<? endif;
					if ( !empty( $subtitle ) ): ?>
						<div class="subtitle"><?= $subtitle ?></div>
					<? endif; ?>
				</div>
				<div class="header-column header-tally">
					<? if ( !empty( $wg->EnablePageShareExt ) ): ?>
						<div id="PageShareContainer" class="page-share-container">
							<?php echo F::app()->renderView( 'PageShare', 'Index' ); ?>
						</div>
					<? endif; ?>
					<? if ( !is_null( $tallyMsg ) ): ?>
						<div class="tally"><?= $tallyMsg ?></div>
					<? endif; ?>
				</div>
			</div>
			<?php
			// edit button with actions dropdown
			if ( !empty( $action ) ) {
				echo F::app()->renderView( 'MenuButton', 'Index', array( 'action' => $action, 'image' => $actionImage, 'dropdown' => $dropdown, 'name' => $actionName ) );
			}

			// TODO: use PageHeaderIndexExtraButtons hook for these buttons
			// "Add a photo" button
			if ( !empty( $isNewFiles ) && !empty( $wg->EnableUploads ) ) {
				echo Wikia::specialPageLink( 'Upload', 'oasis-add-photo', 'wikia-button upphotos', 'blank.gif', 'oasis-add-photo-to-wiki', 'sprite photo' );
			}

			// "Add a video" button
			if ( !empty( $isSpecialVideos ) && !empty( $wg->EnableUploads ) && $showAddVideoBtn ): ?>
				<a class="button addVideo" href="#" rel="tooltip" title="<?= wfMsg( 'related-videos-tooltip-add' ); ?>">
					<img src="<?= wfBlankImgUrl(); ?>" class="sprite addRelatedVideo"/> <?= wfMsg( 'videos-add-video' ) ?>
				</a>
			<? endif;

			// comments & like button
			if ( !$isWallEnabled ) {
				echo F::app()->renderView( 'CommentsLikes', 'Index', array( 'comments' => $comments ) );
			}

			foreach ( $extraButtons as $button ) {
				echo $button;
			}
			?>
	</header>
	<? endif; ?>
	<?php
	if ( !empty( $wg->EnableMonetizationModuleExt ) ) {
		if ( !empty( $wg->AdDriverUseMonetizationService ) ) {
			echo $app->renderView( 'Ad', 'Index', ['slotName' => 'MON_BELOW_TITLE'] );
		} else if ( !empty( $monetizationModules[MonetizationModuleHelper::SLOT_TYPE_BELOW_TITLE] ) ) {
			echo $monetizationModules[MonetizationModuleHelper::SLOT_TYPE_BELOW_TITLE];
		}
	}
}
?>
