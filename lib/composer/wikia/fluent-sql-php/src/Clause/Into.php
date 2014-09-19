<?php

/**
 * Into
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

class Into implements ClauseInterface {
	protected $table;
	protected $columns;

	public function __construct($table, $columns=null) {
		$this->table = $table;
		$this->columns = $columns;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->line($tabs + 1);
		$bk->append(" INTO");
		$bk->append(" ".$this->table);

		if ($this->columns != null) {
			$bk->append(' (');
			$bk->append(implode(', ', $this->columns));
			$bk->append(') VALUES');
		}
	}
}
