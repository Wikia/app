<?php
/**
 * WikiaSQL
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

use FluentSql as sql;

class WikiaSQL extends FluentSql\SQL {
	private $skipIfCondition = false;
	private $useSharedMemKey = false;

	/**
	 * @param $ttl
	 * @param $cacheKey
	 * @param $cacheEmpty
	 * @return WikiaSQL
	 */
	public function cacheGlobal($ttl, $cacheKey=null, $cacheEmpty=false) {
		$this->useSharedMemKey = true;
		return $this->cache($ttl, $cacheKey, $cacheEmpty);
	}

	protected function getCacheKey(sql\Breakdown $breakDown) {
		$cache = $this->getCache();
		return $cache->generateKey( $breakDown );
	}

	protected function query($db, sql\Breakdown $breakDown, $autoIterate, callable $callback=null) {
		if ($this->skipIfCondition) {
			return false;
		}

		return parent::query($db, $breakDown, $autoIterate, $callback);
	}

	/**
	 * @return sql\Cache|WikiaSQLCache
	 */
	protected function getCache() {
		static $cache = null;

		if ($cache === null) {
			$cache = new WikiaSQLCache( $this->useSharedMemKey );
		}

		return $cache;
	}

	/**
	 * @param DatabaseBase $db
	 * @param sql\Breakdown $breakDown
	 * @return mixed
	 */
	public function injectParams($db, sql\Breakdown $breakDown) {
		return $db->fillPrepared($breakDown->getSql(), $breakDown->getParameters());
	}

	/**
	 * skip the sql execution if the following condition evaluates to true
	 *
	 * @param bool $condition
	 * @return WikiaSQL
	 */
	public function skipIf($condition) {
		$this->skipIfCondition = $condition;
		return $this;
	}
}
