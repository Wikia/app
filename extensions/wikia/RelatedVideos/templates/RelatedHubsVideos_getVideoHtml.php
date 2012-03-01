<div class="embedHtml">
<?php if( !empty($wikiLink ) ): ?>
<p>Visit the Wiki: <a href="<?= $wikiLink; ?>" class="wikiahubs-videos-wiki-link"><?= str_replace('/?redirect=no', '', str_replace('http://', '', $wikiLink)); ?></a></p>
<?php endif; ?>

<?= $videoHtml; ?>
</div>
<?php if( !empty($embedUrl) ): ?>
<div class="embedCode" id="relatedvideos-video-player-embed-code">
<label>
	<?= wfMsg('related-videos-embed-text') ?>
	<br>
	<input type="text" name="videoUrl" value="<?=$embedUrl; ?>">
</label>
</div>
<?php endif; ?>