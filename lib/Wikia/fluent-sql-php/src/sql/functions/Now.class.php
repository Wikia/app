<?php
/**
 * Now
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

class Now extends Functions {
	use IntervalAble;

	const TYPE = 'NOW';

	public function __construct() {
		$this->function = self::TYPE;
		$this->functionFields = [];
	}
}