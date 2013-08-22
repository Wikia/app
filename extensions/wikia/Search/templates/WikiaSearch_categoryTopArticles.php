<li class="result">
	<article>
		<h1>
		<?php
			$trackingData = 'class="result-link" data-pos="'.$pos.'"' . ( $result->getVar('isArticleMatch') ? ' data-event="search_click_match"' : '' );
		?>

		<a href="<?= $result->getUrl(); ?>" <?=$trackingData;?> ><?= $result->getTitle() ?></a>
	</h1>
	<? if ($redirectTitle = $result->getVar('redirectTitle')): ?>
		<p class="redirect-title">&mdash; <?= wfMessage( 'wikiasearch2-results-redirected-from' )->text() ?> <a href="<?=$result->getVar('redirectUrl')?>" <?=$trackingData?>><?= $result->getVar('redirectTitle') ?></a></p>
	<? endif; ?>

	<?= $result->getText(); ?>
	<?php if (! empty( $pages ) ) : ?>
	<div class="category-articles">
		<?php $apos = 0; ?>
		<?php foreach( $pages as $page ): ?>
		<div class="category-article">
			<div class="category-articles-thumb">
				<?php if ( !empty( $page['thumbnail'] ) ) : ?>
				<a href="<?=$page['url']?>" data-pos="<?= $apos ?>"><img src="<?=$page['thumbnail']?>" alt="<?=$page['title']?>"/></a>
				<?php endif; ?>
			</div>
			<div class="category-articles-text">
				<b><a href="<?=$page['url']?>" data-pos="<?= $apos++ ?>"><?=$page['title']?></a></b><?=$page['abstract']?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</article>
</li>
