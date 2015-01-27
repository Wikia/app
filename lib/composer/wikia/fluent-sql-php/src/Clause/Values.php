<?php

/**
 * Values
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;
use FluentSql\SQL;

class Values implements ClauseInterface {
	protected $sql;

	public function __construct($sql) {
		$this->sql = $sql;
	}

	public function build(Breakdown $bk, $tabs) {
		if ($this->sql instanceof SQL) {
			$bk->append(" (");
			$this->sql->build($bk, $tabs);
			$bk->append(" )");
		} else {
			$bk->append(" ?");
			$bk->addParameter($this->sql);
		}
	}
}
