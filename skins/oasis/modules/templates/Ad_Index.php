<?php

echo F::app()->renderView(
	'AdEngine2',
	'Ad',
	[
		'slotName' => $slotName,
		'pageTypes' => $pageTypes,
		'includeLabel' => $includeLabel,
		'onLoad' => $onLoad,
		'addToAdQueue' => $addToAdQueue
	]
);
