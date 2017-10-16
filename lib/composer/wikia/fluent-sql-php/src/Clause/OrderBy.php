<?php

/**
 * OrderBy
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

class OrderBy implements ClauseInterface {
	protected $column;
	protected $asc;

	public function __construct($column, $asc=true) {
		$this->column = $column;
		$this->asc = $asc;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(" ".$this->column);

		if (!$this->asc) {
			$bk->append(" DESC");
		}
	}

	public function asc($asc=null) {
		if ($asc !== null) {
			$this->asc = $asc;
		}

		return $this->asc;
	}
}
