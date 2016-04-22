<?php

/**
 * Hooks
 */
$wgAutoloadClasses['Wikia\ContributionExperiments\Hooks'] = __DIR__ . '/Hooks.class.php';
$wgExtensionFunctions[] = 'Wikia\ContributionExperiments\Hooks::register';

$wgAutoloadClasses['ContributionExperimentsController'] = __DIR__ . '/ContributionExperimentsController.class.php';
