<section class="Search all-wikia WikiaGrid clearfix search-tracking">
	<div class="results-wrapper">
		<?php use Wikia\Search\UnifiedSearch\UnifiedSearchCommunityResultItem;
		use Wikia\Search\UnifiedSearch\UnifiedSearchCommunityResultItemExtender;
		use Wikia\Search\UnifiedSearch\UnifiedSearchResultItem;

		if (!empty($results)): ?>
			<?php if ($resultsFound > 0): ?>

				<p class="result-count subtle">
					<?php if (empty($isOneResultsPageOnly)): ?>
						<?= wfMessage('wikiasearch2-results-count', $resultsFoundTruncated, '<strong>' . $query . '</strong>')->text(); ?>
					<?php else: ?>
						<?= wfMsg('wikiasearch2-results-for', '<strong>' . $query . '</strong>'); ?>
					<?php endif; ?>
					<?php if (isset($hub) && $hub) : ?>
						<?= wfMessage( 'wikiasearch2-onhub', Sanitizer::stripAllTags( $hub ) )->escaped() ?>
						|
						<a
							href="<?= preg_replace('/&hub=[^&]+/', '', $_SERVER['REQUEST_URI']) ?>"><?= wfMsg('wikiasearch2-search-all-wikia') ?></a>
					<?php endif ?>
				</p>

				<ul class="Results inter-wiki">
					<?
					$pos = 0;
					/** @var UnifiedSearchCommunityResultItem $result */
					foreach ($results as $result) {
						$pos++;
						echo $app->getView('WikiaSearch', 'Community_result',
							[
								'result' => UnifiedSearchCommunityResultItemExtender::extendCommunityResult(
									$result,
									$pos + (($currentPage - 1) * $resultsPerPage),
									$query,
									UnifiedSearchCommunityResultItemExtender::MAX_WORD_COUNT_COMMUNITY_RESULT
								)
							]
						);
					}
					?>
				</ul>

				<?= $paginationLinks; ?>

			<?php else: ?>
				<p class="no-result"><i><?= wfMsg('wikiasearch2-noresults') ?></i></p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</section>
