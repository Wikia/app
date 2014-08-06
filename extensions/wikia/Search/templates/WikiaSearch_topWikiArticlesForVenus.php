<?php if ( !empty( $pages ) ) : ?>
<?php $counter = 0; ?>
<section class="top-wiki-articles small-5 medium-4 large-4 push-1 columns">
	<h1><?= wfMessage( 'wikiasearch2-top-module-test-1' )->plain() ?></h1>
	<?php foreach ( $pages as $page ) : ?>
	<?php if ( !empty( $page[ 'thumbnailSize' ] ) && $page[ 'thumbnailSize' ] === 'large' ): ?>

	<div>
		<? if ( isset( $page[ 'thumbnail' ] ) ) : ?>
		<a href="<?=$page[ 'url' ]?>" data-pos="<?= $counter ?>">
			<img src="<?= $page[ 'thumbnail' ] ?>" />
		</a>
		<? endif; ?>

		<div><a href="<?= $page[ 'url' ] ?>" data-pos="<?= $counter ?>"><?= $page[ 'title' ] ?></a></div>
		<div><?= $page[ 'abstract' ] ?></div>
	</div>

	<?php else: ?>
	<div>
		<? if ( isset( $page[ 'thumbnail' ] ) ) : ?>
		<a href="<?=$page[ 'url' ]?>" data-pos="<?= $counter ?>">
			<img src="<?= $page[ 'thumbnail' ] ?>" class="thumbnail-small" />
		</a>
		<? endif; ?>

		<div>
			<div><a href="<?= $page[ 'url' ] ?>" data-pos="<?= $counter ?>"><?= $page[ 'title' ] ?></a></div>
			<div><?= $page[ 'abstract' ] ?></div>
		</div>
	</div>

	<?php endif; ?>
	<?php if ( $counter++ >= 6 ) { break; } ?>
	<?php endforeach; ?>
</section>
<?php endif; ?>
