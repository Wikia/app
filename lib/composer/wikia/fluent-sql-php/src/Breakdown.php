<?php

namespace FluentSql;

use FluentSql\Clause\Clause;

class Breakdown {
	private $sql;
	private $parameters;
	public $doComma = false;

	public function __construct($sql = '', $parameters = []){
		$this->sql = $sql;
		$this->parameters = $parameters;
	}

	public function getSql(){
		return trim($this->sql);
	}

	public function append($str){
		$this->sql .= $str;
	}

	public function appendAs($as) {
		if ($as !== null) {
			$this->append(" AS");
			$this->append(" ".$as);
		}
	}

	public function addParameter($parameter){
		$this->parameters[] = $parameter;
	}

	public function line($tabs){
		$this->append("\n");
		$this->tabs($tabs);
	}

	public function tabs($tabs){
		$this->append(str_repeat("\t", $tabs));
	}

	public function getParameters() {
		return $this->parameters;
	}

	public function __toString() {
		return $this->getSql();
	}
}
