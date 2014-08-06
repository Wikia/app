<form class="WikiaSearch" id="search-v2-form" action="<?=$specialSearchUrl;?>#">
	<div class="SearchInput">
		<?php if(!empty($advancedSearchBox)) : ?>
			<p class="advanced-link"><a href="#" id="advanced-link"><?= wfMessage('searchprofile-advanced') ?></a></p>
		<?php endif ?>

		<p class="grid-1 alpha"><?= wfMsg('wikiasearch2-wiki-search-headline') ?></p>

		<input type="text" name="search" id="search-v2-input" value="<?=$query;?>" />
		<input type="hidden" name="fulltext" value="Search" />
		<button type="submit" class="wikia-button" id="search-v2-button" value="<?= wfMsg( 'searchbutton' ); ?>"><img src="<?= $wg->BlankImgUrl ?>" class="sprite search" height="17" width="21"></button>

		<?php if(!empty($advancedSearchBox)) : ?>
			<?php echo $advancedSearchBox; ?>
		<?php endif; ?>
	</div>

	<?php echo $tabs; ?>

	<div class="row">
	<article class="results-section small-6 medium-7 large-7 columns">
		<?php if( $resultsFound > 0 ): ?>
			<span class="result-count">
				<?php if( empty( $isOneResultsPageOnly ) ): ?>
					<?= wfMessage('wikiasearch2-results-count', $resultsFoundTruncated, '<strong>'.$query.'</strong>')->text(); ?>
				<?php else: ?>
					<?= wfMessage('wikiasearch2-results-for', '<strong>'.$query.'</strong>')->text(); ?>
				<?php endif; ?>
				<?php if ( isset($hub) && $hub ) : ?>
					<?= wfMessage('wikiasearch2-onhub', $hub)->text()?>
					|
					<a href="<?=preg_replace('/&hub=[^&]+/', '', $_SERVER['REQUEST_URI'])?>"><?= wfMessage('wikiasearch2-search-all-wikia')->text() ?></a>
				<?php endif ?>
			</span>

			<? if ($results->getQuery() && $query != $results->getQuery()) : ?>
				<p><?= wfMsg( 'wikiasearch2-spellcheck', $query, $results->getQuery() ) ?></p>
			<? endif; ?>
			<? if ( !$hasArticleMatch && $isMonobook ): ?>
				<?=wfMessage('searchmenu-new')->parse($query)?>
			<? endif; ?>

			<section class="results">
				<?php
					$pos = 0;
					$posShift = (($currentPage - 1) * $resultsPerPage);
				?>
				<?php foreach( $results as $result ): ?>
					<?php
					$pos++;
						echo $app->getView( 'WikiaSearch', 'VenusResult', array(
							'result' => $result,
							'gpos' => 0,
							'pos' => $pos + $posShift,
							'query' => $query
						));
					?>
				<?php endforeach; ?>
			</section>

			<?= $paginationLinks; ?>

		<?php else: ?>
			<? if ( !$hasArticleMatch && $isMonobook ): ?>
				<?=wfMsgExt('searchmenu-new', array('parse'), $query);?>
			<? endif; ?>
			<p class="no-result"><i><?=wfMsg('wikiasearch2-noresults')?></i></p>
		<?php endif; ?>
	</article>
	</div>
</form>
