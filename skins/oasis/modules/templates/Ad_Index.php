<?php

echo F::app()->renderView(
	'AdEngine3',
	'Ad',
	[
		'slotName' => $slotName,
		'pageTypes' => $pageTypes,
		'includeLabel' => $includeLabel,
		'onLoad' => $onLoad,
		'addToAdQueue' => $addToAdQueue
	]
);
