<section class=Search>
<?php if(!empty($results)): ?>
	<?php if( $resultsFound > 0 ): ?>
		<?if ( $pagesCount > 1) :?>
			<a id=wkResultPrev class="lbl<?= ( $currentPage > 1 ) ? ' pag' : '' ?>" href="<?= $wg->Title->getFullUrl( array_merge( array( 'search' => $query, 'page' => ($currentPage+1), 'fulltext' => 'Search' ) ) ); ?>"><?= wfMsg( 'wikiamobile-wikiasearch2-prev' ) ;?></a>
		<? endif ;?>

		<p id=wkResultCount>
			<?= '<span id=wkResCntAct>'.($resultsPerPage*$currentPage+1-$resultsPerPage).'-'.(($currentPage == $pagesCount) ? $resultsFound :$resultsPerPage*$currentPage).'</span>' . wfMsg('wikiamobile-wikiasearch2-results-count-of', $wg->Lang->formatNum( $resultsFound )); ?>
		</p>

		<? if ($results->getQuery() && $query != $results->getQuery()) : ?>
			<p><?= wfMsg( 'wikiasearch2-spellcheck', $query, $results->getQuery() ) ?></p>
		<? endif; ?>

		<ul id=wkResultUl data-query="<?= $query ;?>" data-page="<?= $currentPage ;?>" data-total-pages="<?= $pagesCount ;?>" data-total-results="<?= $resultsFound ;?>" data-results-per-page="<?= $resultsPerPage ;?>">
		<?php
			echo $app->getView( 'WikiaSearch', 'WikiaMobileResultList', array(
				'currentPage'=> $currentPage,
				'isInterWiki' => $isInterWiki,
				'results' => $results,
				'resultsPerPage' => $resultsPerPage,
				'query' => $query));
		?>
		</ul>

		<?if ( $pagesCount > 1) :?>
            <a id=wkResultNext class="lbl<?= ( $currentPage < $pagesCount ) ? ' pag' : '' ?>" href="<?= $wg->Title->getFullUrl( array_merge( array( 'search' => $query, 'page' => ($currentPage+1), 'fulltext' => 'Search' ) ) ); ?>"><?= wfMsg( 'wikiamobile-wikiasearch2-next' ) ;?></a>
		<?php endif; ?>

	<?php else:  ?>
		<p><i><?= wfMsg('wikiasearch2-noresults')?></i></p>
	<?php endif; ?>
<?php endif; ?>
</section>
