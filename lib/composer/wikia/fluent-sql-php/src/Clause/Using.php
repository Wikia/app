<?php

/**
 * Using
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

class Using implements ClauseInterface {
	protected $column;

	public function __construct($column) {
		$this->column = $column;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(" ".$this->column);
	}
}
