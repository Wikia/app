<?php

/**
 * Hooks
 */
$wgAutoloadClasses['Wikia\PotentialMemberPageExperiments\Hooks'] = __DIR__ . '/Hooks.class.php';
$wgExtensionFunctions[] = 'Wikia\PotentialMemberPageExperiments\Hooks::register';

/**
 * Messages
 */
$wgExtensionMessagesFiles['PotentialMemberPageExperiment'] = __DIR__ . '/PotentialMemberPageExperiments.i18n.php';

JSMessages::registerPackage( 'PotentialMemberPageEntryPoint', [
	'pmp-entry-point-*'
] );
