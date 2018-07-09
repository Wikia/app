<? if ( isset($mediaData['items']) && sizeof($mediaData['items']) != 0 ): ?>
	<h1><a href="<?= $mediaData['videoUrl'] ?>" class="video-addon-seach-video"><?= wfMessage( 'wikiasearch2-video-results', $query )->escaped(); ?></a></h1>
	<ul>
		<? foreach ( $mediaData['items'] as $fileDatum ): ?>
			<li><?= $fileDatum["thumbnail"] ?></li>
		<? endforeach; ?>
	</ul>
<? endif; ?>
