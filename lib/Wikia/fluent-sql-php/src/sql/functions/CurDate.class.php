<?php
/**
 * CurDate
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;


class CurDate extends Functions {
	use IntervalAble;

	const TYPE = 'CURDATE';

	public function __construct() {
		$this->function = self::TYPE;
		$this->functionFields = [];
	}
}