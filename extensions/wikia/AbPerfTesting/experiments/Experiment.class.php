<?php

namespace Wikia\AbPerfTesting;

abstract class Experiment {

	/**
	 * Bind a function to a hook
	 *
	 * @param string $hookName
	 * @param callable $func function to bind
	 */
	protected function on($hookName, callable $func) {
		global $wgHooks;
		$wgHooks[$hookName][] = $func;
	}

	/**
	 * Should the given experiment be enabled in the current context?
	 *
	 * @param array $experimentData
	 * @return boolean
	 */
	static function isEnabled(Array $experimentData) {
		// TODO: implement
		return true;
	}
}
