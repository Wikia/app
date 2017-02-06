<?php
$wgAutoloadClasses['PremiumDesignABTestHooks'] =  __DIR__ . '/PremiumDesignABTest.hooks.php';
$wgAutoloadClasses[ 'PremiumDesignABTestController' ] = __DIR__ . '/PremiumDesignABTestController.class.php';

$wgHooks['BeforePageDisplay'][] = 'PremiumDesignABTestHooks::onBeforePageDisplay';

$wgPremiumDesignABTestVariants = [
	// List of Spells
	3581 => [
		'letter' => 'A',
		'video_title' => 'Top 10 Harry Potter Spells We Wish Were Real',
		'video_time' => '10:21',
		'video_url' => 'https://www.youtube.com/watch?v=EMQtimSyBXI'
	],
	// Hogwart Houses
	967 => [
		'letter' => 'C',
		'video_title' => 'A Muggle\'s Guide to the Hogwarts Houses',
		'video_time' => '1:51',
		'video_url' => 'https://www.youtube.com/watch?v=q5WXzqdE2V8'
	],
	//Newton Scamander
	2425 => [
		'letter' => 'D',
		'video_title' => 'Newton Scamander',
		'video_time' => '2:13',
		'video_url' => 'https://www.youtube.com/watch?v=Ql9UxdyoL1c'
	]
];
