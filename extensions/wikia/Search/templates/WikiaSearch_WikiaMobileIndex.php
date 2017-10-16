<section class=Search>
<?php if(!empty($results)): ?>
	<?php if( $resultsFound > 0 ): ?>
		<?if ( $pagesCount > 1) :?>
			<a id=wkResultPrev class="lbl<?= ( $currentPage > 1 ) ? ' pag' : '' ?>" href="<?= $wg->Title->getFullUrl( array_merge( array( 'search' => $query, 'page' => ($currentPage+1), 'fulltext' => 'Search' ) ) ); ?>"><?= wfMessage( 'wikiamobile-wikiasearch2-prev' )->text(); ?></a>
		<? endif ;?>

		<p id=wkResultCount>
			<?= wfMessage( 'wikiamobile-wikiasearch2-count-of-results' )->numParams( $shownResultsBegin, (int)$shownResultsEnd, $resultsFound )->text(); ?>
		</p>

		<? if ($results->getQuery() && $query != $results->getQuery()) : ?>
			<p><?= wfMessage( 'wikiasearch2-spellcheck' )->params( $query, $results->getQuery() )->text(); ?></p>
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
            <a id=wkResultNext class="lbl<?= ( $currentPage < $pagesCount ) ? ' pag' : '' ?>" href="<?= $wg->Title->getFullUrl( array_merge( array( 'search' => $query, 'page' => ($currentPage+1), 'fulltext' => 'Search' ) ) ); ?>"><?= wfMessage( 'wikiamobile-wikiasearch2-next' )->text(); ?></a>
		<?php endif; ?>

	<?php else:  ?>
		<p><i><?= wfMessage('wikiasearch2-noresults')->text(); ?></i></p>
	<?php endif; ?>
<?php endif; ?>
</section>
