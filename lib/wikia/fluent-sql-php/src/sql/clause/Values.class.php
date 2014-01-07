<?php
/**
 * Values
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

class Values implements ClauseBuild {
	protected $sql;

	public function __construct($sql) {
		$this->sql = $sql;
	}

	public function build(Breakdown $bk, $tabs) {
		if ($this->sql instanceof SQL) {
			$bk->append(" (");
			$this->sql->build($bk, $tabs);
			$bk->append(" )");
		} else {
			$bk->append(" ?");
			$bk->addParameter($this->sql);
		}
	}
}