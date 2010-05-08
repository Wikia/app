<div id="lightbox-image" title="<?= htmlspecialchars($name) ?>" style="text-align: center">
	<img alt="" height="<?= $height ?>" width="<?= $width ?>" src="<?= $wgBlankImgUrl ?>" style="background: 50% 50% no-repeat url('<?= $thumbUrl ?>')" />
	<div id="lightbox-caption" class="neutral clearfix" style="padding: 5px">
		<a id="lightbox-link" href="<?= htmlspecialchars($href) ?>" title="<?= wfMsg('lightbox_details_tooltip') ?>" style="float: right"><img class="sprite details" width="16" height="16" src="<?= $wgBlankImgUrl ?>" alt="" /></a>
		<div id="lightbox-caption-content" style="margin-right: 25px; text-align: left"></div>
	</div>
</div>
