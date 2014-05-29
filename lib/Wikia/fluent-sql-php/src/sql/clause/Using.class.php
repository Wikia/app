<?php
/**
 * Using
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

class Using implements ClauseBuild {
	protected $column;

	public function __construct($column) {
		$this->column = $column;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(" ".$this->column);
	}
}