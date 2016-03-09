<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'EmergencyBroadcastSystem',
	'version' => '1.0',
	// A version of this list can be regenerated with the following one-liner:
	// git ls-tree -r HEAD | cut -f 2 | grep -E '\.(js|cc|h|cpp|hpp|c|txt|sh|php)$' | grep -v -E 'scripts|html5' | xargs -n1 git blame --line-porcelain | sed -ne '/^author /{ s/^author //; h }' -e '/^author-mail /{ s/^author-mail //; H; g; y/\n/ /; p }' | sort | uniq -c | sort -nr | sed -e 's/^[ ]*[1-9][0-9]* //'
	'author' => array( 'Paul Oslund', 'Inez Korczynski', 'Andrew Gleeson' )
);

$dir = dirname( __FILE__ );

$wgAutoloadClasses['EmergencyBroadcastSystemController'] =  $dir . '/EmergencyBroadcastSystemController.class.php';
$wgAutoloadClasses['EmergencyBroadcastSystemHooks'] =  $dir . '/EmergencyBroadcastSystemHooks.class.php';

$wgHooks['BeforePageDisplay'][] = 'EmergencyBroadcastSystemHooks::onBeforePageDisplay';

$wgExtensionMessagesFiles['EmergencyBroadcastSystem'] = $dir . '/EmergencyBroadcastSystem.i18n.php';
