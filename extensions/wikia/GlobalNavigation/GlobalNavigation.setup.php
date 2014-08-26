<?php
/**
 * GlobalNavigation
 *
 * @author Damian 'kvas' Jóźwiak
 *
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'GlobalNavigation',
	'author' => 'Damian "kvas" Jóźwiak',
	'description' => 'GlobalNavigation',
	'version' => 1.0
);

// controller classes
$wgAutoloadClasses['GlobalNavigationController'] =  __DIR__ . '/GlobalNavigationController.class.php';

$wgExtensionMessagesFiles['GlobalNavigation'] = __DIR__ . '/GlobalNavigation.i18n.php';
