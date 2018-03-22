<?php $counter = 0; ?>

<?php if ( !empty( $pages ) ) : ?>
<div class="side-articles top-wiki-articles RailModule">
	<h1 class="side-articles-header"><?= wfMessage( 'wikiasearch2-top-module-title' )->escaped() ?></h1>
	<?php foreach ( $pages as $page ) : ?>
		<div class="side-article result">
			<div class="side-article-thumbnail">
				<? if ( isset( $page['thumbnail'] ) ) : ?>
				<a href="<?= Sanitizer::encodeAttribute( $page['url'] ) ?>" class="top-wiki-article-image" data-pos="<?= $counter ?>">
					<img src="<?= Sanitizer::encodeAttribute( $page['thumbnail'] ) ?>" />
				</a>
				<? endif; ?>
			</div>
			<div class="side-article-text">
				<b><a href="<?= Sanitizer::encodeAttribute( $page['url'] ) ?>" class="top-wiki-article-link" data-pos="<?= $counter ?>"><?= htmlspecialchars( $page['title'] ) ?></a></b><!-- comment to remove whitespace
				--><span class="side-article-text-synopsis subtle"><?= htmlspecialchars( $page['abstract'] ) ?></span>
			</div>
		</div>

		<?php $counter++; ?>
	<?php endforeach; ?>
</div>
<?php endif; ?>
