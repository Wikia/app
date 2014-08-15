<?php

/**
 * Using
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

class Using implements ClauseInterface {
	protected $columns;

	public function __construct(array $columns) {
		$this->columns = $columns;
	}

	public function build(Breakdown $bk, $tabs) {
		$bk->append(join(", ", $this->columns));
	}
}
