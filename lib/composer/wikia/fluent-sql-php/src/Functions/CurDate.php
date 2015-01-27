<?php

/**
 * CurDate
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Functions;

use FluentSql\Clause\IntervalAble;

class CurDate extends SqlFunction {
	use IntervalAble;

	const TYPE = 'CURDATE';

	public function __construct() {
		$this->function = self::TYPE;
		$this->functionFields = [];
	}
}
