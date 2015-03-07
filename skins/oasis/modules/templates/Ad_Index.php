<?php

if ( $wg->EnableAdEngineExt ) {
	if ( isset( $pageFairId ) ) {
		echo '<div id="' . htmlspecialchars( $pageFairId ) . '" class="pagefair-acceptable">';
	}
	echo F::app()->renderView(
		'AdEngine2',
		'Ad',
		[ 'slotName' => $slotName, 'pageTypes' => $pageTypes, 'includeLabel' => $includeLabel ]
	);

	if ( isset( $pageFairId ) ) {
		echo '</div>';
	}
} else {
	echo '<!-- Ad Engine disabled -->';
}
