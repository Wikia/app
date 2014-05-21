<?php
/**
 * With
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

class With implements ClauseBuild {
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
			$bk->append(Clause::line($tabs));
			$bk->tabs($tabs + 1);
			$this->sql->build($bk, $tabs);
			$bk->append(Clause::line($tabs));
			$bk->append(" )");
			$bk->append(Clause::line(0));
		}
	}

	public function recursive() {
		return $this->recursive;
	}
}