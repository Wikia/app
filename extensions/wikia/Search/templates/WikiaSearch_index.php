<section class="Search this-wiki WikiaGrid clearfix search-tracking">
	<form class="WikiaSearch" id="search-v2-form" action="<?= $specialSearchUrl; ?>#">
		<div class="SearchInput">
			<?php if ( !empty( $advancedSearchBox ) ) : ?>
				<p class="advanced-link"><a href="#" id="advanced-link"><?= wfMessage( 'searchprofile-advanced' ) ?></a>
				</p>
			<?php endif ?>

			<div class="WikiaSearchInputWrapper">
				<div class="wds-dropdown">
					<div class="wds-dropdown__toggle">
						<span>
							<?= $scope === \Wikia\Search\Config::SCOPE_INTERNAL
								? wfMsg( 'wikiasearch2-search-scope-internal' )
								: wfMsg( 'wikiasearch2-search-scope-crosswiki' ) ?>
						</span>
						<?= DesignSystemHelper::renderSvg( 'wds-icons-dropdown-tiny', 'wds-icon wds-icon-tiny wds-dropdown__toggle-chevron' ); ?>
					</div>
					<div class="wds-dropdown__content">
						<ul class="wds-list wds-is-linked">
							<li>
								<a href="#" data-value="<?= \Wikia\Search\Config::SCOPE_INTERNAL ?>">
									<?= wfMsg( 'wikiasearch2-search-scope-internal' ) ?></a>
							</li>
							<li>
								<a href="#" data-value="<?= \Wikia\Search\Config::SCOPE_CROSS_WIKI ?>">
									<?= wfMsg( 'wikiasearch2-search-scope-crosswiki' ) ?></a>
							</li>
						</ul>
					</div>
				</div>
				<input type="text" name="search" id="search-v2-input" class="search-v2-input" value="<?= $query; ?>"/>
			</div>
			<input type="hidden" name="fulltext" value="Search"/>
			<input type="hidden" id="search-v2-scope" name="scope" value="<?= Sanitizer::encodeAttribute( $scope ) ?>"/>
			<button type="submit" class="wikia-button" id="search-v2-button" value="<?= wfMsg( 'searchbutton' ); ?>">
				<img src="<?= $wg->BlankImgUrl ?>" class="sprite search" height="17" width="21"></button>

			<?php if ( !empty( $advancedSearchBox ) ) : ?>
				<?php echo $advancedSearchBox; ?>
			<?php endif ?>
		</div>

		<?php echo $tabs; ?>

		<div class="results-wrapper grid-3 alpha">
			<?php if ( !empty( $results ) ): ?>
				<?php if ( $resultsFound > 0 ): ?>
					<p class="result-count subtle">
						<?php if ( empty( $isOneResultsPageOnly ) ): ?>
							<?= wfMsg(
								'wikiasearch2-results-count',
								$resultsFoundTruncated,
								'<strong>' . $query . '</strong>'
							); ?>
						<?php else : ?>
							<?= wfMsg(
									'wikiasearch2-results-for',
								 	'<strong>' . $query . '</strong>'
							); ?>
						<?php endif; ?>
						<?php if ( isset( $hub ) && $hub ) : ?>
							<?= wfMessage( 'wikiasearch2-onhub', Sanitizer::stripAllTags( $hub ) )->escaped(); ?>
							|
							<a href="<?=preg_replace( '/&hub=[^&]+/', '', $_SERVER['REQUEST_URI'] )?>"><?= wfMsg( 'wikiasearch2-search-all-wikia' ) ?></a>
						<?php endif ?>
					</p>

					<ul class="Results">
					<?php $pos = 0; ?>

					<?php foreach ( $results as $result ): ?>
						<?php
							$pos++;
							if ( ( $pos == 3 || $pos == 7 ) && isset( $mediaData ) ):
								echo '<li class="result video-addon-results video-addon-results-before-' . $pos . '">' . $app->getView( 'WikiaSearch', 'mediadata', array( 'mediaData' => $mediaData, 'query' => $query ) ) . '</li>';
							endif;
							if ( $result['ns'] === 0 ) {
								echo $app->getView( 'WikiaSearch', 'result', array(
									  'result' => $result,
									  'gpos' => 0,
									  'pos' => $pos + ( ( $currentPage - 1 ) * $resultsPerPage ),
									  'query' => $query,
									  'scope' => $scope,
									) );
								continue;
							}
							// display standard view instead
							echo $app->getView( 'WikiaSearch', WikiaSearchController::WIKIA_DEFAULT_RESULT, array(
									'result' => $result,
									'gpos' => 0,
									'pos' => $pos + ( ( $currentPage - 1 ) * $resultsPerPage ),
									'query' => $query,
									'scope' => $scope,
								) );
						?>
					<?php endforeach; ?>
					</ul>

					<?= $paginationLinks; ?>

				<?php else : ?>
					<p class="no-result"><i><?=wfMsg( 'wikiasearch2-noresults' )?></i></p>
				<?php endif; ?>
			<?php else : // add border in center column for blank search page BugId: 48489 ?>
				<p>&nbsp;</p>
			<?php endif; ?>

			</div>
			<div class="SearchAdsTopWrapper WikiaRail <?= !empty( $isGridLayoutEnabled ) ? 'grid-2' : '' ?> alpha">
				<?= F::app()->renderView( 'Ad', 'Index', ['slotName' => 'TOP_BOXAD', 'pageTypes' => ['search']] ); ?>
				<?php if ( !empty( $wikiMatch ) ):?>
					<?= $wikiMatch ?>
				<?php endif; ?>
				<?php if ( !empty( $fandomStories ) ): ?>
					<?= F::app()->renderView( 'WikiaSearch', 'fandomStories', [
						'stories' => $fandomStories,
						'viewMoreLink' => $viewMoreFandomStoriesLink
					] ); ?>
				<?php endif ?>
				<?php if ( !empty( $topWikiArticles ) ) : ?>
					<?= F::app()->renderView( 'WikiaSearch', 'topWikiArticles', [ 'pages' => $topWikiArticles ] ); ?>
				<?php endif ?>
				<div id="WikiaAdInContentPlaceHolder" class="rail-sticky-module"></div>
			</div>
	</form>
</section>
