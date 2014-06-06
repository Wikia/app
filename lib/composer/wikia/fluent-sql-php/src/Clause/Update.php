<?php

/**
 * Update
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

class Update implements ClauseInterface {
	protected $table;

	public function __construct($table) {
		$this->table = $table;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(" ".$this->table);
	}
}
