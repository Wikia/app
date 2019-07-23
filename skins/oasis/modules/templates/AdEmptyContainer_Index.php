<?php

echo F::app()->renderView(
	'AdEngine3',
	'AdEmptyContainer',
	[
		'slotName' => $slotName,
		'pageTypes' => $pageTypes
	]
);
