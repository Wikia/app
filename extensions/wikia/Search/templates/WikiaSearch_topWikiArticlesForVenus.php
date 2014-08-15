<?php if ( !empty( $pages ) ) : ?>
<?php $counter = 0; ?>
<ul class="top-wiki-articles">
	<h1><?= wfMessage( 'wikiasearch2-top-module-test-1' )->plain() ?></h1>
	<?php foreach ( $pages as $page ) : ?>
	<li class="top-wiki-articles-item">
		<?php if ( isset( $page[ 'thumbnail' ] ) ) : ?>
		<a href="<?= $page[ 'url' ] ?>" data-pos="<?= $counter ?>">
			<img src="<?= $page[ 'thumbnail' ] ?>" class="thumbnail-<?= empty( $page[ 'thumbnailSize' ] ) ? 'small' : $page[ 'thumbnailSize' ] ?>" />
		</a>
		<?php endif; ?>
		<p class="top-wiki-articles-snippet">
			<a href="<?= $page[ 'url' ] ?>" data-pos="<?= $counter ?>"><?= $page[ 'title' ] ?></a>
			<?= $page[ 'abstract' ] ?>
		</p>
	</li>
	<?php if ( $counter++ >= 6 ) { break; } ?>
	<?php endforeach; ?>
</ul>
<?php endif; ?>
