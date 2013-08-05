<li class="result">
	<article>
		<h1>
		<?php $title = !empty( $pages ) ? wfMessage( 'wikiasearch2-category-result', $category )->text() : $result->getTitle(); ?>

		<?php
			$trackingData = 'class="result-link" data-pos="'.$pos.'"' . ( $result->getVar('isArticleMatch') ? 'data-event="search_click_match"' : '' );
		?>

		<a href="<?= $result->getUrl(); ?>" <?=$trackingData;?> ><?= $title ?></a>
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
			<div class="category-articles-thumb" data-pos="<?= $apos ?>">
				<a href="<?=$page['url']?>"><img src="<?=$page['thumbnail']?>" alt="<?=$page['title']?>"/></a>
			</div>
			<div class="category-articles-text" data-pos="<?= $apos++ ?>">
				<b><a href="<?=$page['url']?>"><?=$page['title']?></a></b>
				<?=$page['abstract']?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</article>
</li>
