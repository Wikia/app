<?php

/**
 * With
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;
use FluentSql\SQL;

class With implements ClauseInterface {
	protected $name;
	protected $recursive;
	protected $sql;

	public function __construct($name, SQL $sql, $recursive) {
		$this->name = $name;
		$this->sql = $sql;
		$this->recursive = $recursive;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(" ".$this->name);
		$bk->append(" AS ");
		if($this->sql != null){
			$bk->append(" (");
			$bk->line($tabs);
			$bk->tabs($tabs + 1);
			$this->sql->build($bk, $tabs);
			$bk->line($tabs);
			$bk->append(" )");
			$bk->line(0);
		}
	}

	public function recursive() {
		return $this->recursive;
	}
}
