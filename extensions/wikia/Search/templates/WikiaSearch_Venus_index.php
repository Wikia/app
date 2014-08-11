<form class="WikiaSearch" id="search-v2-form" action="<?= $specialSearchUrl ?>#">
	<div class="SearchInput">
		<?php if ( !empty( $advancedSearchBox ) ) : ?>
			<p class="advanced-link"><a href="#" id="advanced-link"><?= wfMessage('searchprofile-advanced') ?></a></p>
		<?php endif ?>

		<p class="grid-1 alpha"><?= wfMsg('wikiasearch2-wiki-search-headline') ?></p>

		<input type="text" name="search" id="search-v2-input" value="<?= $query ?>" />
		<input type="hidden" name="fulltext" value="Search" />
		<button type="submit" class="wikia-button" id="search-v2-button" value="<?= wfMsg( 'searchbutton' ); ?>"><img src="<?= $wg->BlankImgUrl ?>" class="sprite search" height="17" width="21"></button>

		<?php if ( !empty( $advancedSearchBox ) ) : ?>
			<?= $advancedSearchBox ?>
		<?php endif; ?>
	</div>

	<?= $tabs ?>

	<div class="row">
		<article class="results-section small-12 medium-8 large-7 columns">
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

				<?php if ( $results->getQuery() && $query != $results->getQuery() ) : ?>
					<p><?= wfMsg( 'wikiasearch2-spellcheck', $query, $results->getQuery() ) ?></p>
				<?php endif; ?>
				<?php if ( !$hasArticleMatch && $isMonobook ): ?>
					<?=wfMessage( 'searchmenu-new' )->parse( $query )?>
				<?php endif; ?>

				<section class="results">
					<?php
						$pos = 0;
						$posShift = ( ( $currentPage - 1 ) * $resultsPerPage );
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
					<?= $paginationLinks; ?>
				</section>

			<?php else: ?>
				<?php if ( !$hasArticleMatch && $isMonobook ): ?>
					<?= wfMessage( 'searchmenu-new' )->parse( $query ); ?>
				<?php endif; ?>
				<div class="no-result"><em><?= wfMessage( 'wikiasearch2-noresults' )->text() ?></em></div>
			<?php endif; ?>
		</article>
		<div class="small-5 medium-4 large-4 small-offset-1 medium-offset-1 large-offset-1 columns search-right-rail">
			<div class="SearchAdsTopWrapper">
				<?= F::app()->renderView('Ad', 'Index', ['slotName' => 'TOP_RIGHT_BOXAD', 'pageTypes' => ['search']]); ?>
			</div>
			<?= $topWikiArticles ?>
			<div id="WikiaAdInContentPlaceHolder">
				<?= F::app()->renderView('Ad', 'Index', ['slotName' => 'LEFT_SKYSCRAPER_2', 'pageTypes' => ['search']]); ?>
			</div>
		</div>
	</div>
</form>

