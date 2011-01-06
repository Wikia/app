<?php

$messages = array();

$messages['en'] = array(
	'showperformancestats-desc' => 'Returns human-readable performance statistics',
	'performancestat-total' => 'Total: $1s',
	'performancestat-apache' => 'Apache: $1s',
	'performancestat-cpu' => 'CPU: $1s'
);

/**
 * Message documentation
 */
$messages['qqq'] = array(
	'showperformancestats-desc' => "{{desc}}",
	'performancestat-total' => "Total time (in seconds) calculated from Varnish End time minus Varnish Start time.",
	'performancestat-apache' => "Apache time (in seconds).",
	'performancestat-cpu' => "CPU time (in seconds)."
);
