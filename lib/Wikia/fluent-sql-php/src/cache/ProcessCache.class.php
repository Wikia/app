<?php
/**
 * ProcessCache
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

class ProcessCache extends Cache {
	static $cache = [];

	public function get($key) {
		$result = false;

		if (isset(self::$cache[$key])) {
			$result = self::$cache[$key];
		}

		return $result;
	}

	public function set($key, $value, $ttl) {
		self::$cache[$key] = $value;
		return true;
	}
}