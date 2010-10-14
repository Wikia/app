<div id="lightbox-image" title="<?= htmlspecialchars($name) ?>" style="text-align: center">
	<div style="line-height: <?= $wrapperHeight ?>px">
		<img alt="<?= htmlspecialchars($name) ?>" height="<?= $thumbHeight ?>" width="<?= $thumbWidth ?>" src="<?= $thumbUrl ?>" style="vertical-align: middle" />
	</div>
	<div id="lightbox-caption" class="neutral clearfix" style="line-height: 24px; padding: 8px">
		<a id="lightbox-link" href="<?= htmlspecialchars($href) ?>" title="<?= wfMsg('lightbox_details_tooltip') ?>" style="float: right"><img class="sprite details" width="16" height="16" src="<?= $wgBlankImgUrl ?>" alt="" /></a>
		<div id="lightbox-caption-content" style="margin-right: 25px; text-align: left"></div>
	</div>
</div>
