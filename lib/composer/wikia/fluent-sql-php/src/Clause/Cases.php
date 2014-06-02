<?php

/**
 * Cases
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;
use FluentSql\SQL;

class Cases implements ClauseInterface {
	private $value;
	private $whenThen;
	private $else;

	public function __construct($value=null) {
		$this->when = $this->then = [];
		$this->else = null;

		if ($value !== null) {
			$this->value = new Values($value);
		}
	}

	public function addWhen($when) {
		$this->whenThen []= [$when];
	}

	public function addThen($then) {
		$size = count($this->whenThen);

		if ($size === 0) {
			throw new \Exception('trying to add then before when');
		}

		$this->whenThen[$size - 1][] = $then;
	}

	public function else_($else) {
		$this->else = $else;
	}

	public function build(Breakdown $breakDown, $tabs) {
		$breakDown->append(' ( CASE ');
		if ($this->value !== null) {
			$this->value->build($breakDown, $tabs);
		}

		foreach ($this->whenThen as $whenThen) {
			if (count($whenThen) != 2) {
				throw new \Exception('invalid when/then pair');
			}

			/** @var SQL|ClauseInterface $when */
			list($when, $then) = $whenThen;

			$breakDown->append(' WHEN');
			$when->build($breakDown, $tabs);
			$breakDown->append(' THEN');

			if ($then instanceof SQL) {
				$breakDown->append(' ( ');
				$then->build($breakDown, $tabs);
				$breakDown->append(' )');
			} else {
				$breakDown->append(' ?');
				$breakDown->addParameter($then);
			}
		}

		if ($this->else instanceof SQL) {
			$breakDown->append(' ( ');
			$this->else->build($breakDown, $tabs);
			$breakDown->append(' )');
		} elseif ($this->else !== null) {
			$breakDown->append(' ELSE ?');
			$breakDown->addParameter($this->else);
		}

		$breakDown->append(' END )');
	}
}
