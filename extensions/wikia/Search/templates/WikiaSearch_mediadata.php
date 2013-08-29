<h3><a href="#"><?= wfMessage( 'wikiasearch2-video-results', $query ) ?></a></h3>
<ul>
	<?php foreach ( $mediaData['items'] as $fileDatum ): ?><li><?= $fileDatum["thumbnail"] ?></li><? endforeach; ?>
</ul>


