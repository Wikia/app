<?php
/**
 * Zenbox
 *
 * @author Damian Jozwiak
 *
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'Zenbox',
	'author' => 'Damian Jóźwiak',
	'description' => 'Zendesk feedback tab loader',
	'version' => 1.0
);

$wgAutoloadClasses['ZenboxHooks'] =  __DIR__ . '/ZenboxHooks.class.php';
