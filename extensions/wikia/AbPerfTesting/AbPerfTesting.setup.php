<?php

/**
 * Performance A/B testing "framework"
 *
 * Defines a set of expirements with criterias of when to enable them
 *
 * Inspired by https://github.com/etsy/feature
 *
 * @see PLATFORM-1246
 * @author macbre
 */

$wgExtensionCredits['other'][] = [
	'name'   => 'A/B Performance Tests',
	'url'    => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AbPerfTesting',
	'author' => [
		'[http://community.wikia.com/wiki/User:Macbre Maciej Brencz]'
	],
];

// generic classes
$wgAutoloadClasses[ 'Wikia\\AbPerfTesting\\Hooks'                     ] = __DIR__ . '/classes/Hooks.class.php';
$wgAutoloadClasses[ 'Wikia\\AbPerfTesting\\UnknownCriterionException' ] = __DIR__ . '/classes/UnknownCriterionException.class.php';

// experiments
$wgAutoloadClasses[ 'Wikia\\AbPerfTesting\\Experiment'                ] = __DIR__ . '/experiments/Experiment.class.php';
$wgAutoloadClasses[ 'Wikia\\AbPerfTesting\\Experiments\\BackendDelay' ] = __DIR__ . '/experiments/BackendDelay.class.php';

// criteria
$wgAutoloadClasses[ 'Wikia\\AbPerfTesting\\Criterion'         ] = __DIR__ . '/criteria/Criterion.class.php';
$wgAutoloadClasses[ 'Wikia\\AbPerfTesting\\Criteria\\Traffic' ] = __DIR__ . '/criteria/Traffic.class.php';
$wgAutoloadClasses[ 'Wikia\\AbPerfTesting\\Criteria\\Wikis'   ] = __DIR__ . '/criteria/Wikis.class.php';

// hooks setup
$wgExtensionFunctions[] = 'Wikia\\AbPerfTesting\\Hooks::onSetup';

// experiments config goes below
$wgABPerfTestingExperiments = [];

/**
 * Example entry:
 *
 * $wgABPerfTestingExperiments['an_experiment_42'] = [
 *  # PHP class that will be created when the experiment is considered active
 *	'handler' => 'Wikia\\AbPerfTesting\\Experiments\\AExperimentClass',
 *
 *  # parameters to be passed to the constructor as arguments
 *	'params' => [
 *		'foo' => 25,
 *		'bar' => 42,
 *	],
 *
 *  # set of criteria to which bucket given experiment should be assigned
 *	'criteria' => [
 *      # all wikis are split into 1000 buckets (modulo of city ID), pick one here
 *		'wikis' => 1,
 *      # all clients are split into 1000 buckets (modulo of beacon_id md5 hash), pick one here
 * 		'traffic' => 1,
 *	]
 *];
**/

$wgABPerfTestingExperiments['backend_delay_a'] = [
	'handler' => 'Wikia\\AbPerfTesting\\Experiments\\BackendDelay',
	'params' => [
		'delay' => 25,
	],
	'criteria' => [
		'wikis' => 915,
	]
];

$wgABPerfTestingExperiments['backend_delay_b'] = [
	'handler' => 'Wikia\\AbPerfTesting\\Experiments\\BackendDelay',
	'params' => [
		'delay' => 50,
	],
	'criteria' => [
		'wikis' => 2,
	]
];

$wgABPerfTestingExperiments['backend_delay_c'] = [
	'handler' => 'Wikia\\AbPerfTesting\\Experiments\\BackendDelay',
	'params' => [
		'delay' => 100,
	],
	'criteria' => [
		'wikis' => 3,
	]
];
