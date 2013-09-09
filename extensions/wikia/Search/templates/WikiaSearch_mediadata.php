<?php if ( isset($mediaData['videoUrl']) && sizeof($mediaData['videoUrl']) != 0 ): ?>
	<h3><a href="<?= $mediaData['videoUrl'] ?>" class="video-addon-seach-video"><?= wfMessage( 'wikiasearch2-video-results', $query ) ?></a></h3>
	<ul>
		<?php foreach ( $mediaData['items'] as $fileDatum ): ?><li><?= $fileDatum["thumbnail"] ?></li><? endforeach; ?>
	</ul>
<?php endif ?>
