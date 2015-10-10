<?php if ( !empty( $wg->EnableMonetizationModuleExt ) ) {
	if ( !empty( $wg->AdDriverUseMonetizationService ) ) {
		echo $app->renderView( 'Ad', 'Index', [ 'slotName' => 'MON_ABOVE_TITLE' ] );
	} elseif ( !empty( $monModules[MonetizationModuleHelper::SLOT_TYPE_ABOVE_TITLE] ) ) {
		echo $monModules[MonetizationModuleHelper::SLOT_TYPE_ABOVE_TITLE];
	}
}

if ( $runNjord ) {
	// edit button with actions dropdown
	if ( !empty( $button['action'] ) ) {
		echo $app->renderView(
			'MenuButton',
			'Index',
			$button
		);
	}

	echo $curatedContentToolButton;
} else { ?>
	<header id="pageHeader" class="page-header index">
		<div class="header-column header-left">
			<h1><?= $title ?></h1>
			<?php if ( !empty( $button['action'] ) ) {
				echo $app->renderView(
					'MenuButton',
					'Index',
					$button
				);
			}

			echo $curatedContentToolButton;

			// comments & like button
			if ( !$isWallEnabled ) {
				echo $app->renderView(
					'CommentsLikes',
					'Index',
					[ 'comments' => $comments ]
				);
			}

			foreach ( $extraButtons as $button ) {
				echo $button;
			}

			if ( !empty( $pageSubtitle ) ) { ?>
				<h2 class="breadcrumbs"><?= $pageSubtitle ?></h2>
			<?php }

			if ( !empty( $subtitle ) ) { ?>
				<div class="subtitle"><?= $subtitle ?></div>
			<?php } ?>
		</div>
		<div class="header-column header-right">
			<?php
			// don't show share buttons on Special:Videos as we want the tally instead
			if ( !empty( $wg->EnablePageShareExt && !$isSpecialVideos ) ) { ?>
				<div id="pageShareContainer" class="page-share-container">
					<?= $app->renderView( 'PageShare', 'Index' ); ?>
				</div>
			<?php }

			if ( $isSpecialVideos && !is_null( $tallyMsg ) ) { ?>
				<div class="tally"><?= $tallyMsg ?></div>
			<?php } ?>
		</div>
	</header>
	<?php if ( !empty( $wg->EnableMonetizationModuleExt ) ) {
		if ( !empty( $wg->AdDriverUseMonetizationService ) ) {
			echo $app->renderView( 'Ad', 'Index', [ 'slotName' => 'MON_BELOW_TITLE' ] );
		} elseif ( !empty( $monModules[MonetizationModuleHelper::SLOT_TYPE_BELOW_TITLE] ) ) {
			echo $monModules[MonetizationModuleHelper::SLOT_TYPE_BELOW_TITLE];
		}
	}
}
