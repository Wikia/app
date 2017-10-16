<?php

# it's ugly as hell, but I can't think of anything better to make uopz mock not existing function successfully
if ( !function_exists( 'newrelic_custom_metric') ) {
	function newrelic_custom_metric() {
		throw new Exception('Mock newrelic_custom_metric*) in your unit test');
	}
}
