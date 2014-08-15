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
	private $cache;
	private $callingMethod = [];
	private $comments = [];

	public function __construct() {
		$stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);

		if (isset($stack[1])) { // 0=this, 1=whoever constructed this object
			$caller = $stack[1];

			if (isset($caller['class'])) {
				$this->callingMethod['class'] = $caller['class'];
			}

			if (isset($caller['function'])) {
				$this->callingMethod['function'] = $caller['function'];
			}

			$this->addComment(implode('::', $this->callingMethod));
		}
	}

	/**
	 * add a comment that's output along with this SQL statement
	 * @param string $comment
	 */
	public function addComment($comment) {
		$this->comments[] = $comment;
	}

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
		return $cache->generateKey($breakDown);
	}

	protected function query($db, sql\Breakdown $breakDown, $autoIterate, callable $callback=null) {
		if ($this->skipIfCondition) {
			return false;
		}

		return parent::query($db, $breakDown, $autoIterate, $callback);
	}

	/**
	 * @return sql\Cache\Cache
	 */
	protected function getCache() {
		if ($this->cache === null) {
			$this->cache = new WikiaSQLCache($this->callingMethod, $this->useSharedMemKey);
		}

		return $this->cache;
	}

	/**
	 * @param DatabaseBase $db
	 * @param sql\Breakdown $breakDown
	 * @return mixed
	 */
	public function injectParams($db, sql\Breakdown $breakDown) {
		return $db->fillPrepared($breakDown->getSql(), $breakDown->getParameters());
	}

	/** intercept build() and add comments */
	public function build($bk=null, $tabs=0) {
		if ($bk == null) {
			$bk = new sql\Breakdown();
		}

		foreach ($this->comments as $comment) {
			$bk->append("# $comment\n");
		}

		return parent::build($bk, $tabs);
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