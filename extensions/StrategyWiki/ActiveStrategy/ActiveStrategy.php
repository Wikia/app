<?php

/* Registration */
$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'ActiveStrategy',
	'author'         => array( 'Tim Starling', 'Andrew Garrett' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:ActiveStrategy',
	'descriptionmsg' => 'active-strategy-desc',
);

$dir = dirname( __FILE__ ) . '/';

$wgHooks['ParserFirstCallInit'][] = 'ActiveStrategyPF::setup';

$wgExtensionMessagesFiles['ActiveStrategy'] = $dir . 'ActiveStrategy.i18n.php';

$wgAutoloadClasses['ActiveStrategy']  = $dir . 'ActiveStrategy_body.php';
$wgAutoloadClasses['ActiveStrategyPF'] = $dir."ParserFunctions.php";

/**
 * Period for edit counts, in seconds
 */
$wgActiveStrategyPeriod = 7 * 86400;

/**
 * Colors to display task forces/proposals in.
 * First looks for the specific sort field, otherwise looks at default.
 */
$wgActiveStrategyColors = array(
	'default' => array(
		0 => 'F00',
		1 => 'FF0',
		5 => 'AEA',
	),
	'members' => array(),
	'ranking' => array(),
);
