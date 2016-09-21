<?php

/**
 * SQL
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

use FluentSql\Cache\ProcessCache;
use FluentSql\Clause\Condition;
use FluentSql\Clause\Where;
use FluentSql\Exception\SqlException;
use FluentSql\Functions\SqlFunction;

class SQL {

	/** @const FORCE_NON_NUMERIC_LIMIT whether to force using non numeric LIMIT clause, e.g. a subquery */
	const FORCE_NON_NUMERIC_LIMIT = true;

	/** @const FORCE_NON_NUMERIC_OFFSET whether to force using non numeric OFFSET clause, e.g. a subquery */
	const FORCE_NON_NUMERIC_OFFSET = true;

	/**
	 * order in which relevant functions are called so future calls can modify them
	 * (like ->EQUAL_TO() modifying ->WHERE())
	 * @var array
	 */
	protected $callOrder = [];

	/** @var array with queries this statement uses */
	protected $withQueries = [];

	/** @var Clause\Type type of query (select, update, delete, etc)*/
	protected $type;

	/** @var array Clause\Field being selected */
	protected $fields = [];

	/** @var array SqlFunction being used */
	protected $functions = [];

	/** @var array SET statements */
	protected $set = [];

	/** @var array DISTINCT statements */
	protected $distinctColumns = [];

	/** @var array DISTINCTON statements */
	protected $distinctOnColumns = [];

	/** @var Clause\From FROM statement*/
	protected $from;

	/** @var Clause\Update UPDATE statement*/
	protected $update;

	/** @var Clause\Into INTO statement*/
	protected $into;

	/** @var Clause\OnDuplicateKeyUpdate ON DUPLICATE KEY UPDATE statement */
	protected $onDuplicateKeyUpdate;

	/** @var bool whether or not this SQL has added a comma to its $fields output */
	protected $doCommaField = false;

	/** @var array Clause\Values being used in this SQL (such as parameters, other SQL as parameters) */
	protected $values = [];

	/** @var array Clause\Join objects this SQL uses */
	protected $joins = [];

	/** @var array Clause\Union objects this SQL uses */
	protected $union = [];

	/** @var array Clause\Intersect objects this SQL uses */
	protected $intersect = [];

	/** @var array Clause\Except objects this SQL uses */
	protected $except = [];

	/** @var Clause\Where WHERE statement wrapper*/
	protected $where;

	/** @var array Clause\OrderBy objects specifying how to order the results of this SQL */
	protected $orderBy = [];

	/** @var array Clause\GroupBy objects specifying how to group this SQL */
	protected $groupBy = [];

	/** @var Clause\Having HAVING statement */
	protected $having;

	/** @var Clause\Limit LIMIT statement */
	protected $limit;

	/** @var Clause\Offset OFFSET statement */
	protected $offset;

	/** @var string cache key used to store results */
	protected $cacheKey;

	/** @var bool whether or not to cache empty results from the query */
	protected $cacheEmpty = false;

	/** @var int how long to cache the results of this query */
	protected $cacheTtl = 0;

	/** @var mixed some database object to run this SQL against */
	protected $db;

	/** @var string raw sql query to run, skipping the sql constructs this class provides */
	protected $rawSql;

	/** @var array parameters for $rawSql (if it is a prepared statement) */
	protected $rawParameters;

	/**
	 * add a clause to the list of clauses that have been called
	 *
	 * @param ClauseInterface $call the call that was just made
	 * @return SQL
	 */
	private function called(Clause\ClauseInterface $call) {
		$this->callOrder []= $call;

		return $this;
	}

	/** @return bool whether or not the type for this SQL has been specified yet */
	public function hasType() {
		return $this->type != null;
	}

	/** @return string the type of query (SELECT, UPDATE, etc) */
	public function getType() {
		return $this->type->type();
	}

	/**
	 * set this object to run a raw sql query
	 *
	 * @param string $sql the sql to run
	 * @param array $params parameters to pass to $sql
	 * @return SQL
	 */
	public function RAW($sql, $params=[]) {
		$this->rawSql = $sql;
		$this->rawParameters = $params;

		return $this;
	}

	/**
	 * WITH statement
	 *
	 * @param $name
	 * @param SQL $sql
	 * @return SQL
	 */
	public function WITH($name, SQL $sql) {
		$with = new Clause\With($name,$sql,false);
		$this->withQueries []= $with;

		return $this->called($with);
	}

	/**
	 * WITH RECURSIVE statement
	 *
	 * @param $name
	 * @param SQL $sql
	 * @return SQL
	 */
	public function WITH_RECURSIVE($name, SQL $sql) {
		$with = new Clause\With($name,$sql,true);
		$this->withQueries []= $with;

		return $this->called($with);
	}

	/**
	 * shortcut for SELECT('*')
	 *
	 * @return SQL
	 */
	public function SELECT_ALL() {
		return $this->SELECT("*");
	}

	/**
	 * set this query type as a SELECT query, and optionally add some Fields to select
	 *
	 * @param string $args,...
	 * @return SQL
	 */
	public function SELECT(/** args */) {
		$this->type = new Clause\Type(Clause\Type::SELECT);
		$this->called($this->type);

		foreach (func_get_args() as $col) {
			$this->FIELD($col);
		}

		return $this;
	}

	/**
	 * set this query to an UPDATE type
	 *
	 * @param string $table the table to update
	 * @return SQL
	 */
	public function UPDATE($table) {
		$this->type = new Clause\Type(Clause\Type::UPDATE);
		$this->called($this->type);
		$this->update = new Clause\Update($table);

		return $this->called($this->update);
	}

	/**
	 * set this query to an INSERT type
	 *
	 * @param string|null $table the table to insert into
	 * @param array|null $columns the list of columns for a VALUES insert
	 * @return $this
	 */
	public function INSERT($table=null, $columns=null) {
		$this->type = new Clause\Type(Clause\Type::INSERT);
		$this->called($this->type);

		if ($table !== null) {
			$this->INTO($table, $columns);
		}

		return $this;
	}

	/**
	 * ON DUPLICATE clause for an INSERT statement
	 *
	 * @param array $columns
	 * @return SQL
	 * @throws SqlException if there is no INTO found
	 */
	public function ON_DUPLICATE_KEY_UPDATE( array $columns ) {
		$this->onDuplicateKeyUpdate = new Clause\OnDuplicateKeyUpdate( $columns );

		return $this->called( $this->onDuplicateKeyUpdate );
	}

	/**
	 * set this query to a DELETE type
	 *
	 * @param string|null $table the table to delete from
	 * @return $this
	 */
	public function DELETE($table=null) {
		$this->type = new Clause\Type(Clause\Type::DELETE);
		$this->called($this->type);

		if ($table !== null) {
			$this->FROM($table);
		}

		return $this;
	}

	/**
	 * add a DISTINCT statement
	 *
	 * @param string $arg,... distinct column to add
	 * @return SQL
	 */
	public function DISTINCT(/** args */) {
		foreach (func_get_args() as $col) {
			$distinct = new Clause\Distinct($col);
			$this->distinctColumns []= $distinct;
			$this->called($distinct);
		}

		return $this;
	}

	/**
	 * add a DISTINCT ON statement
	 *
	 * @param string $arg,... distinct column to add
	 * @return SQL
	 */
	public function DISTINCT_ON(/** args */) {
		foreach (func_get_args() as $col) {
			$distinctOn = new Clause\DistinctOn($col);
			$this->distinctOnColumns []= $distinctOn;
			$this->called($distinctOn);
		}

		return $this;
	}

	/**
	 * add a Clause\Field to this SQL
	 *
	 * @param string $arg,... field to add
	 * @return SQL
	 */
	public function FIELD(/** args */) {
		foreach (func_get_args() as $sql) {
			$field = new Clause\Field($sql);
			$this->fields []= $field;
			$this->called($field);
		}

		return $this;
	}

	/**
	 * add a CASE statement
	 *
	 * @param SQL|mixed|null $value
	 * @return SQL
	 */
	public function CASE_($value=null) {
		$case = new Clause\Cases($value);
		$this->called($case);
		$this->FIELD($case);

		return $this;
	}

	/**
	 * case WHEN when comparing to a field (so it doesn't get quoted and escaped)
	 *
	 * @param string $when column to check
	 * @return SQL
	 */
	public function WHEN_FIELD($when) {
		return $this->WHEN($when, false);
	}

	/**
	 * case WHEN
	 *
	 * @param mixed|SQL $when the value (column, integer, string, or SQL) to check
	 * @param bool $convertToValues whether or not $when should be converted to a Values
	 * @return SQL
	 * @throws \Exception if there was no CASE statement called before
	 */
	public function WHEN($when, $convertToValues=true) {
		$case = $this->getLast('Cases');

		if ($case === null) {
			throw new \Exception('unable to find CASE statement');
		}

		if (!($when instanceof Clause\Condition) || $when instanceof SQL) {
			$when = $convertToValues ? new Clause\Values($when) : $when;
			$when = new Clause\Condition($when);
		}

		$this->called($when);
		/** @var Clause\Cases $case */
		$case->addWhen($when);

		return $this;
	}

	/**
	 * add a THEN statement (after a WHEN)
	 *
	 * @param mixed|SQL $then
	 * @return SQL
	 * @throws \Exception if there is no case statement
	 */
	public function THEN($then) {
		$case = $this->getLast('Cases');

		if ($case === null) {
			throw new \Exception('unable to find CASE statement');
		}

		/** @var Clause\Cases $case */
		$case->addThen($then);

		return $this;
	}

	/**
	 * add an ELSE statement (to a CASE)
	 *
	 * @param mixed|SQL $else
	 * @return $this
	 * @throws \Exception if there is no case statement
	 */
	public function ELSE_($else) {
		$case = $this->getLast('Cases');

		if ($case === null) {
			throw new \Exception('unable to find CASE statement');
		}

		/** @var Clause\Cases $case */
		$case->else_($else);

		return $this;
	}

	/**
	 * @param $sql
	 * @return SQL
	 */
	public function SUM($sql) {
		return $this->function_(SqlFunction::SUM, new Clause\Field($sql));
	}

	/**
	 * @param $sql
	 * @return SQL
	 */
	public function COUNT($sql) {
		return $this->function_(SqlFunction::COUNT, new Clause\Field($sql));
	}

	/**
	 * @param $sql
	 * @return SQL
	 */
	public function MAX($sql) {
		return $this->function_(SqlFunction::MAX, new Clause\Field($sql));
	}

	/**
	 * @param $sql
	 * @return SQL
	 */
	public function MIN($sql) {
		return $this->function_(SqlFunction::MIN, new Clause\Field($sql));
	}

	/**
	 * @param $sql
	 * @return SQL
	 */
	public function AVG($sql) {
		return $this->function_(SqlFunction::AVG, new Clause\Field($sql));
	}

	/**
	 * @param $sql
	 * @return SQL
	 */
	public function LOWER($sql) {
		return $this->function_(SqlFunction::LOWER, new Clause\Field($sql));
	}

	/**
	 * @param $sql
	 * @return SQL
	 */
	public function UPPER($sql) {
		return $this->function_(SqlFunction::UPPER, new Clause\Field($sql));
	}

	/**
	 * @return SQL
	 */
	public function NOW() {
		return $this->function_(new Functions\Now());
	}

	/**
	 * @return SQL
	 */
	public function CURDATE() {
		return $this->function_(new Functions\CurDate());
	}

	/**
	 * attach an AS to a previously called statement
	 * @param string $as alias for column, function, etc
	 * @return SQL
	 * @throws \Exception if there is no AsAble to attach to
	 */
	public function AS_($as) {
		$lastCall = $this->getLast('AsAble', 'trait');

		if ($lastCall === null) {
			throw new \Exception('unable to find AsAble');
		}

		/** @var Clause\AsAble $lastCall */
		$lastCall->as_($as);

		return $this;
	}

	/**
	 * @param string $table
	 * @return SQL
	 */
	public function FROM($table) {
		$this->from = new Clause\From($table);

		return $this->called($this->from);
	}

	/**
	 * @param string $table
	 * @return SQL
	 */
	public function LEFT_JOIN($table) {
		return $this->JOIN($table, Clause\Join::LEFT_JOIN);
	}

	/**
	 * @param string $table
	 * @return SQL
	 */
	public function RIGHT_JOIN($table) {
		return $this->JOIN($table, Clause\Join::RIGHT_JOIN);
	}

	/**
	 * @param string $table
	 * @return SQL
	 */
	public function INNER_JOIN($table) {
		return $this->JOIN($table, Clause\Join::INNER_JOIN);
	}

	/**
	 * @param string $table
	 * @return SQL
	 */
	public function CROSS_JOIN($table) {
		return $this->JOIN($table, Clause\Join::CROSS_JOIN);
	}

	/**
	 * @param string $table
	 * @return SQL
	 */
	public function LEFT_OUTER_JOIN($table) {
		return $this->JOIN($table, Clause\Join::LEFT_OUTER_JOIN);
	}

	/**
	 * @param string $table
	 * @return SQL
	 */
	public function RIGHT_OUTER_JOIN($table) {
		return $this->JOIN($table, Clause\Join::RIGHT_OUTER_JOIN);
	}

	/**
	 * add a JOIN statement
	 *
	 * @param string $table table to join against
	 * @param string $type type of join (inner, outer, etc)
	 * @return SQL
	 */
	public function JOIN($table, $type=Clause\Join::INNER_JOIN) {
		$join = new Clause\Join($type, $table);
		$this->joins []= $join;

		return $this->called($join);
	}

	/**
	 * ON statement for a JOIN statement
	 * @return SQL
	 * @throws SqlException if there is no JOIN found
	 */
	public function ON() {
		$args = func_get_args();
		$column1 = $args[0];
		$column2 = isset($args[1]) ? $args[1] : null;

		$on = new Clause\On($column1, $column2);
		$join = $this->getLast('Join');

		if ($join === null) {
			throw new SqlException('using ON without a JOIN');
		}

		/** @var Clause\Join $join */
		$join->addOn($on);

		return $this->called($on);
	}

	/**
	 * if called with column 1 and 2, this is an AND from a JOIN context,
	 * if called with only column 1 this is an AND from a WHERE context
	 *
	 * @param $column1
	 * @param $column2
	 * @return $this
	 */
	public function AND_($column1, $column2=null) {
		if ($column2 !== null) {
			return $this->ON($column1, $column2);
		} else {
			/** @var Where $where */
			$where = $this->getLast('Where');
			if ($where == null) {
				return $this->WHERE($column1);
			}

			$condition = new Clause\Condition($column1);
			$where->and_($condition);

			return $this->called($condition);
		}
	}

	public function USING(/** args */) {
		$join = $this->getLast('Join');

		if ($join === null) {
			throw new \Exception('unable to find JOIN');
		}

		/** @var Clause\Using $using */
		$using = new Clause\Using(func_get_args());

		$join->addUsing($using);
		$this->called($using);

		return $this;
	}

	public function UNION(SQL $sql, $all=false) {
		$union = new Clause\Union($all, $sql);
		$this->union []= $union;

		return $this->called($union);
	}

	public function UNION_ALL(SQL $sql) {
		return $this->UNION($sql, true);
	}

	public function INTERSECT(SQL $sql, $all=false) {
		$intersect = new Clause\Intersect($all, $sql);
		$this->intersect []= $intersect;

		return $this->called($intersect);
	}

	public function INTERSECT_ALL(SQL $sql) {
		return $this->INTERSECT($sql, true);
	}

	public function EXCEPT(SQL $sql, $all=false) {
		$except = new Clause\Except($all, $sql);
		$this->except []= $except;

		return $this->called($except);
	}

	public function EXCEPT_ALL(SQL $sql) {
		return $this->EXCEPT($sql, true);
	}

	public function INTO($table, $columns=null) {
		$this->into = new Clause\Into($table, $columns);

		return $this->called($this->into);
	}

	public function PLUS_INTERVAL($amount, $period='day') {
		return $this->interval('+', $amount, $period);
	}

	public function MINUS_INTERVAL($amount, $period='day') {
		return $this->interval('-', $amount, $period);
	}

	public function VALUE(/** args */) {
		foreach (func_get_args() as $arg) {
			$value = new Clause\Values($arg);
			$this->values []= $value;
			$this->called($value);
		}

		return $this;
	}

	/**
	 * @return SQL
	 */
	public function VALUES(/** args */) {
		$args = func_get_args();
		if ($this->type->type() == Clause\Type::INSERT) {
			if (count($args) == 1 && is_array($args[0])) {
				$args = $args[0];
			}

			$newArgs = [];
			foreach ($args as $valuesList) {
				$sql = rtrim(str_repeat('?, ', count($valuesList)), ', ');
				$newArgs []= StaticSQL::RAW($sql, $valuesList);
			}
			$args = $newArgs;
		}

		return call_user_func_array([$this, 'VALUE'], $args);
	}

	public function SET($field, $value, $isSql=false) {
		$set = new Clause\Set($field, $value, $isSql);
		$this->set []= $set;

		return $this->called($set);
	}

	public function SET_RAW($field, $sql) {
		return $this->SET($field, $sql, true);
	}

	public function WHERE($column) {
		if ($this->where == null) {
			$this->where = new Clause\Where();
		}

		$condition = new Clause\Condition($column);
		$this->where->add($condition);

		$this->called($this->where);
		return $this->called($condition);
	}

	public function OR_($column) {
		if ($this->where == null) {
			return $this->WHERE($column);
		}

		$condition = new Clause\Condition($column);
		$this->where->or_($condition);

		return $this->called($condition);
	}

	public function EQUAL_TO($value) {
		return $this->whereOp($value, Clause\Condition::EQUAL);
	}

	public function EQUAL_TO_FIELD($value) {
		return $this->whereOp($value, Clause\Condition::EQUAL, false);
	}

	public function GREATER_THAN($value) {
		return $this->whereOp($value, Clause\Condition::GREATER_THAN);
	}

	public function GREATER_THAN_OR_EQUAL($value) {
		return $this->whereOp($value, Clause\Condition::GREATER_THAN_OR_EQUAL);
	}

	public function LESS_THAN($value) {
		return $this->whereOp($value, Clause\Condition::LESS_THAN);
	}

	public function LESS_THAN_OR_EQUAL($value) {
		return $this->whereOp($value, Clause\Condition::LESS_THAN_OR_EQUAL);
	}

	public function NOT_EQUAL_TO($value) {
		return $this->whereOp($value, Clause\Condition::NOT_EQUAL);
	}

	public function NOT_EQUAL_TO_FIELD($value) {
		return $this->whereOp($value, Clause\Condition::NOT_EQUAL, false);
	}

	public function IS_NOT_NULL() {
		return $this->whereOp(null, Clause\Condition::IS_NOT_NULL);
	}

	public function IS_NULL() {
		return $this->whereOp(null, Clause\Condition::IS_NULL);
	}

	public function LIKE($value) {
		return $this->whereOp($value, Clause\Condition::LIKE);
	}

	public function BETWEEN($value1, $value2) {
		$this->whereOp($value1, Clause\Condition::BETWEEN);
		$this->AND_(new Clause\Values($value2));
		array_pop($this->callOrder);

		return $this;
	}

	public function IN(/** args */) {
		return $this->inHelper(func_get_args(), Clause\Condition::IN);
	}

	public function NOT_IN(/** args */) {
		return $this->inHelper(func_get_args(), Clause\Condition::NOT_IN);
	}

	public function EXIST(/** args */) {
		return $this->inHelper(func_get_args(), Clause\Condition::EXISTS);
	}

	public function NOT_EXISTS(/** args */) {
		return $this->inHelper(func_get_args(), Clause\Condition::NOT_EXISTS);
	}

	public function ORDER_BY(/** args */) {
		foreach (func_get_args() as $field) {
			if (is_array($field)) {
				list($field, $asc) = $field;
				if (is_string($asc)) {
					if (trim(strtolower($asc)) == 'asc') {
						$asc = true;
					} else {
						$asc = false;
					}
				}
			} else {
				$asc = true;
			}


			$orderBy = new Clause\OrderBy($field, $asc);
			$this->orderBy []= $orderBy;
			$this->called($orderBy);
		}

		return $this;
	}

	public function DESC() {
		$count = count($this->orderBy);

		if ($count > 0) {
			/** @var Clause\OrderBy $lastOrderBy */
			$lastOrderBy = $this->orderBy[$count - 1];
			$lastOrderBy->asc(false);

			return $this->called($lastOrderBy);
		}

		return null;
	}

	/**
	 * @return SQL
	 */
	public function GROUP_BY(/** args */) {
		foreach (func_get_args() as $arg) {
			$group = new Clause\GroupBy($arg);
			$this->groupBy []= $group;
			$this->called($group);
		}

		return $this;
	}

	public function HAVING($column) {
		if ($this->having == null) {
			$this->having = new Clause\Having();
		}

		$condition = new Clause\Condition($column);
		$this->having->add($condition);

		return $this->called($this->having);
	}

	/**
	 * @param $limit
	 * @return SQL
	 */
	public function LIMIT($limit, $allowNonNumeric = false) {
		$this->limit = new Clause\Limit($limit, $allowNonNumeric);

		return $this->called($this->limit);
	}

	public function OFFSET($offset, $allowNonNumeric = false) {
		$this->offset = new Clause\Offset($offset, $allowNonNumeric);

		return $this->called($this->offset);
	}

	/**
	 * indicate that we want to fetch from a cache and, if cache result is not found, cache
	 * the results of the database query
	 *
	 * @param int $ttl cache time to live
	 * @param string|null $cacheKey key to use for caching. if null, one will be auto generated
	 * @param bool $cacheEmpty whether or not to cache an empty result
	 * @return SQL
	 */
	public function cache($ttl, $cacheKey=null, $cacheEmpty=false) {
		$this->cacheTtl = $ttl;

		if (!empty($cacheKey)) {
			$this->cacheKey = $cacheKey;
		}

		if ($cacheEmpty) {
			$this->cacheEmpty = $cacheEmpty;
		}

		return $this;
	}

	/**
	 * run this query, fetching from/setting to the cache if there is a TTL defined
	 *
	 * @param mixed $db database to query against
	 * @param callable|null $recordProcessor callback to process a row in the result set
	 * @param mixed|array $defaultReturn default return value if we're unable to query and there is no cache value
	 * @param bool $autoIterate whether or not this class should iterate over the results for us, or if callable will handle it
	 * @return mixed|bool results returned by $callback processing of the db query result, or false on error
	 */
	public function runLoop($db, callable $recordProcessor=null, $defaultReturn=[], $autoIterate=true) {
		$breakDown = $this->build();
		$cache = $this->getCache();

		if (empty($this->cacheKey)) {
			$this->cacheKey = $this->getCacheKey($breakDown);
		}

		$result = false;

		if ($this->cacheEnabled()) {
			$result = $cache->get($this->cacheKey);
		}

		if ($result === false || $result === null) {
			$result = $this->query($db, $breakDown, $autoIterate, $recordProcessor);

			if ($this->cacheEnabled() && ($result || $this->cacheEmpty)) {
				$cache->set($this->cacheKey, $result, $this->cacheTtl);
			}
		}

		return $result === false ? $defaultReturn : $result;
	}

	public function run($db, callable $callback=null, $defaultReturn=[]) {
		return $this->runLoop($db, $callback, $defaultReturn, false);
	}

	protected function getCacheKey(Breakdown $breakDown) {
		$cache = $this->getCache();
		return $cache->generateKey($breakDown);
	}

	public function build($bk=null, $tabs=0) {
		if ($bk === null) {
			$bk = new Breakdown();
		}

		if ($this->rawSql != null) {
			$bk->append(" {$this->rawSql} ");
			foreach ($this->rawParameters as $param) {
				$bk->addParameter($param);
			}
		} else {
			$this->doCommaField = false;

			$this->buildClauseAllCTEs($bk, $tabs);
			$this->buildClauseType($bk, $tabs);
			$this->buildClauseAllDistinctOnColumns($bk, $tabs);
			$this->buildClauseAllDistinctColumns($bk, $tabs);
			$this->buildClauseAllFunctions($bk, $tabs);
			$this->buildClauseAllFields($bk, $tabs);
			$this->buildClauseInto($bk, $tabs);
			$this->buildClauseUpdate($bk, $tabs);
			$this->buildClauseAllSet($bk, $tabs);
			$this->buildClauseFrom($bk, $tabs);
			$this->buildClauseAllJoin($bk, $tabs);
			$this->buildClauseWhere($bk, $tabs);
			$this->buildClauseAllUnion($bk, $tabs);//TODO: find a resolution to whether where or union comes first
			$this->buildClauseAllIntersect($bk, $tabs);
			$this->buildClauseAllExcept($bk, $tabs);
			$this->buildClauseAllGroupBy($bk, $tabs);
			$this->buildClauseAllHaving($bk, $tabs);
			$this->buildClauseAllValues($bk, $tabs);
			$this->buildClauseOnDuplicateKeyUpdate($bk, $tabs);
			$this->buildClauseAllOrderBy($bk, $tabs);
			$this->buildClauseLimit($bk, $tabs);
			$this->buildClauseOffset($bk, $tabs);
		}

		return $bk;
	}

	private function buildClauseAllCTEs(Breakdown $bk, $tabs) {
		$doComma = false;
		foreach ($this->withQueries as $with) {
			/** @var Clause\With $with */
			$bk->line($tabs);

			if ($doComma) {
				$bk->append(',');
			} else {
				$bk->append(' WITH');
				$doComma = true;
			}

			if ($with->recursive()) {
				$bk->append(' RECURSIVE');
			}

			$with->build($bk, $tabs);
		}
	}

	private function buildClauseType(Breakdown $bk, $tabs) {
		if ($this->hasType()) {
			$this->type->build($bk, $tabs);
		}
	}

	private function buildClauseAllDistinctOnColumns(Breakdown $bk, $tabs) {
		$doDistinctClause = true;
		$parenthesisIsOpened = false;
		$doComma = false;
		$distinctIndex = 0;
		$totalDistinct = count($this->distinctOnColumns);

		if ($this->doCommaField) {
			$bk->append(',');
		}

		foreach ($this->distinctOnColumns as $distinctOn) {
			/** @var Clause\DistinctOn $distinctOn */
			if ($doComma) {
				$bk->append(',');
				$bk->line($tabs + 2);
			} else {
				$doComma = true;
			}

			if ($doDistinctClause) {
				$bk->append(' DISTINCT ON (');
				$doDistinctClause = false;
				$parenthesisIsOpened = true;
			}

			$distinctOn->build($bk, $tabs);

			if ($parenthesisIsOpened && $distinctIndex == $totalDistinct - 1) {
				$bk->append(' )');
				$parenthesisIsOpened = false;
			}

			++$distinctIndex;
		}
	}

	private function buildClauseAllDistinctColumns(Breakdown $bk, $tabs) {
		$doDistinctClause = true;
		$doComma = false;

		if ($this->doCommaField) {
			$bk->append(',');
		}

		foreach ($this->distinctColumns as $distinct) {
			/** @var Clause\Distinct $distinct */
			if ($doComma) {
				$bk->append(',');
				$bk->line($tabs + 2);
			} else {
				$doComma = true;
			}

			if ($doDistinctClause) {
				$bk->append(' DISTINCT');
				$doDistinctClause = false;
			}

			$distinct->build($bk, $tabs);
		}
	}

	private function buildClauseAllFunctions(Breakdown $bk, $tabs) {
		foreach ($this->functions as $function) {
			/** @var Clause\SqlFunction $function */
			if ($this->doCommaField) {
				$bk->append(',');
			} else {
				$this->doCommaField = true;
			}

			$function->build($bk, $tabs);
		}
	}

	private function buildClauseAllFields(Breakdown $bk, $tabs) {
		foreach ($this->fields as $field) {
			/** @var Clause\Field $field */
			if ($this->doCommaField) {
				$bk->append(',');
			} else {
				$this->doCommaField = true;
			}

			$field->build($bk, $tabs);
		}
	}

	private function buildClauseInto(Breakdown $bk, $tabs) {
		if ($this->into != null) {
			$this->into->build($bk, $tabs);
		}
	}

	private function buildClauseOnDuplicateKeyUpdate( Breakdown $bk, $tabs ) {
		if ( $this->onDuplicateKeyUpdate != null ) {
			$this->onDuplicateKeyUpdate->build( $bk, $tabs );
		}
	}

	private function buildClauseAllSet(Breakdown $bk, $tabs) {
		$doSetClause = true;
		$doCommaSetClause = false;

		foreach ($this->set as $set) {
			/** @var Clause\Set $set */
			if ($doSetClause) {
				$bk->append(' SET');
				$doSetClause = false;
			}

			if ($doCommaSetClause) {
				$bk->append(',');
			} else {
				$doCommaSetClause = true;
			}

			$set->build($bk, $tabs);
		}
	}

	private function buildClauseFrom(Breakdown $bk, $tabs) {
		if ($this->from != null) {
			$bk->line($tabs + 1);
			$this->from->build($bk, $tabs);
		}
	}

	private function buildClauseAllJoin(Breakdown $bk, $tabs) {
		foreach ($this->joins as $join) {
			/** @var Clause\Join $join */
			$bk->line($tabs + 2);
			$join->build($bk, $tabs);
		}
	}

	private function buildClauseAllUnion(Breakdown $bk, $tabs) {
		foreach ($this->union as $union) {
			/** @var Clause\Union $union */
			$bk->line($tabs + 1);
			$union->build($bk, $tabs);
			$bk->line($tabs + 1);
		}
	}

	private function buildClauseAllIntersect(Breakdown $bk, $tabs) {
		foreach ($this->intersect as $intersect) {
			/** @var Clause\Intersect $intersect */
			$bk->line($tabs);
			$bk->line($tabs);
			$intersect->build($bk, $tabs);
			$bk->line($tabs);
		}
	}

	private function buildClauseAllExcept(Breakdown $bk, $tabs) {
		foreach ($this->except as $except) {
			/** @var Clause\Except $except */
			$bk->line($tabs);
			$except->build($bk, $tabs);
		}
	}

	private function buildClauseWhere(Breakdown $bk, $tabs) {
		if ($this->where != null) {
			$this->where->build($bk, $tabs);
		}
	}

	private function buildClauseAllGroupBy(Breakdown $bk, $tabs) {
		$doCommaGroupBy = false;
		$doGroupByClause = true;

		foreach ($this->groupBy as $groupBy) {
			/** @var Clause\GroupBy $groupBy */
			if ($doGroupByClause) {
				$bk->append(' GROUP BY');
				$doGroupByClause = false;
			}

			if ($doCommaGroupBy) {
				$bk->append(',');
			} else {
				$doCommaGroupBy = true;
			}

			$groupBy->build($bk, $tabs);
		}
	}

	private function buildClauseAllHaving(Breakdown $bk, $tabs) {
		if ($this->having != null) {
			$this->having->build($bk, $tabs);
		}
	}

	private function buildClauseAllValues(Breakdown $bk, $tabs) {
		foreach ($this->values as $value) {
			/** @var Clause\Values $value */
			if ($bk->doComma) {
				$bk->append(',');
			} else {
				$bk->doComma = true;
			}

			$value->build($bk, $tabs);
		}
	}

	private function buildClauseAllOrderBy(Breakdown $bk, $tabs) {
		$doOrderByClause = true;
		$doCommaOrderBy = false;

		foreach ($this->orderBy as $orderBy) {
			/** @var Clause\OrderBy $orderBy */
			if ($doOrderByClause) {
				$bk->line($tabs + 2);
				$bk->append(' ORDER BY');
				$doOrderByClause = false;
			}

			if ($doCommaOrderBy) {
				$bk->append(',');
			} else {
				$doCommaOrderBy = true;
			}

			$orderBy->build($bk, $tabs);
		}
	}

	private function buildClauseOffset(Breakdown $bk, $tabs) {
		if ($this->offset != null) {
			$this->offset->build($bk, $tabs);
		}
	}

	private function buildClauseLimit(Breakdown $bk, $tabs) {
		if ($this->limit != null) {
			$this->limit->build($bk, $tabs);
		}
	}

	private function buildClauseUpdate(Breakdown $bk, $tabs) {
		if ($this->update != null) {
			$this->update->build($bk, $tabs);
		}
	}

	private function inHelper($args, $conditionType) {
		$condition = $this->getLastCall();

		if (count($args) > 1 || !($args[0] instanceof SQL)) {
			if (is_array($args[0])) {
				$args = $args[0];
			}

			foreach ($args as $i => $arg) {
				$args[$i] = new Clause\Values($arg);
			}
		}

		if ($condition instanceof Clause\Condition) {
			$condition->equality($conditionType);
			$condition->right(self::instanceHelper('Clause\\Field', $args));

			return $this->called($condition);
		} else {
			$condition = new Clause\Condition();
			$condition->equality($conditionType);
			$condition->right(self::instanceHelper('Clause\\Field', $args));

			$field = new Clause\Field($condition);
			$this->fields []= $field;

			return $this->called($field);
		}
	}

	private function interval($type, $amount, $period) {
		$function = $this->getLast('Function');

		if ($function === null || !self::checkTrait($function, 'IntervalAble')) {
			throw new \Exception;
		}

		/** @var Clause\IntervalAble $function */
		$function->intervalType($amount, $type, $period);
		return $this;
	}

	private function whereOp($value, $op, $convertToValue=true) {
		$condition = $this->getLastCondition();

		if ($condition == null) {
			throw new \Exception('unable to get last CONDITION');
		}

		$condition->equality($op);

		if ($value !== null) {
			if ($convertToValue) {
				$value = new Clause\Values($value);
			}

			$condition->right(new Clause\Field($value));
		}

		return $this->called($condition);
	}

	private function function_($function, Clause\Field $field=null) {
		if (!($function instanceof SqlFunction)) {
			$function = new SqlFunction($function, $field);
		}

		$this->functions []= $function;
		return $this->called($function);
	}

	private function getLastCall() {
		$size = count($this->callOrder);
		return $size > 0 ? $this->callOrder[$size - 1] : null;
	}

	/**
	 * @return null|Condition
	 */
	private function getLastCondition() {
		// give priority to having clause
		if ($this->having != null && count($this->having->conditions()) > 0) {
			$conditions = $this->having->conditions();
			$lastHavingCond = $conditions[count($conditions) - 1];

			if ($lastHavingCond instanceof Clause\Condition) {
				return $lastHavingCond;
			}
		}

		// then check where clauses
		if ($this->where != null && count($this->where->conditions()) > 0) {
			$conditions = $this->where->conditions();
			$lastWhereCond = $conditions[count($conditions) - 1];

			if ($lastWhereCond instanceof Clause\Condition) {
				return $lastWhereCond;
			}
		}

		return $this->getLast('Condition');
	}

	private function getLast($type, $checkProperty='class') {
		$size = count($this->callOrder);

		for ($i = $size - 1; $i >= 0; --$i) {
			switch ($checkProperty) {
				case 'class':
				case 'interface':
					if (is_a($this->callOrder[$i], "FluentSql\\Clause\\$type")) {
						return $this->callOrder[$i];
					}
					break;
				case 'trait':
					if (self::checkTrait($this->callOrder[$i], $type)) {
						return $this->callOrder[$i];
					}
					break;
			}

		}

		return null;
	}

	private static function instanceHelper($type, $args) {
		static $reflections = [];

		if (!array_key_exists($type, $reflections)) {
			$reflections[$type] = new \ReflectionClass("FluentSql\\{$type}");
		}

		return $reflections[$type]->newInstanceArgs($args);
	}

	private static function checkTrait($class, $trait) {
		static $traits = [];
		$askingClass = get_class($class);

		if (!isset($traits[$askingClass])) {
			$traits[$askingClass] = [];

			do {
				$traits[$askingClass] = array_merge(class_uses($class), $traits[$askingClass]);
			} while ($class = get_parent_class($class));
		}

		return in_array("FluentSql\\Clause\\{$trait}", $traits[$askingClass]);
	}

	protected function cacheEnabled() {
		return $this->cacheTtl > 0;
	}

	/**
	 * @return Cache\Cache
	 */
	protected function getCache() {
		static $cache = null;

		if ($cache === null) {
			$cache = new ProcessCache();
		}

		return $cache;
	}

	/**
	 * assumes $db has a method named "query", like mysqli or PDO
	 *
	 * @param $db
	 * @param BreakDown $breakDown
	 * @param bool $autoIterate whether we should wrap the logic of iterating through db results for the callback
	 * @param callable $callback
	 * @throws \InvalidArgumentException
	 * @return array|mixed query results
	 */
	protected function query($db, Breakdown $breakDown, $autoIterate, callable $callback=null) {
		if (!method_exists($db, 'query')) {
			throw new \InvalidArgumentException;
		}

		$sql = $this->injectParams($db, $breakDown);
		$result = $db->query($sql);

		if ($callback == null) {
			return $result;
		}

		if ($autoIterate) {
			// Wikia change begin
			\Wikia\Util\Assert::true( $result instanceof \ResultWrapper, 'FluentSQL::query - did not get ResultWrapper - instead got ' . get_class($result) );
			// Wikia change end
			$data = $this->autoIterate($result, $callback);
		} else {
			$data = $callback($result);
		}

		return $data;
	}

	/**
	 * iterates over a result object and calls $callback for each row in the result
	 * @param \PDOStatement|mixed $result result object with a fetchObject() method
	 * @param callable $callback
	 * @return array
	 */
	protected function autoIterate($result, $callback) {
		$data = [];

		while ($row = $result->fetchObject()) {
			$callback($data, $row);
		}

		return $data;
	}

	public function injectParams($db, Breakdown $breakDown) {
		$sql = $breakDown->getSql();
		$params = $breakDown->getParameters();

		foreach ($params as $p) {
			$sql = preg_replace('/\?/', "'".addslashes($p)."'", $sql, 1);
		}

		return $sql;
	}

	public function __toString() {
		return $this->build()->getSql();
	}
}
