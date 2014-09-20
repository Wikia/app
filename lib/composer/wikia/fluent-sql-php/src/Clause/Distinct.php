<?php

/**
 * Distinct
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;
use FluentSql\SQL;

class Distinct implements ClauseInterface {
	protected $sql;

	public function __construct($sql){
		$this->sql = $sql;
	}

	public function build(Breakdown $bk, $tabs) {
		if ($this->sql instanceof SQL) {
			$this->sql->build($bk, $tabs);
		} else {
			$bk->append(" ".$this->sql);
		}
	}
}
