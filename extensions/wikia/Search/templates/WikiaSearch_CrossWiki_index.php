<section class="Search all-wikia WikiaGrid clearfix">
	<? if ( empty( $wg->EnableGlobalNavExt ) ): ?>
	<form class="WikiaSearch" id="search-v2-form" action="<?=$specialSearchUrl;?>">
		<div class="SearchInput">
			<p><?= wfMsg('wikiasearch2-global-search-headline') ?></p>
			<input type="text" name="search" id="search-v2-input" value="<?=$query;?>" />
			<input type="hidden" name="fulltext" value="Search" />
			<? if ( !empty($hub) ): ?>
				<input type="hidden" name="hub" value="<?=$hub?>" />
			<? endif ?>
			<? if ( !empty($resultsLang) ): ?>
				<input type="hidden" name="resultsLang" value="<?=$resultsLang?>" />
			<? endif ?>
			<button type="submit" class="wikia-button" id="search-v2-button" value="<?= wfMsg( 'searchbutton' ); ?>"><img src="<?= $wg->BlankImgUrl ?>" class="sprite search" height="17" width="21"></button>
		</div>
	</form>
	<? endif ?>
	<div class="results-wrapper">
		<?php if (!empty($results)): ?>
			<?php if ($resultsFound > 0): ?>

				<p class="result-count subtle">
					<?php if (empty($isOneResultsPageOnly)): ?>
						<?= wfMsg('wikiasearch2-results-count', $resultsFoundTruncated, '<strong>' . $query . '</strong>'); ?>
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
