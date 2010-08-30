<footer id="WikiaFooter" class="WikiaFooter">

<?php if($showToolbar) { ?>
	<div class="toolbar">
		<?= wfRenderModule('Notifications') ?>
		<ul class="share">

<?php if($showMyTools) { ?>
			<li class="mytools">
				<img src="<?= $wgBlankImgUrl; ?>" class="mytools-icon">
				<a href="#"><?= wfMsg('oasis-mytools') ?></a>
				<?= wfRenderModule('MyTools') ?>
			</li>
<?php } ?>
<?php if($showFollow && $follow) { ?>
			<li>
				<a href="<?= $follow['href'] ?>"><img src="<?= $wgBlankImgUrl; ?>" class="follow-icon"></a>
				<a accesskey= "w" href="<?= $follow['href'] ?>" id="ca-<?= $follow['action'] ?>"><?= $follow['text'] ?></a>
			</li>
<?php } ?>
<?php if($showShare) { ?>
			<li id="ca-share_feature">
				<img src="<?= $wgBlankImgUrl; ?>" class="share-icon">
				<a href="#" id="control_share_feature"><?= wfMsg('oasis-share') ?></a>
			</li>
<?php } ?>
<?php if($showLike && false /* we do not have like feature yet available */) { ?>
			<li>
				<img src="/skins/oasis/images/icon_footer_like.png">
				<a href="#"><?= wfMsg('oasis-like') ?></a>
			</li>
<?php } ?>

		</ul>
		<img src="<?= $wgBlankImgUrl; ?>" class="banner-corner-left">
		<img src="<?= $wgBlankImgUrl; ?>" class="banner-corner-right">
	</div>
<?php } ?>

	<h1>Around Wikia's Network</h1>
	<?= wfRenderModule('RandomWiki') ?>
	<ul>
		<li class="WikiaSpotlight item-1">
			<img src="/skins/oasis/images/temp_spotlight1.jpg" width="270" height="94">
			<p>This is placeholder for Wikia Community Spotlights.</p>
		</li>
		<li class="WikiaSpotlight item-2">
			<img src="/skins/oasis/images/temp_spotlight3.jpg" width="270" height="94">
			<p>This is placeholder for Wikia Community Spotlights.</p>
		</li>
		<li class="WikiaSpotlight item-3">
			<img src="/skins/oasis/images/temp_spotlight2.jpg" width="270" height="94">
			<p>This is placeholder for Wikia Community Spotlights.</p>
		</li>
	</ul>
</footer>