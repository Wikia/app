<?php
/**
 * GlobalNavigation
 *
 * @author Damian 'kvas' Jóźwiak
 *
 */

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'GlobalNavigation',
	'author' => 'Damian "kvas" Jóźwiak',
	'description' => 'GlobalNavigation',
	'version' => 1.0
);

// constroller classes
$wgAutoloadClasses['GlobalNavigationController'] =  $dir . 'GlobalNavigationController.class.php';

$wgExtensionMessagesFiles['GlobalNavigation'] = $dir . '/GlobalNavigation.i18n.php';
