<?php

echo F::app()->renderView(
	'AdEngine2',
	'AdEmptyContainer',
	[ 'slotName' => $slotName, 'pageTypes' => $pageTypes ]
);
