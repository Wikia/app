<?php

/**
 * In
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;
use FluentSql\SQL;

class In implements ClauseInterface {
	/**
	 * @var SQL|array
	 */
	protected $values;

	public function __construct($values) {
		$this->values = $values;
	}

	public function build(Breakdown $bk, $tabs) {
		if (!$this->hasSingleValue()) {
			$bk->append(" (");
		}

		if ($this->values instanceof SQL) {
			$this->values->build($bk, $tabs);
		} else if (!empty($this->values)) {
			$doCommaValues = false;
			foreach ($this->values as $val) {
				/** @var Values $val */
				if ($doCommaValues) {
					$bk->append(",");
				} else {
					$doCommaValues = true;
				}
				$val->build($bk, $tabs);
			}
		} else {
			$bk->append(" NULL");
		}

		if (!$this->hasSingleValue()) {
			$bk->append(" )");
		}
	}

	public function hasSingleValue() {
		return count($this->values) == 1 && $this->values[0] instanceof Values;
	}
}
