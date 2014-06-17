<?php

/**
 * Having
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

class Having implements ClauseInterface {
	protected $conditions;

	public function __construct(Condition $condition) {
		$this->conditions = [$condition];
	}

	public function build(Breakdown $bk, $tabs) {
		$doHaving = true;
		/** @var Condition $condition */
		foreach ($this->conditions as $condition) {
			if ($doHaving) {
				$bk->line($tabs);
				$bk->append(" HAVING");
				$doHaving = false;
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
