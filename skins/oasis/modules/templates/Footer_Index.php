<footer id="WikiaFooter" class="WikiaFooter <?= $showToolbar ? '' : 'notoolbar' ?>">
	<?= F::app()->renderView('Ad', 'Index', ['slotName' => 'BOTTOM_LEADERBOARD', 'pageTypes' => ['homepage_logged', 'corporate', 'search', 'all_ads'], 'addToAdQueue' => false]); ?>
	<?php if( $showToolbar ): ?>
		<div class="toolbar">
			<?= F::app()->renderView('Notifications', 'Index'); ?>
			<ul class="tools">
				<?= F::app()->renderView('Footer','Toolbar'); ?>
			</ul>
			<img src="<?= $wg->BlankImgUrl; ?>" class="banner-corner-left" height="0" width="0">
			<img src="<?= $wg->BlankImgUrl; ?>" class="banner-corner-right" height="0" width="0">
		</div>
	<?php elseif( $showNotifications ) : // show notifications for anons (BugId:20730) ?>
		<?= F::app()->renderView('Notifications', 'Index'); ?>
	<?php endif; ?>

	<? if ( $wg->EnableOpenXSPC ) : ?>
		<?= F::app()->renderView('Spotlights', 'Index'); ?>
	<? endif; ?>
</footer>
