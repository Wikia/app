<?php
/**
 * Limit
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

class Limit implements ClauseBuild {
	protected $limit;

	public function __construct($limit) {
		$this->limit = $limit;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(" LIMIT");
		$bk->append(" ".$this->limit);
	}
}