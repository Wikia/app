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

	protected function query($db, sql\Breakdown $breakDown, callable $callback) {
		if ($this->skipIfCondition) {
			return false;
		}

		return parent::query($db, $breakDown, $callback);
	}

	protected function getCache() {
		static $cache = null;

		if ($cache === null) {
			$cache = new WikiaSQLCache();
		}

		return $cache;
	}

	/**
	 * @param DatabaseBase $db
	 * @param string $preparedSql
	 * @param array $params
	 * @return mixed
	 */
	public function injectParams($db, sql\Breakdown $breakDown) {
		return $db->fillPrepared($breakDown->getSql(), $breakDown->getParameters());
	}

	public function skipSqlIf($condition) {
		$this->skipIfCondition = $condition;
		return $this;
	}
}