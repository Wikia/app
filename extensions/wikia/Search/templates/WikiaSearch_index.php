<section class="Search this-wiki WikiaGrid clearfix search-tracking">
	<form class="WikiaSearch" id="search-v2-form" action="<?=$specialSearchUrl; ?>#">
		<div class="SearchInput">
			<?php if ( !empty( $advancedSearchBox ) ) : ?>
				<p class="advanced-link"><a href="#" id="advanced-link"><?= wfMessage( 'searchprofile-advanced' ) ?></a></p>
			<?php endif ?>

				<p class="grid-1 alpha">
					<select name="scope">
						<option
							value="<?= \Wikia\Search\Config::SCOPE_INTERNAL ?>"
							<?= $scope === \Wikia\Search\Config::SCOPE_INTERNAL ? 'selected="selected"' : '' ?>
						>This wiki</option>
						<option
							value="<?= \Wikia\Search\Config::SCOPE_CROSS_WIKI ?>"
							<?= $scope === \Wikia\Search\Config::SCOPE_CROSS_WIKI ? 'selected="selected"' : '' ?>
						>All wikis</option>
					</select>
				</p>

<!--			<div class="wds-dropdown">-->
<!--				<div class="wds-tabs__tab-label wds-dropdown__toggle">-->
<!--					<span>Scope</span>-->
<!--					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 12 12" class="wds-icon wds-icon-tiny wds-dropdown__toggle-chevron" id="wds-icons-dropdown-tiny"><defs><path id="dropdown-tiny-a" d="M6.0001895,8.80004571 C5.79538755,8.80004571 5.5905856,8.72164496 5.43458411,8.56564348 L2.23455364,5.365613 C2.00575146,5.13681083 1.93695081,4.79280755 2.06095199,4.4936047 C2.18415316,4.19440185 2.47695595,4 2.80015903,4 L9.20021997,4 C9.52342305,4 9.81542583,4.19440185 9.93942701,4.4936047 C10.0634282,4.79280755 9.99462754,5.13681083 9.76582536,5.365613 L6.56579489,8.56564348 C6.4097934,8.72164496 6.20499145,8.80004571 6.0001895,8.80004571 Z"></path></defs><use fill-rule="evenodd" xlink:href="#dropdown-tiny-a"></use></svg>						</div>-->
<!--				<div class="wds-is-not-scrollable wds-dropdown__content" style="z-index: 9999999">-->
<!--					<ul class="wds-list wds-is-linked wds-has-bolded-items">-->
<!--						<li>-->
<!--							<a href="/wiki/Special:RandomInCategory/The_Muppets_Characters" data-tracking="custom-level-2">-->
<!--								Random Muppets Character											</a>-->
<!--						</li>-->
<!--						<li>-->
<!--							<a href="/wiki/Special:RandomInCategory/Sesame_Street_Characters" data-tracking="custom-level-2">-->
<!--								Random Sesame Street Character											</a>-->
<!--						</li>-->
<!--						<li>-->
<!--							<a href="/wiki/Special:RandomInCategory/Fraggle_Rock_Characters" data-tracking="custom-level-2">-->
<!--								Random Fraggle Rock Character											</a>-->
<!--						</li>-->
<!--					</ul>-->
<!--				</div>-->
<!--			</div>-->


			<input type="text" name="search" id="search-v2-input" class="search-v2-input" value="<?=$query; ?>" />
			<input type="hidden" name="fulltext" value="Search" />
			<button type="submit" class="wikia-button" id="search-v2-button" value="<?= wfMsg( 'searchbutton' ); ?>"><img src="<?= $wg->BlankImgUrl ?>" class="sprite search" height="17" width="21"></button>

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
								'wikiasearch2-results' . ($scope === \Wikia\Search\Config::SCOPE_CROSS_WIKI ? '-crosswiki' : '') . '-count',
								$resultsFoundTruncated, 
								'<strong>' . $query . '</strong>' 
							); ?>
						<?php else : ?>
							<?= wfMsg(
									'wikiasearch2-results' . ($scope === \Wikia\Search\Config::SCOPE_CROSS_WIKI ? '-crosswiki' : '') . '-for',
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
					<?= $app->renderView('Ad', 'Index', [
						'slotName' => 'incontent_native',
						'pageTypes' => ['search'],
						'addToAdQueue' => AdEngine3::isEnabled()
					]); ?>

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
									  'query' => $query
									) );
								continue;
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
