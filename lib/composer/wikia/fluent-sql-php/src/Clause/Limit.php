<?php

/**
 * Limit
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

class Limit implements ClauseInterface {
	protected $limit;

	public function __construct($limit, $allowNonNumeric = false) {
		if (!$allowNonNumeric && !is_numeric($limit)) {
			throw new \InvalidArgumentException('using non-numeric LIMIT when not allowed');
		}
		$this->limit = $limit;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(" LIMIT");
		$bk->append(" ".$this->limit);
	}
}
