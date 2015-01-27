<?php

/**
 * Now
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Functions;

use FluentSql\Clause\IntervalAble;

class Now extends SqlFunction {
	use IntervalAble;

	const TYPE = 'NOW';

	public function __construct() {
		$this->function = self::TYPE;
		$this->functionFields = [];
	}
}
