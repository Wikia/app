<?php if( empty( $inGroup ) ): ?>
	<li>
<?php endif; ?>
    <div class=result>
        <p>
            <?php
            $title = ( empty( $inGroup ) && $isInterWiki ) ? str_replace('$1', $result->getTitle(), $result->getVar('wikititle')) : $result->getTitle();
            $trackingData = 'class=result-link data-wid="'.$result->getCityId().'" data-pageid="'.$result->getVar('pageId').'" data-pagens="'.$result->getVar('ns').'" data-title="'.$result->getTitle().'" data-gpos="'.( !empty($gpos) ? $gpos : 0 ).'" data-pos="'.$pos.'" data-sterm="'.addslashes($query).'" data-stype="'.( $isInterWiki ? 'inter' : 'intra' ).'" data-rver="'.$relevancyFunctionId.'"' . ( $result->getVar('isArticleMatch') ? ' data-event=search_click_match' : '' );
            ?>
            <a class=title href="<?= $result->getLinkUrl(); ?>" <?=$trackingData;?> ><?= WikiaSearch::highlightSearchResult( $title, $query ) ?></a>
        </p>

        <span class=desc><?= WikiaSearch::highlightSearchResult( $wf->shortenText( strip_tags( $result->getText() ), 100 ), $query ); ?></span>
    </div>
<?php if( empty( $inGroup ) ): ?>
	</li>
<?php endif; ?>
