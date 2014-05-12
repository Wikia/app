<?php
/**
 * Set
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

class Set implements ClauseBuild {
	protected $column;
	protected $value;

	public function __construct($column, $value = null) {
		$this->column = $column;
		$this->value = $value;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(" " . $this->column);

		if ($this->value !== null) {
			$bk->append(" =");
			$bk->append(" ?");
			$bk->addParameter($this->value);
		}
	}

}