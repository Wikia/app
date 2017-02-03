<?php
$wgAutoloadClasses['PremiumDesignABTestHooks'] =  __DIR__ . '/PremiumDesignABTest.hooks.php';
$wgAutoloadClasses[ 'PremiumDesignABTestController' ] = __DIR__ . '/PremiumDesignABTestController.class.php';

$wgHooks['BeforePageDisplay'][] = 'PremiumDesignABTestHooks::onBeforePageDisplay';

$wgPremiumDesignABTestVariants = [
	// List of Spells
	3581 => [
		'letter' => 'A',
	],
	// Hogwart Houses
	967 => [
		'letter' => 'C',
	],
	//Newton Scamander
	2425 => [
		'letter' => 'D',
	]
];
