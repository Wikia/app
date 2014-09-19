<?php
/**
 * WikiaSQLCache
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

class WikiaSQLCache extends FluentSql\Cache\Cache {
	/**
	 * @param \FluentSql\Breakdown $breakDown
	 * @param bool $sharedKey whether or not this memkey is shared amongst wikis
	 * @return string a memcache key to use
	 */
	public function generateKey(\FluentSql\Breakdown $breakDown, $sharedKey) {
		$stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 4);
		$keyArgs = ['sql-cache'];

		if (isset($stack[3])) { // 0=this, 1=WikiaSQL->getCacheKey, 2=SQL->run(), 3=whoever called "run"
			$caller = $stack[3];

			if (isset($caller['class'])) {
				$keyArgs []= $caller['class'];
			}

			if (isset($caller['function'])) {
				$keyArgs []= $caller['function'];
			}
		}

		$keyArgs []= parent::generateKey($breakDown);
		$func = $sharedKey ? 'wfSharedMemcKey' : 'wfMemcKey';

		return call_user_func_array($func, $keyArgs);
	}

	public function get($key) {
		global $wgMemc;
		return $wgMemc->get($key);
	}

	public function set($key, $value, $ttl) {
		global $wgMemc;
		return $wgMemc->set($key, $value, $ttl);
	}
}