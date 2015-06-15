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
	'url'    => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AbPerformanceTesting',
	'author' => [
		'[http://community.wikia.com/wiki/User:Macbre Maciej Brencz]'
	],
];

// generic classes
$wgAutoloadClasses[ 'Wikia\\AbPerformanceTesting\\Hooks'                     ] = __DIR__ . '/classes/Hooks.class.php';
$wgAutoloadClasses[ 'Wikia\\AbPerformanceTesting\\UnknownCriterionException' ] = __DIR__ . '/classes/UnknownCriterionException.class.php';

// experiments
$wgAutoloadClasses[ 'Wikia\\AbPerformanceTesting\\Experiment'                 ] = __DIR__ . '/experiments/Experiment.class.php';
$wgAutoloadClasses[ 'Wikia\\AbPerformanceTesting\\Experiments\\BackendDelay'  ] = __DIR__ . '/experiments/BackendDelay.class.php';
$wgAutoloadClasses[ 'Wikia\\AbPerformanceTesting\\Experiments\\FrontendDelay' ] = __DIR__ . '/experiments/FrontendDelay.class.php';

// criteria
$wgAutoloadClasses[ 'Wikia\\AbPerformanceTesting\\Criterion'               ] = __DIR__ . '/criteria/Criterion.class.php';
$wgAutoloadClasses[ 'Wikia\\AbPerformanceTesting\\Criteria\\OasisArticles' ] = __DIR__ . '/criteria/OasisArticles.class.php';
$wgAutoloadClasses[ 'Wikia\\AbPerformanceTesting\\Criteria\\Traffic'       ] = __DIR__ . '/criteria/Traffic.class.php';
$wgAutoloadClasses[ 'Wikia\\AbPerformanceTesting\\Criteria\\Wikis'         ] = __DIR__ . '/criteria/Wikis.class.php';

// initialize the experiments when we have full page context available (skin, title, user, etc.)
$wgHooks['AfterInitialize'][] = 'Wikia\\AbPerformanceTesting\\Hooks::onAfterInitialize';

// experiments config goes below
$wgAbPerformanceTestingExperiments = [];

/**
 * Example entry:
 *
 * $wgAbPerformanceTestingExperiments['an_experiment_42'] = [
 *  # PHP class that will be created when the experiment is considered active
 *	'handler' => 'Wikia\\AbPerformanceTesting\\Experiments\\AExperimentClass',
 *
 *  # parameters to be passed to the constructor as arguments
 *	'params' => [
 *		'foo' => 25,
 *		'bar' => 42,
 *	],
 *
 *  # set of criteria to which bucket given experiment should be assigned (all needs to be met)
 *	'criteria' => [
 *      # all wikis are split into 1000 buckets (modulo of city ID), pick one here
 *		'wikis' => 1,
 *      # all clients are split into 1000 buckets (modulo of beacon_id md5 hash), pick one here
 * 		'traffic' => 1,
 *      # run the test on Oasis and content namespaces only
 * 		'oasisArticles' => true
 *	]
 *];
 *
 * Devbox debugging of traffic criterion:
 *
 * 1. Set the beacon cookie: document.cookie = 'wikia_beacon_id=3j-YqSr9BQ'
 * 2. Set the "traffic" criterion to '158'
**/

/**
 * Wikia\\AbPerformanceTesting\\Experiments\\BackendDelay
 */
$wgAbPerformanceTestingExperiments['backend_delay_0'] = [
	'handler' => 'Wikia\\AbPerformanceTesting\\Experiments\\BackendDelay',
	'params' => [
		'delay' => 0, // control group to compare other three groups against
	],
	'criteria' => [
		'oasisArticles' => true,
		'traffic' => 0,
	]
];

$wgAbPerformanceTestingExperiments['backend_delay_1'] = [
	'handler' => 'Wikia\\AbPerformanceTesting\\Experiments\\BackendDelay',
	'params' => [
		'delay' => 100,
	],
	'criteria' => [
		'oasisArticles' => true,
		'traffic' => 1,
	]
];

$wgAbPerformanceTestingExperiments['backend_delay_2'] = [
	'handler' => 'Wikia\\AbPerformanceTesting\\Experiments\\BackendDelay',
	'params' => [
		'delay' => 200,
	],
	'criteria' => [
		'oasisArticles' => true,
		'traffic' => 2,
	]
];

$wgAbPerformanceTestingExperiments['backend_delay_3'] = [
	'handler' => 'Wikia\\AbPerformanceTesting\\Experiments\\BackendDelay',
	'params' => [
		'delay' => 300,
	],
	'criteria' => [
		'oasisArticles' => true,
		'traffic' => 3,
	]
];

/**
 * Wikia\\AbPerformanceTesting\\Experiments\\FrontendDelay
 */
$wgAbPerformanceTestingExperiments['frontend_delay_0'] = [
	'handler' => 'Wikia\\AbPerformanceTesting\\Experiments\\FrontendDelay',
	'params' => [
		'delay' => 0, // control group to compare other three groups against
	],
	'criteria' => [
		'oasisArticles' => true,
		'traffic' => 10,
	]
];

$wgAbPerformanceTestingExperiments['frontend_delay_1'] = [
	'handler' => 'Wikia\\AbPerformanceTesting\\Experiments\\FrontendDelay',
	'params' => [
		'delay' => 100,
	],
	'criteria' => [
		'oasisArticles' => true,
		'traffic' => 11,
	]
];

$wgAbPerformanceTestingExperiments['frontend_delay_2'] = [
	'handler' => 'Wikia\\AbPerformanceTesting\\Experiments\\FrontendDelay',
	'params' => [
		'delay' => 200,
	],
	'criteria' => [
		'oasisArticles' => true,
		'traffic' => 12,
	]
];

$wgAbPerformanceTestingExperiments['frontend_delay_3'] = [
	'handler' => 'Wikia\\AbPerformanceTesting\\Experiments\\FrontendDelay',
	'params' => [
		'delay' => 300,
	],
	'criteria' => [
		'oasisArticles' => true,
		'traffic' => 13,
	]
];
