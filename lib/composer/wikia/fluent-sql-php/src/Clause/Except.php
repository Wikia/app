<?php

/**
 * Except
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

class Except implements ClauseInterface {
	protected $all;
	protected $sql;

	public function __construct($all, $sql) {
		$this->all = $all;
		$this->sql = $sql;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(" EXCEPT");
		if ($this->all) {
			$bk->append(" ALL");
		}
		$this->sql->build($bk, $tabs);
	}
}
