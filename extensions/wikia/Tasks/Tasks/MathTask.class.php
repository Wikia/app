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
	/**
	 * add some stuff together!
	 *
	 * @param int $x some number to add
	 * @param $y int the other number to add
	 * @return mixed
	 */
	public function add($x=1, $y=2) {
		return $x + $y;
	}

	/**
	 * @param int $x
	 * @param $y int
	 * @return mixed
	 */
	public function multiply($x, $y) {
		return $x*$y;
	}
} 