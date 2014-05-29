<?php
/**
 * Offset
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

class Offset implements ClauseBuild {
	protected $offset;

	public function __construct($offset) {
		$this->offset = $offset;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(" OFFSET");
		$bk->append(" ".$this->offset);
	}
}