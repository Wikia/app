<?php
/**
 * MathTask
 *
 * dummy math class for testing puposes
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Tasks;


class MathTask extends BaseTask {
	public function add($x, $y) {
		return $x + $y;
	}

	public function multiply($x, $y) {
		return $x*$y;
	}
} 