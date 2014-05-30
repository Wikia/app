<?php

/**
 * Intersect
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

class Intersect implements ClauseInterface {
	protected $all;
	protected $sql;

	public function __construct($all, $sql) {
		$this->all = $all;
		$this->sql = $sql;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(" INTERSECT");
		if ($this->all) {
			$bk->append(" ALL");
		}
		$this->sql->build($bk, $tabs);
	}
}
