<?php

/**
 * Set
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

class Set implements ClauseInterface {
	protected $column;
	protected $value;
	protected $isSql;

	public function __construct($column, $value = null, $isSql = false) {
		$this->column = $column;
		$this->value = $value;
		$this->isSql = $isSql;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(" " . $this->column);
		$bk->append(" = ");

		if ($this->isSql) {
			$bk->append($this->value);
		} else {
			$bk->append("?");
			$bk->addParameter($this->value);
		}

	}
}
