<section class="Search all-wikia WikiaGrid clearfix search-tracking">
	<div class="results-wrapper">
		<?php if (!empty($results)): ?>
			<?php if ($resultsFound > 0): ?>

				<p class="result-count subtle">
					<?php if (empty($isOneResultsPageOnly)): ?>
						<?= wfMessage('wikiasearch2-results-count', $resultsFoundTruncated, '<strong>' . $query . '</strong>')->inContentLanguage()->text(); ?>
					<?php else: ?>
						<?= wfMsg('wikiasearch2-results-for', '<strong>' . $query . '</strong>'); ?>
					<?php endif; ?>
					<?php if (isset($hub) && $hub) : ?>
						<?= wfMsg('wikiasearch2-onhub', $hub) ?>
						|
						<a
							href="<?= preg_replace('/&hub=[^&]+/', '', $_SERVER['REQUEST_URI']) ?>"><?= wfMsg('wikiasearch2-search-all-wikia') ?></a>
					<?php endif ?>
				</p>

				<? if ($results->getQuery() && $query != $results->getQuery()) : ?>
					<p><?= wfMsg('wikiasearch2-spellcheck', $query, $results->getQuery()) ?></p>
				<? endif; ?>

				<? if (!$hasArticleMatch && $isMonobook): ?>
					<?= wfMsgExt('searchmenu-new', array('parse'), $query); ?>
				<? endif; ?>

				<ul class="Results inter-wiki">
					<?
					$pos = 0;
					foreach ($results as $result) {
						$pos++;
						echo $app->getView('WikiaSearch', 'CrossWiki_result', array(
							'result' => $result,
							'pos' => $pos + (($currentPage - 1) * $resultsPerPage),
							'query' => $query,
							'hub' => $hub,
							'corporateWikiId' => $corporateWikiId,
							'wgExtensionsPath' => $wgExtensionsPath
						));
					}
					?>
				</ul>

				<?= $paginationLinks; ?>

			<?php else: ?>
				<? if (!$hasArticleMatch && $isMonobook): ?>
					<?= wfMsgExt('searchmenu-new', array('parse'), $query); ?>
				<? endif; ?>
				<p class="no-result"><i><?= wfMsg('wikiasearch2-noresults') ?></i></p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</section>
