<?php

/**
 * Performance A/B testing "framework"
 *
 * Defines a set of expirements with criterias of when to enable them
 *
 * @see PLATFORM-1246
 * @author macbre
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'A/B Performance Tests',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AbPerfTesting'
);

# experiments classes
#$wgAutoloadClasses['Wikia\\AbPerfTesting\\Experiment'] = __DIR__ . '/experiments/Experiment.class.php';

# criteria
$wgAutoloadClasses[ 'Wikia\\AbPerfTesting\\Criterion'       ] = __DIR__ . '/criteria/Criterion.class.php';
$wgAutoloadClasses[ 'Wikia\\AbPerfTesting\\Criteria\\Wikis' ] = __DIR__ . '/criteria/Wikis.class.php';

// experiments config goes here
$wgABPerfTestingExperiments = [];

/**
 * Example entry:
 *
 * $wgABPerfTestingExperiments['an_experiment_42'] = [
 *   # PHP class that will be created when the experiment is considered active
 *	'handler' => 'Wikia\\AbPerfTesting\\Experiments\\AExperimentClass',
 *
 *   # parameters to be passed to the constructor as arguments
 *	'params' => [
 *		'foo' => 25,
 *		'bar' => 42,
 *	],
 *
 *  # set of criteria to which bucket given experiment should be assigned
 *	'criteria' => [
 *       # all wikis are split into 1000 buckets (modulo of city ID), pick one here
 *		'wikis' => 1,
 *	]
 *];
**/

$wgABPerfTestingExperiments['backend_delay_25'] = [
	'handler' => 'Wikia\\AbPerfTesting\\Experiments\\BackendDelay',
	'params' => [
		'delay' => 25,
	],
	'criteria' => [
		'wikis' => 1,
	]
];

$wgABPerfTestingExperiments['backend_delay_50'] = [
	'handler' => 'Wikia\\AbPerfTesting\\Experiments\\BackendDelay',
	'params' => [
		'delay' => 50,
	],
	'criteria' => [
		'wikis' => 2,
	]
];

$wgABPerfTestingExperiments['backend_delay_100'] = [
	'handler' => 'Wikia\\AbPerfTesting\\Experiments\\BackendDelay',
	'params' => [
		'delay' => 100,
	],
	'criteria' => [
		'wikis' => 3,
	]
];
