<?php
namespace FluentSql;

class Clause {
	public static function line($tabs) {
		return "\n".Clause::tabs($tabs);
	}

	public static function tabs($tabs) {
		$tstr = "";
		for($i = 0; $i < $tabs; $i++){
			$tstr .= "\t";
		}
		return $tstr;
	}

}
