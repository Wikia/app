<?php

namespace Wikia\AbPerformanceTesting;

abstract class Experiment {

	/**
	 * @param array $params experiment parameters
	 */
	abstract function __construct( Array $params );

	/**
	 * Bind a function to a hook
	 *
	 * @param string $hookName
	 * @param callable $func function to bind
	 */
	protected function on( $hookName, callable $func ) {
		global $wgHooks;
		$wgHooks[$hookName][] = $func;
	}

	/**
	 * Should the given experiment be enabled in the current context?
	 *
	 * @param array $experimentData
	 * @return boolean
	 */
	static function isEnabled( Array $experimentData ) {
		if ( empty( $experimentData['criteria'] ) ) {
			return false;
		}

		foreach ( $experimentData['criteria'] as $criterion => $value ) {
			if ( !Criterion::factory( $criterion )->matches( $value ) ) {
				return false;
			}
		}

		return true;
	}
}
