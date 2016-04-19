<?php

/**
 * Offset
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

class Offset implements ClauseInterface {
	protected $offset;

	public function __construct($offset, $allowNonNumeric = false) {
		if (!$allowNonNumeric && !is_numeric($offset)) {
			 throw new \InvalidArgumentException('using non-numeric OFFSET when not allowed');
		}
		$this->offset = $offset;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(" OFFSET");
		$bk->append(" ".$this->offset);
	}
}
