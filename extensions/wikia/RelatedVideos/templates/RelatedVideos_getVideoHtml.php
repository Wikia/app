<?=$videoHtml; ?>
<? if ( !empty( $embedUrl )){ ?>
<div class="embedCode" id="relatedvideos-video-player-embed-code">
<label>
	<?= wfMsg('related-video-embed-text') ?>
	<br>
	<input type="text" name="videoUrl" value="<?=$embedUrl; ?>">
</label>
</div>
<? } ?>