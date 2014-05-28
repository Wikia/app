<?php
/**
 * On
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

class On implements ClauseBuild {
	protected $column1;
	protected $column2;

	public function __construct($col1, $col2 = null) {
		$this->column1 = $col1;
		$this->column2 = $col2;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->line($tabs+2);
		$bk->append(" ".$this->column1);

		if ($this->column2) {
			$bk->append(" = ");
			$bk->append(" ".$this->column2);
		}
	}
}