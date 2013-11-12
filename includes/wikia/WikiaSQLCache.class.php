<?php
/**
 * WikiaSQLCache
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

class WikiaSQLCache extends FluentSql\Cache {
	public function generateKey(\FluentSql\Breakdown $breakDown) {
		$stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
		$keyArgs = ['sql-cache'];

		if (isset($stack[2])) { // index0=this, index1=SQL->run(), index 2=whoever called "run"
			$caller = $stack[2];

			if (isset($caller['class'])) {
				$keyArgs []= $caller['class'];
			}

			if (isset($caller['function'])) {
				$keyArgs []= $caller['function'];
			}
		}

		$keyArgs []= parent::generateKey($breakDown);

		return call_user_func_array('wfMemcKey', $keyArgs);
	}

	public function get(\FluentSql\Breakdown $breakDown, $key) {
		global $wgMemc;
		return $wgMemc->get($key);
	}

	public function set(\FluentSql\Breakdown $breakDown, $value, $ttl, $key) {
		global $wgMemc;
		return $wgMemc->set($key, $value, $ttl);
	}
}