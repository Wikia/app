<section class="Search this-wiki WikiaGrid clearfix search-tracking">
	<form class="WikiaSearch" id="search-v2-form" action="<?=$specialSearchUrl; ?>#">
		<div class="SearchInput">
			<?php if ( !empty( $advancedSearchBox ) ) : ?>
				<p class="advanced-link"><a href="#" id="advanced-link"><?= wfMessage( 'searchprofile-advanced' ) ?></a></p>
				<?php endif ?>

				<p class="grid-1 alpha"><?= wfMsg( 'wikiasearch2-wiki-search-headline' ) ?></p>

				<input type="text" name="search" id="search-v2-input" class="search-v2-input" value="<?=$query; ?>" />
			<input type="hidden" name="fulltext" value="Search" />
			<button type="submit" class="wikia-button" id="search-v2-button" value="<?= wfMsg( 'searchbutton' ); ?>"><img src="<?= $wg->BlankImgUrl ?>" class="sprite search" height="17" width="21"></button>

			<?php if ( !empty( $advancedSearchBox ) ) : ?>
				<?php echo $advancedSearchBox; ?>
			<?php endif ?>
		</div>

		<?php echo $tabs; ?>

		<div class="results-wrapper grid-3 alpha">
			<?php if ( !empty( $wikiMatch ) ):?>
				<?=$wikiMatch?>
			<?php endif; ?>
			<?php if ( !empty( $results ) ): ?>
				<?php if ( $resultsFound > 0 ): ?>
					<p class="result-count subtle">
						<?php if ( empty( $isOneResultsPageOnly ) ): ?>
							<?= wfMsg( 'wikiasearch2-results-count', $resultsFoundTruncated, '<strong>' . $query . '</strong>' ); ?>
						<?php else : ?>
							<?= wfMsg( 'wikiasearch2-results-for', '<strong>' . $query . '</strong>' ); ?>
						<?php endif; ?>
						<?php if ( isset( $hub ) && $hub ) : ?>
							<?= wfMessage( 'wikiasearch2-onhub', Sanitizer::stripAllTags( $hub ) )->text(); ?>
							|
							<a href="<?=preg_replace( '/&hub=[^&]+/', '', $_SERVER['REQUEST_URI'] )?>"><?= wfMsg( 'wikiasearch2-search-all-wikia' ) ?></a>
						<?php endif ?>
					</p>

					<? if ( $results->getQuery() && $query != $results->getQuery() ) : ?>
					<p><?= wfMsg( 'wikiasearch2-spellcheck', $query, $results->getQuery() ) ?></p>
					<? endif; ?>
					<? if ( !$hasArticleMatch && $isMonobook ): ?>
						<?=wfMsgExt( 'searchmenu-new', array( 'parse' ), $query ); ?>
					<? endif; ?>

					<ul class="Results">
					<?php $pos = 0; ?>
					<?php foreach ( $results as $result ): ?>
						<?php
							$pos++;
							if ( ( $pos == 3 || $pos == 7 ) && isset( $mediaData ) ):
								echo '<li class="result video-addon-results video-addon-results-before-' . $pos . '">' . $app->getView( 'WikiaSearch', 'mediadata', array( 'mediaData' => $mediaData, 'query' => $query ) ) . '</li>';
							endif;
							if ( $result['ns'] === 0 ) {
								echo $app->getView( 'WikiaSearch', $resultView, array(
									  'result' => $result,
									  'gpos' => 0,
									  'pos' => $pos + ( ( $currentPage - 1 ) * $resultsPerPage ),
									  'query' => $query
									) );
								continue;
							} else if ( $result['ns'] === 14 && empty( $categorySeen ) && !empty( $categoryModule ) ) {
								$categorySeen = true;
								$topArticles = $app->sendRequest( 'WikiaSearch', 'categoryTopArticles', array(
									  'result' => $result,
									  'gpos' => 0,
									  'pos' => $pos + ( ( $currentPage - 1 ) * $resultsPerPage ),
									  'query' => $query,
									), true );
								if ( count( $topArticles->getVal( 'pages' ) ) > 0 ) {
									echo $topArticles->toString();
									continue;
								}
							}
							// display standard view instead
							echo $app->getView( 'WikiaSearch', WikiaSearchController::WIKIA_DEFAULT_RESULT, array(
									'result' => $result,
									'gpos' => 0,
									'pos' => $pos + ( ( $currentPage - 1 ) * $resultsPerPage ),
									'query' => $query
								) );
						?>
					<?php endforeach; ?>
					</ul>

					<?= $paginationLinks; ?>

				<?php else : ?>
					<? if ( !$hasArticleMatch && $isMonobook ): ?>
						<?=wfMsgExt( 'searchmenu-new', array( 'parse' ), $query ); ?>
					<? endif; ?>
					<p class="no-result"><i><?=wfMsg( 'wikiasearch2-noresults' )?></i></p>
				<?php endif; ?>
			<?php else : // add border in center column for blank search page BugId: 48489 ?>
				<p>&nbsp;</p>
			<?php endif; ?>

			</div>
			<div class="SearchAdsTopWrapper WikiaRail <?= !empty( $isGridLayoutEnabled ) ? 'grid-2' : '' ?> alpha">
				<?= F::app()->renderView( 'Ad', 'Index', ['slotName' => 'TOP_RIGHT_BOXAD', 'pageTypes' => ['search']] ); ?>
				<?= $topWikiArticles ?>
				<?= F::app()->renderView( 'Ad', 'Index', ['slotName' => 'LEFT_SKYSCRAPER_2', 'pageTypes' => ['search']] ); ?>
				<div id="WikiaAdInContentPlaceHolder"></div>
			</div>
	</form>
</section>
