<?php
/**
 * WikiaSQLCache
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

class WikiaSQLCache extends FluentSql\Cache\Cache {
	/** @var array */
	private $keyArgs = ['sql-cache'];

	/** @var bool */
	private $useSharedKey = false;

	/**
	 * @param array $keyArgs starting state of memcache key
	 * @param bool $useSharedKey whether or not this memkey is shared amongst wikis
	 */
	public function __construct($keyArgs=[], $useSharedKey=false) {
		$this->keyArgs = array_merge($this->keyArgs, array_values($keyArgs));
		$this->useSharedKey = $useSharedKey;
	}

	/**
	 * @param \FluentSql\Breakdown $breakDown
	 * @return string a memcache key to use
	 */
	public function generateKey(\FluentSql\Breakdown $breakDown) {
		$this->keyArgs[] = parent::generateKey($breakDown);
		$func = $this->useSharedKey ? 'wfSharedMemcKey' : 'wfMemcKey';

		return call_user_func_array($func, $this->keyArgs);
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