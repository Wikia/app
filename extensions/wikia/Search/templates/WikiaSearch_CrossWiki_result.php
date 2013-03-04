<li class="result">
	<article>
		<?php $title = (empty( $result['isWikiMatch'] ) ) ? str_replace('$1', $result->getTitle(), $result->getVar('wikititle')) : $result->getTitle(); ?>
		<?php $trackingData = 'class="result-link" data-wid="'.$result->getCityId().'" data-pageid="'.$result->getVar
	('pageId').'" data-pagens="'.$result->getVar('ns').'" data-title="'.$result->getTitle().'" data-gpos="'.( !empty
	($gpos) ? $gpos : 0 ).'" data-pos="'.$pos.'" data-sterm="'.addslashes($query).'" data-stype="inter" data-rver="6"' . ( $result->getVar('isArticleMatch') ? ' data-event="search_click_match"' : '' ); ?>
		<img src="#" alt="<?= $title ?>" class="wikiPromoteThumbnail grid-1 alpha" />
		<div class="grid-5 result-description">
			<h1>
				<a href="<?= $result->getUrl(); ?>" <?=$trackingData;?> ><?= $title ?></a>
			</h1>

			<!-- TODO: Do we need this in cross wiki search -->
			<? if ($redirectTitle = $result->getVar('redirectTitle')): ?>
			<p class="redirect-title">&mdash; <?= wfMessage( 'wikiasearch2-results-redirected-from' )->text() ?> <a href="<?=$redirectTitle->getFullUrl()?>" <?=$trackingData?>><?= $redirectTitle->getText() ?></a></p>
			<? endif; ?>
			<!-- end -->

			<p class="hub subtle"><?= $hub ?></p>
			<p><?= $result->getText(); ?></p>
			<ul>
				<li><a href="<?= $result->getUrl(); ?>" <?=$trackingData;?> ><?=Language::factory($wg->ContentLanguage)->truncate($result->getTextUrl(), 90);?></a></li>
				<li><a href="http://<?= $result['host'] .'/wiki/Special:Search?search='.urlencode($query).'&fulltext=Search'; ?>"><?= wfMsg( 'wikiasearch2-search-on-wiki') ?></a></li>
			</ul>
			<ul class="wiki-statistics subtle">
				<li>11111</li>
				<li>12k Photos</li>
				<li>20 Videos</li>
			</ul>
		</div>
	</article>
</li>
