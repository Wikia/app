<?php

/**
 * Where
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

class Where implements ClauseInterface {
	protected $conditions;

	public function __construct() {
		$this->conditions = [];
	}

	public function add(Condition $condition) {
		$this->conditions []= $condition;
	}

	public function and_($condition) {
		if (!($condition instanceof Condition)) {
			$condition = new Condition($condition);
		}

		$condition->connector(Condition::AND_);
		$this->add($condition);
	}

	public function or_($condition) {
		if (!($condition instanceof Condition)) {
			$condition = new Condition($condition);
		}

		$condition->connector(Condition::OR_);
		$this->add($condition);
	}

	public function build(Breakdown $bk, $tabs) {
		$doWhere = true;
		/** @var Condition $condition */
		foreach ($this->conditions as $condition) {
			if ($doWhere) {
				$bk->line($tabs + 1);
				$bk->append(" WHERE");
				$doWhere = false;
			} else {
				$bk->line($tabs + 1);
				$bk->append(" ".$condition->connector());
			}

			$condition->build($bk, $tabs);
		}
	}

	public function conditions($condition=null) {
		if ($condition != null) {
			$this->conditions []= $condition;
		}

		return $this->conditions;
	}
}
