<?php
/**
 * Cache
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

abstract class Cache {
	public function generateKey(Breakdown $breakDown) {
		return md5($breakDown->getSql().implode(',', $breakDown->getParameters()));
	}

	abstract public function get($key);
	abstract public function set($key, $value, $ttl);
}