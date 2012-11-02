<footer id="WikiaFooter" class="WikiaFooter <? echo $showToolbar ? '' : 'notoolbar'; echo (empty
($wgEnableWikiaBarExt)) ? ' notifications-with-wikia-bar' : ''; ?>">
	<?= F::app()->renderView('Ad', 'Index', array('slotname' => 'LEFT_SKYSCRAPER_3')) ?>

	<div class="FooterAd"></div>
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
	<?= F::app()->renderView('Spotlights', 'Index', array('mode'=>'FOOTER', 'adslots'=>array( 'SPOTLIGHT_FOOTER_1', 'SPOTLIGHT_FOOTER_2', 'SPOTLIGHT_FOOTER_3' ), 'adGroupName'=>'SPOTLIGHT_FOOTER')) ?>
</footer>
