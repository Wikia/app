<?php

if ( $wg->EnableAdEngineExt ) {
	echo F::app()->renderView(
		'AdEngine2',
		'AdEmptyContainer',
		[ 'slotName' => $slotName, 'pageTypes' => $pageTypes ]
	);
} else {
	echo '<!-- Ad Engine disabled -->';
}
