<?php

/**
 * Union
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

class Union implements ClauseInterface {
	protected $all;

	/** @var SQL */
	protected $sql;

	public function __construct($all, $sql) {
		$this->all = $all;
		$this->sql = $sql;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(" UNION");
		if ($this->all) {
			$bk->append(" ALL");
		}
		$this->sql->build($bk, $tabs);
	}
}
