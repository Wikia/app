<div class="embedHtml">
<?=$videoHtml; ?>
</div>
<? if ( !empty( $embedUrl )){ ?>
<button class="secondary" id="relatedvideos-video-player-embed-show"><?= wfMsg('lightbox-share-button-embed');?></button>
<div class="embedCode" id="relatedvideos-video-player-embed-code" style="display: none">
<label>
	<?= wfMsg('related-videos-embed-text') ?>
	<br>
	<input type="text" name="videoUrl" value="<?=$embedUrl; ?>">
</label>
</div>
<? } ?>