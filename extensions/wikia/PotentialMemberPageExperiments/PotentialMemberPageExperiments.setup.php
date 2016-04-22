<?php

/**
 * Hooks
 */
$wgAutoloadClasses['Wikia\PotentialMemberPageExperiments\Hooks'] = __DIR__ . '/Hooks.class.php';
$wgExtensionFunctions[] = 'Wikia\PotentialMemberPageExperiments\Hooks::register';
