<?php $counter = 0; ?>
<?php if ( !empty( $pages ) ) : ?>
<div class="side-articles top-wiki-articles RailModule">
	<h1 class="side-articles-header"><?= wfMessage( 'wikiasearch2-top-module-title' )->plain() ?></h1>
	<?php foreach ( $pages as $page ) : ?>
		<div class="side-article result">
			<div class="side-article-thumbnail">
				<? if ( isset( $page['thumbnail'] ) ) : ?>
				<a href="<?=$page['url']?>" data-pos="<?= $counter ?>">
					<img src="<?= $page['thumbnail'] ?>" />
				</a>
				<? endif; ?>
			</div>
			<div class="side-article-text">
				<b><a href="<?= $page['url'] ?>" data-pos="<?= $counter ?>"><?= $page['title'] ?></a></b><!-- comment to remove whitespace
				--><span class="side-article-text-synopsis subtle"><?= $page['abstract'] ?></span>
			</div>
		</div>
		<?php if ( $counter++ >= 4 ) { break; } ?>
	<?php endforeach; ?>
</div>
<?php endif; ?>
