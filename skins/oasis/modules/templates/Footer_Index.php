<footer id="WikiaFooter" class="WikiaFooter <?= $showToolbar ? '' : 'notoolbar' ?>">
	<?= F::app()->renderView('Ad', 'Index', array('slotname' => 'LEFT_SKYSCRAPER_3')) ?>

	<div class="FooterAd"></div>
<?php if($showToolbar) { ?>
	<div class="toolbar">
		<?php
	 		echo F::app()->renderView('Notifications', 'Index');
	 	?>
		<ul class="tools">
			<?php
				echo F::app()->renderView('Footer','Toolbar');
			?>
		</ul>
		<img src="<?= $wg->BlankImgUrl; ?>" class="banner-corner-left" height="0" width="0">
		<img src="<?= $wg->BlankImgUrl; ?>" class="banner-corner-right" height="0" width="0">
	</div>
<?php
	}
	// show notifications for anons (BugId:20730)
	else if ($showNotifications) {
		echo F::app()->renderView('Notifications', 'Index');
	}
?>
	<?= F::app()->renderView('Spotlights', 'Index', array('mode'=>'FOOTER', 'adslots'=>array( 'SPOTLIGHT_FOOTER_1', 'SPOTLIGHT_FOOTER_2', 'SPOTLIGHT_FOOTER_3' ), 'adGroupName'=>'SPOTLIGHT_FOOTER')) ?>
</footer>
