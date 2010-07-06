<div id="myhome-wrapper">
	<!-- right sidebar -->
	<div class="article-sidebar">

		<!-- additional stuff, governed by myHomeSidebarBeforeContent hook -->
		<?=$sidebarBeforeContent?>			
		<?php global $wgEnableWikiStickiesExt;
		if (!empty( $wgEnableWikiStickiesExt ) ) { ?>
			<!-- hot spots -->
			<?=$hotSpotsHTML?>
			<!-- /hot spots -->

			<!-- user contributions -->
			<?=$contribsHTML?>
			<!-- /user contributions -->
		<?php } else { ?>
			<!-- user contributions -->
			<?=$contribsHTML?>
			<!-- /user contributions -->

			<!-- hot spots -->
			<?=$hotSpotsHTML?>
			<!-- /hot spots -->
		<?php } ?>
		<!-- community corner -->
		<?=$communityCornerHTML?>
		<!-- /community corner -->

	</div>
	<!-- /right sidebar -->

	<!-- feed -->
	<div id="myhome-main">
		<h2 class="dark_text_2"><?= wfMsg("myhome-activity-feed") ?></h2>

	<!-- switch -->
	<div class="wikia-tabs">
		<ul>
		<?php global $wgBlankImgUrl; ?>
<?php if($feedSelected == 'activity') { ?>
			<li class="selected"><?=wfMsg('myhome-activity-feed')?></li>
			<li class="accent">
				<img class="sprite watch" src="<?php echo $wgBlankImgUrl; ?>">
				<a href="<?=$myhomeUrl?>/watchlist" rel="nofollow"><?=wfMsg('myhome-watchlist-feed')?></a>
			</li>
<?php } else { ?>
			<li class="accent"><a href="<?=$myhomeUrl?>/activity" rel="nofollow"><?=wfMsg('myhome-activity-feed')?></a></li>
			<li class="selected">
				<img class="sprite watch" src="<?php echo $wgBlankImgUrl; ?>">
				<?=wfMsg('myhome-watchlist-feed')?>			
			</li>
<?php } ?>
		</ul>
	</div>
	<!-- /switch -->




		<?=$feedHTML?>
	</div>
	<!-- /feed -->
</div>
