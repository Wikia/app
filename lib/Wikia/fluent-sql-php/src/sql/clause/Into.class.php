<?php
/**
 * Into
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

class Into implements ClauseBuild {
	protected $table;

	public function __construct($table) {
		$this->table = $table;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(Clause::line($tabs+1));
		$bk->append(" INTO");
		$bk->append(" ".$this->table);
	}
}