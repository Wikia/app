<div id="myhome-wrapper">

	<!-- switch -->
	<div id="myhome-feed-switch">
<?php if($feedSelected == 'activity') { ?>
		<span class="selected"><?=wfMsg('myhome-activity-feed')?></span> | <a href="<?=$myhomeUrl?>/watchlist" rel="nofollow"><?=wfMsg('myhome-watchlist-feed')?></a>
<?php } else { ?>
		<a href="<?=$myhomeUrl?>/activity" rel="nofollow"><?=wfMsg('myhome-activity-feed')?></a> | <span class="selected"><?=wfMsg('myhome-watchlist-feed')?></span>
<?php } ?>
	</div>
	<!-- /switch -->

	<!-- right sidebar -->
	<div id="myhome-sidebar">

		<!-- user contributions -->
		<?=$contribsHTML?>
		<!-- /user contributions -->

		<!-- hot spots -->
		<?=$hotSpotsHTML?>
		<!-- /hot spots -->

		<!-- community corner -->
		<?=$communityCornerHTML?>
		<!-- /community corner -->

	</div>
	<!-- /right sidebar -->

	<!-- feed -->
	<?=$feedHTML?>
	<!-- /feed -->
</div>
