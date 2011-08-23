<footer id="WikiaFooter" class="WikiaFooter <?= $showToolbar ? '' : 'notoolbar' ?>">

	<?= wfRenderModule('Ad', 'Index', array('slotname' => 'LEFT_SKYSCRAPER_3')) ?>

	<div class="FooterAd"></div>
<?php if($showToolbar) { ?>
	<div class="toolbar">
		<?php if ($showNotifications) {
	 		echo wfRenderModule('Notifications');
	 	} ?>
		<ul class="tools">
			<?php 
				echo wfRenderModule('Footer','Toolbar');
				if ($showAdminDashboardLink) {
					echo '<li><span data-href="'. SpecialPage::getTitleFor('AdminDashboard')->getFullURL() .'" data-tracking="admindashboard/toolbar/admin">'. wfMsg('admindashboard-toolbar-link') .'</span></li>';
				} 
			?>
		</ul>
		<img src="<?= $wgBlankImgUrl; ?>" class="banner-corner-left" height="0" width="0">
		<img src="<?= $wgBlankImgUrl; ?>" class="banner-corner-right" height="0" width="0">
	</div>
<?php } ?>

	<?= wfRenderModule('Spotlights', 'Index', array('mode'=>'FOOTER', 'adslots'=>array( 'SPOTLIGHT_FOOTER_1', 'SPOTLIGHT_FOOTER_2', 'SPOTLIGHT_FOOTER_3' ), 'adGroupName'=>'SPOTLIGHT_FOOTER')) ?>

</footer>
