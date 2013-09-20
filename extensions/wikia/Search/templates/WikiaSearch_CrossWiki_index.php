<section class="Search 'this-wiki WikiaGrid clearfix">
	<form class="WikiaSearch" id="search-v2-form" action="<?=$specialSearchUrl;?>">

		<div class="SearchInput">
			<?php foreach($namespaces as $ns): ?>
			<input type="hidden" class="default-tab-value" name="ns<?=$ns;?>" value="1" />
			<?php endforeach; ?>

			<p><?= wfMsg('wikiasearch2-global-search-headline') ?></p>

			<input type="text" name="search" id="search-v2-input" value="<?=$query;?>" />
			<input type="hidden" name="fulltext" value="Search" />
			<button type="submit" class="wikia-button" id="search-v2-button" value="<?= wfMsg( 'searchbutton' ); ?>"><img src="<?= $wg->BlankImgUrl ?>" class="sprite search" height="17" width="21"></button>
		</div>

		<div class="results-wrapper">

			<?php if(!empty($results)): ?>
			<?php if( $resultsFound > 0 ): ?>

				<p class="result-count subtle">
					<?php if( empty( $isOneResultsPageOnly ) ): ?>
					<?= wfMsg('wikiasearch2-results-count', $resultsFoundTruncated, '<strong>'.$query.'</strong>'); ?>
					<?php else: ?>
					<?= wfMsg('wikiasearch2-results-for', '<strong>'.$query.'</strong>'); ?>
					<?php endif; ?>
					<?php if ( isset($hub) && $hub ) : ?>
					<?= wfMsg('wikiasearch2-onhub', $hub)?>
					|
					<a href="<?=preg_replace('/&hub=[^&]+/', '', $_SERVER['REQUEST_URI'])?>"><?= wfMsg('wikiasearch2-search-all-wikia') ?></a>
					<?php endif ?>
				</p>

				<? if ($results->getQuery() && $query != $results->getQuery()) : ?>
					<p><?= wfMsg( 'wikiasearch2-spellcheck', $query, $results->getQuery() ) ?></p>
					<? endif; ?>

				<? if ( !$hasArticleMatch && $isMonobook ): ?>
					<?=wfMsgExt('searchmenu-new', array('parse'), $query);?>
					<? endif; ?>

				<ul class="Results inter-wiki">
					<?php $pos = 0; ?>
					<?php foreach( $results as $result ): ?>
					<?php
						$pos++;
						echo $app->getView( 'WikiaSearch', 'CrossWiki_result', array(
							'result' => $result,
							'pos' => $pos + (($currentPage - 1) * $resultsPerPage),
							'query' => $query,
							'hub' => $hub,
							'wgExtensionsPath' => $wgExtensionsPath
						));
					?>
					<?php endforeach; ?>
				</ul>

				<?= $paginationLinks; ?>

				<?php else: ?>
				<? if ( !$hasArticleMatch && $isMonobook ): ?>
					<?=wfMsgExt('searchmenu-new', array('parse'), $query);?>
					<? endif; ?>
				<p><i><?=wfMsg('wikiasearch2-noresults')?></i></p>
				<?php endif; ?>
			<?php endif; ?>

		</div>
	</form>
</section>
