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
	<ul class="articles">
		<?php foreach( $pages as $page ): ?>
		<li><a href="<?=$page['url']?>"><img src="<?=$page['thumbnail']?>" alt="<?=$page['title']?>"/><?=$page['title']?></a> <?=$page['abstract']?></li>
		<?php endforeach; ?>
	</ul>
	<?php else: ?>
	<ul>
		<li><a href="<?= $result->getUrl(); ?>" <?=$trackingData;?> ><?=Language::factory($wg->ContentLanguage)->truncate($result->getTextUrl(), 90);?></a></li>
	</ul>
	<?php endif; ?>
</article>
</li>

