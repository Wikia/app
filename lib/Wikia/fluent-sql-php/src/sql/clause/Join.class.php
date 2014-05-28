<?php
/**
 * Join
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

class Join implements ClauseBuild {
	use AsAble;

	const INNER_JOIN = "INNER JOIN";
	const LEFT_JOIN = "LEFT JOIN";
	const LEFT_OUTER_JOIN = "LEFT OUTER JOIN";
	const RIGHT_JOIN = "RIGHT JOIN";
	const RIGHT_OUTER_JOIN = "RIGHT OUTER JOIN";
	const CROSS_JOIN = "CROSS JOIN";

	protected $joinType;
	protected $table;
	protected $on;
	protected $using;

	public function __construct($joinType, $table) {
		$this->joinType = $joinType;
		$this->table = $table;
		$this->on = $this->using = [];
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(" ".$this->joinType);
		$bk->append(" ".$this->table);
		$bk->appendAs($this->as_());
		$this->buildUsing($bk, $tabs);
		$this->buildOn($bk, $tabs);
	}

	public function buildOn(Breakdown $bk, $tabs) {
		$doOnJoinClause = true;
		foreach ($this->on as $on) {
			$bk->append(Clause::line($tabs+2));
			if ($doOnJoinClause) {
				$bk->append(" ON");
				$doOnJoinClause = false;
			} else {
				$bk->append(" AND");
			}
			$on->build($bk, $tabs);
		}
	}

	public function buildUsing(Breakdown $bk, $tabs) {
		$doUsingClause = true;
		$doCommaUsing = false;
		foreach ($this->using as $using) {
			/** @var Using $using */
			if ($doUsingClause) {
				$bk->append(Clause::line($tabs+2));
				$bk->append(" USING");
				$doUsingClause = false;
			}
			if ($doCommaUsing) {
				$bk->append(",");
			} else {
				$doCommaUsing = true;
			}
			$using->build($bk, $tabs);
		}
	}

	public function addOn($on) {
		$this->on []= $on;
	}

	public function addUsing($using) {
		$this->using []= $using;
	}
}