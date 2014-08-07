<?php if ( !empty( $pages ) ) : ?>
<?php $counter = 0; ?>
<section class="top-wiki-articles">
	<h1><?= wfMessage( 'wikiasearch2-top-module-test-1' )->plain() ?></h1>
	<?php foreach ( $pages as $page ) : ?>
	<div class="top-wiki-articles-item">
		<?php if ( isset( $page[ 'thumbnail' ] ) ) : ?>
		<a href="<?= $page[ 'url' ] ?>" data-pos="<?= $counter ?>">
			<img src="<?= $page[ 'thumbnail' ] ?>" class="thumbnail-<?= empty( $page[ 'thumbnailSize' ] ) ? 'small' : $page[ 'thumbnailSize' ] ?>" />
		</a>
		<?php endif; ?>
		<div class="top-wiki-articles-snippet">
			<a href="<?= $page[ 'url' ] ?>" data-pos="<?= $counter ?>"><?= $page[ 'title' ] ?></a>
			<?= $page[ 'abstract' ] ?>
		</div>
	</div>
	<?php if ( $counter++ >= 6 ) { break; } ?>
	<?php endforeach; ?>
</section>
<?php endif; ?>
