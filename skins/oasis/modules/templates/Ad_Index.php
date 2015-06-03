<?php

if ( $wg->EnableAdEngineExt ) {
	echo F::app()->renderView(
		'AdEngine2',
		'Ad',
		[ 'slotName' => $slotName, 'pageTypes' => $pageTypes, 'includeLabel' => $includeLabel, 'onLoad' => $onLoad ]
	);
} else {
	echo '<!-- Ad Engine disabled -->';
}
