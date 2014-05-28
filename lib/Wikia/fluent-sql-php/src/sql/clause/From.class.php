<?php
/**
 * From
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

class From implements ClauseBuild {
	use AsAble;

	protected $table;

	public function __construct($table) {
		$this->table = $table;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(" FROM");
		$bk->append(" ".$this->table);

		$bk->appendAs($this->as_());
	}
}