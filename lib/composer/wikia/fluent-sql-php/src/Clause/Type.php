<?php

/**
 * Type
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

class Type implements ClauseInterface {
	private static $types = [Type::SELECT, Type::INSERT, Type::UPDATE, Type::DELETE];

	const SELECT = "SELECT";
	const INSERT = "INSERT";
	const UPDATE = "UPDATE";
	const DELETE = "DELETE";

	protected $type;

	// TODO: throw something if the type is invalid?
	public function __construct($type) {
		if (!in_array($type, self::$types)) {
			throw new InvalidArgumentException;
		}

		$this->type = $type;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->tabs($tabs);
		$bk->append(" ".$this->type);
	}

	public function type() {
		return $this->type;
	}
}
