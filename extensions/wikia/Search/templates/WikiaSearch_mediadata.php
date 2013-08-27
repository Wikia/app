<h3><a href="#"><?= wfMessage( 'wikiasearch2-video-results', $query ) ?></a></h3>
<ul class="carousel">
	<?php foreach ( $mediaData['items'] as $fileDatum ): ?>
	<li>
		<a href="<?=$fileDatum['mediaDetail']['fileUrl'] ?>"><img src="<?=$fileDatum['mediaDetail']['imageUrl'] ?>" alt="<?=$fileDatum['title'] ?>" /></a>
		<a href="<?=$fileDatum['mediaDetail']['fileUrl'] ?>"><?=$fileDatum['title']?></a>
	</li>
	<? endforeach; ?>
</ul>


						