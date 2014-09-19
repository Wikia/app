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

	/**
	 * @var bool
	 */
	protected $in;

	public function __construct($values, $in=true) {
		$this->values = $values;
		$this->in = $in;
	}

	public function build(Breakdown $bk, $tabs) {
		if (!$this->in) {
			$bk->append(" NOT");
		}

		$bk->append(" IN");
		$bk->append(" (");

		if ($this->values instanceof SQL) {
			$this->values->build($bk, $tabs);
		} else {
			$bk->append(explode(',', $this->values));
		}

		$bk->append(" )");
	}
}
