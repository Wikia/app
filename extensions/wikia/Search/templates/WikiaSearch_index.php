<section class="Search <?php if(!$isCorporateWiki) echo 'this-wiki WikiaGrid clearfix'; ?>">
	<form class="WikiaSearch" id="search-v2-form" action="<?=$pageUrl;?>">
		<?php foreach($namespaces as $ns): ?>
			<input type="hidden" class="default-tab-value" name="ns<?=$ns;?>" value="1" />
		<?php endforeach; ?>

		<?php if($isInterWiki): ?>
			<p><?= wfMsg('wikiasearch2-global-search-headline') ?></p>
		<?php else: ?>
			<p class="grid-1 alpha"><?= wfMsg('wikiasearch2-wiki-search-headline') ?></p>
		<?php endif; ?>

		<input type="text" name="search" id="search-v2-input" value="<?=$query;?>" />
		<input type="hidden" name="fulltext" value="Search" />
		<button type="submit" class="wikia-button" id="search-v2-button" value="<?= wfMsg( 'searchbutton' ); ?>"><img src="<?= $wg->BlankImgUrl ?>" class="sprite search" height="17" width="21"></button>

		<?php if($debug): ?>
		<fieldset>
			<label><input type="checkbox" name="crossWikia" value="1" <?= ( $isInterWiki ? 'checked' : '' ); ?>/> <?= wfMsg( 'wikiasearch2-search-all-wikia' ); ?></label>
			<label><input type="checkbox" name="debug" value="1" <?= ( $debug ? 'checked' : '' ); ?>/> Debug mode</label>
		</fieldset>
		<?php endif; ?>
		<?php if ($debug): ?>
			<br/>
			<i>Query Time: <?=$results->getQueryTime();?></i>
		<?php endif; ?>

		<?php if(!empty($advancedSearchBox)) : ?>
		<?php echo $advancedSearchBox; ?>
		<?php endif; ?>

	</form>

	<?php if(!$isCorporateWiki): ?>
		<?php echo $tabs; ?>
	<?php endif; ?>

	<?php if($isCorporateWiki): ?>
		<?php if ($showSearchAds): ?>
			<div id="SearchAdsTop" class="WikiaSearchAds SearchAdsTop">
				<h3 class="subtle"><?= wfMsg( 'wikiasearch2-search-ads-header' );?></h3>
				<ul class="list loading"></ul>
			</div>
		<?php else: // regular ads ?>
			<?php // Regular right-hand ads not compatible with corporate search ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php if(!$isCorporateWiki): ?>
		<div class="results-wrapper grid-3 alpha">
	<?php endif; ?>
		
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

				<ul class="Results">
				<?php $pos = 0; ?>
				<?php foreach( $results as $result ): ?>
					<?php
						$pos++;
						if($result instanceof WikiaSearchResultSet) {
							echo $app->getView( 'WikiaSearch', 'resultSet', array(
							  'resultSet' => $result,
							  'pos' => $pos + (($currentPage - 1) * $resultsPerPage),
							  'debug' => $debug,
							  'query' => $query,
							  'isInterWiki' => $isInterWiki,
							  'relevancyFunctionId' => $relevancyFunctionId
							));
						}
						else {
							echo $app->getView( 'WikiaSearch', 'result', array(
							  'result' => $result,
							  'gpos' => 0,
							  'pos' => $pos + (($currentPage - 1) * $resultsPerPage),
							  'debug' => $debug,
							  'query' => $query,
							  'isInterWiki' => $isInterWiki,
							  'relevancyFunctionId' => $relevancyFunctionId
							));
						}
					?>
				<?php endforeach; ?>
				</ul>

				<?php if(!$isCorporateWiki): ?>
					<?= $paginationLinks; ?>
				<?php endif; ?>

				<?php if ($showSearchAds): ?>
					<div id="SearchAdsBottom" class="WikiaSearchAds SearchAdsBottom">
						<h3 class="subtle"><?= wfMsg( 'wikiasearch2-search-ads-header' );?></h3>
						<ul class="list loading"></ul>
					</div>
				<?php endif; ?>

				<?php if($isCorporateWiki): ?>
					<?= $paginationLinks; ?>
				<?php endif; ?>

			<?php else: ?>
				<? if ( !$hasArticleMatch && $isMonobook ): ?>
					<?=wfMsgExt('searchmenu-new', array('parse'), $query);?>
				<? endif; ?>
				<p><i><?=wfMsg('wikiasearch2-noresults')?></i></p>
			<?php endif; ?>
		<?php else: // add border in center column for blank search page BugId: 48489 ?>
			<p>&nbsp;</p>	
		<?php endif; ?>

	<?php if(!$isCorporateWiki): ?>
		</div>
	<?php endif; ?>

	<?php if(!$isCorporateWiki): ?>
		<div class="SearchAdsTopWrapper grid-2 alpha">
		<?php if ($showSearchAds): ?>
			<div id="SearchAdsTop" class="WikiaSearchAds SearchAdsTop">
				<h3 class="subtle"><?= wfMsg( 'wikiasearch2-search-ads-header' );?></h3>
				<ul class="list loading"></ul>
			</div>
		<?php else: // regular ads ?>
			<?= F::app()->renderView('Ad', 'Index', array('slotname' => 'TOP_RIGHT_BOXAD')); ?>
			<?= F::app()->renderView('Ad', 'Index', array('slotname' => 'LEFT_SKYSCRAPER_2')); ?>
			<div id="WikiaAdInContentPlaceHolder"></div>
		<?php endif; ?>
		</div>
	<?php endif; ?>

</section>
