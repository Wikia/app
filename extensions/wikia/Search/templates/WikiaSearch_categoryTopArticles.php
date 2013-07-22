<li class="result">
	<article>
		<h1>
		<?php $title = wfMessage( 'wikiasearch2-category-result', $category )->text(); ?>

		<?php
			$trackingData = 'class="result-link" data-pos="'.$pos.'"' . ( $result->getVar('isArticleMatch') ? 'data-event="search_click_match"' : '' );
		?>

		<a href="<?= $result->getUrl(); ?>" <?=$trackingData;?> ><?= $title ?></a>
	</h1>
	<? if ($redirectTitle = $result->getVar('redirectTitle')): ?>
		<p class="redirect-title">&mdash; <?= wfMessage( 'wikiasearch2-results-redirected-from' )->text() ?> <a href="<?=$result->getVar('redirectUrl')?>" <?=$trackingData?>><?= $result->getVar('redirectTitle') ?></a></p>
	<? endif; ?>
	
	<? if ($result->getVar('ns') == NS_FILE): ?>
		<p class="subtle">
			<? if (!$result->getVar('created_30daysago')) : ?>
			<span class="timeago abstimeago " title="<?= $result->getVar('fmt_timestamp') ?>" alt="<?= $result->getVar('fmt_timestamp') ?>">&nbsp;</span>
			<? else : ?>
			<span class="timeago-fmt"><?= $result->getVar('fmt_timestamp') ?></span>
			<? endif; ?>
			<?php
				if ( $videoViews = $result->getVideoViews() ) {
					echo '&bull; '.$videoViews;
				}
			?>
		</p>
	<? endif; ?>
	<?= $result->getText(); ?>
	
	<?php if (! empty( $pages ) ) : ?>
	<ul class="articles">
		<?php foreach( $pages as $page ): ?>
		<li><a href="<?=$page['url']?>"><img src="<?=$page['thumbnail']?>" alt="<?=$page['title']?>"/><?=$page['title']?></a> <?=$page['abstract']?></li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
</article>
</li>

