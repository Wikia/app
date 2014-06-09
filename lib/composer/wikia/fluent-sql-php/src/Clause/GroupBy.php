<?php

/**
 * GroupBy
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;
use FluentSql\SQL;

class GroupBy implements ClauseInterface {
	protected $sql;

	public function __construct($sql) {
		$this->sql = $sql;
	}

	public function build(Breakdown $bk, $tabs) {
		if ($this->sql instanceof SQL) {
			(new Field($this->sql))->build($bk, $tabs);
		} else {
			$bk->append(" ".$this->sql);
		}
	}
}
